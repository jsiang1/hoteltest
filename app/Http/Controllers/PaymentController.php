<?php
/**
 * @author Whelan Yap Boon Hong
 */
namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Strategy\CreditCardPaymentStrategy;
use App\Strategy\PayPalPaymentStrategy;
use App\Strategy\PaymentContext;
use Illuminate\Validation\Rule;
use SimpleXMLElement;
use Illuminate\Support\Facades\Session;
use App\Services\EncryptionService;
use Http;


class PaymentController extends Controller
{
    public function showPaymentPage(Request $request)
    {
        // Parse the XML file to retrieve payment methods
        $paymentMethods = $this->parsePaymentMethods();

        // Retrieve total price from session
        $reservationDetails = $request->session()->get('reservation');

        return view('home.payment', [
            'paymentMethods' => $paymentMethods,
            'reservationDetails' => $reservationDetails,
        ]);
    }

    private function parsePaymentMethods()
    {
        // Load the XML file
        $xmlPath = app_path('XML/payment_methods.xml');
        $xmlString = file_get_contents($xmlPath);
        $xml = new SimpleXMLElement($xmlString);

        // Extract payment methods
        $paymentMethods = [];
        foreach ($xml->method as $method) {
            $paymentMethods[] = [
                'id' => (string) $method['id'],
                'name' => (string) $method,
            ];
        }

        return $paymentMethods;
    }

    public function cancelPayment(Request $request)
    {
        // Clear the session storing reservation details
        $request->session()->forget('reservation');

        // Redirect back to the reservation form or any other page
        return redirect()->route('reservations_form')->with('success', 'Payment canceled successfully.');
    }

    public function processPayment(Request $request,EncryptionService $encryptionService)
    {
        // Validate the payment data
        $validatedData = $request->validate([
            'paymentMethod' => ['required', Rule::in(['credit_card', 'paypal'])],
            'cardholderName' => 'required|string|max:255',
            'cardNumber' => 'required|regex:/^\d{4}-\d{4}-\d{4}-\d{4}$/',
            'cardExp' => 'required|regex:/^\d{2}\/\d{2}$/',
            'cvv' => 'required|numeric',
            'billingAddress' => 'required|string',
        ]);


        $paymentMethod = $request->input('paymentMethod');
        $cardholderName = $request->input('cardholderName');
        $cardNumber = $request->input('cardNumber');
        $cardExp = $request->input('cardExp');
        $cvv = $request->input('cvv');
        $billingAddress = $request->input('billingAddress');

        $response = Http::post('http://127.0.0.1:8081/api/payment', [
            'cardNumber' => $cardNumber,
        ]);

        if ($response->successful()) {
            // Decode the JSON response
            $responseData = $response->json();

            if ($responseData['exists'] === true) {
                // Card exists, continue with payment process
                $encryptCardNumber = $encryptionService->encrypt($request->input('cardNumber'));
                $encryptCvv = $encryptionService->encrypt($request->input('cvv'));

        $request->session()->put('paymentData', [
            'paymentMethod' => $paymentMethod,
            'cardholderName' => $cardholderName,
            'cardNumber' => $encryptCardNumber,
            'cardExp' => $cardExp,
            'cvv' => $encryptCvv,
            'billingAddress' => $billingAddress,
        ]);

        // Retrieve reservation data from session
        $reservationData = $request->session()->get('reservation');
        if (!$reservationData) {
            return redirect()->back()->with('error', 'Reservation data not found. Please try again.');
        }

        // Determine payment method from the request
        $paymentMethod = $validatedData['paymentMethod'];

        // Create appropriate payment strategy based on the payment method
        if ($paymentMethod === 'credit_card') {
            $strategy = new CreditCardPaymentStrategy();
        } elseif ($paymentMethod === 'paypal') {
            $strategy = new PayPalPaymentStrategy();
        } else {
            // Handle invalid payment method (this should never happen due to validation)
            return redirect()->back()->with('error', 'Invalid payment method.');
        }

        // Create payment context with selected strategy
        $context = new PaymentContext($strategy);

        // Process payment using the selected strategy
        $paymentResult = $context->processPayment([
            'cardholderName' => $validatedData['cardholderName'],
            'cardNumber' => $validatedData['cardNumber'],
            'cardExp' => $validatedData['cardExp'],
            'cvv' => $validatedData['cvv'],
            'billingAddress' => $validatedData['billingAddress'],
            // Add other payment data as needed
        ]);

        if ($paymentResult === 'success') {
            // Redirect to a route that invokes the makeReservation method
            return redirect()->route('make_reservation', ['reservationData' => $reservationData]);
        }else{
            Session::forget('reservationData');
            Session::forget('paymentData');

            return redirect()->route('reservations_form')->with('Payment processed fail.');
        }
            } else {
                return redirect()->route('payment_page')->with('error', 'Card not found. Please re-enter your card information.');
            }
        }

    }

    public function insertPayment(Request $request)
{
    // Retrieve the reservation ID from the database
    $reservationID = Reservation::latest('reservationID')->first()->reservationID;

    $paymentData = Session::get('paymentData');

    // Create payment record
    Payment::create([
        'reservationID' => $reservationID,
        'date' => now(),
        'paymentMethod' => $paymentData['paymentMethod'],
        'cardholderName' => $paymentData['cardholderName'],
        'cardNumber' => $paymentData['cardNumber'],
        'cardExp' => $paymentData['cardExp'],
        'cvv' => $paymentData['cvv'],
        'billingAddress' => $paymentData['billingAddress'],
    ]);

    // Clear reservation ID from session
    $request->session()->forget('reservation');
    $request->session()->forget('reservationID');
    $request->session()->forget('paymentData');
    
    // Redirect or return response
    return view('home/result');
}

public function index()
    {
        // Retrieve payment data with associated reservation and user data
        $payments = Payment::with('reservation')->get();

        return view('employee.paymentlist', ['payments' => $payments]);
    }
   
}