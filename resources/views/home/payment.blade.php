<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form</title>
</head>
<body>
<h2>Payment Details</h2>
    <form action="{{ route('process_payment') }}" method="POST">
        @csrf
        <label for="payment_method">Payment Method:</label>
        <select id="payment_method" name="paymentMethod">
        @foreach ($paymentMethods as $method)
                <option value="{{ $method['id'] }}">{{ $method['name'] }}</option>
         @endforeach
        </select>
        <br><br>
        <label for="cardholder_name">Cardholder Name:</label>
        <input type="text" id="cardholder_name" name="cardholderName" required>
        <br><br>
        <label for="card_number">Card Number:</label>
        <input type="text" id="card_number" name="cardNumber" pattern="\d{4}-\d{4}-\d{4}-\d{4}" required>
        <br><br>
        <label for="card_exp">Expiration Date:</label>
        <input type="text" id="card_exp" name="cardExp" placeholder="MM/YYYY" pattern="\d{2}/\d{2}" required>
        <br><br>
        <label for="cvv">CVV:</label>
        <input type="text" id="cvv" name="cvv" pattern="\d{3}" required>
        <br><br>
        <label for="billing_address">Billing Address:</label>
        <textarea id="billing_address" name="billingAddress" required></textarea>
        <br><br>
        <div>Total Price: ${{ $reservationDetails['totalPrice'] }}</div>
        <br><br>
        <input type="submit" value="Submit Payment">
        <a href="{{ route('cancel_payment') }}" class="btn btn-danger">Cancel Payment</a>
    </form>
</body>
</html>