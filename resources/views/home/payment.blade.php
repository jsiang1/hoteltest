<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ URL::asset('w3.css') }}">
<style>
body {
  font-family: Arial;
  font-size: 17px;
  padding: 8px;
}

* {
  box-sizing: border-box;
}

.row {
  display: -ms-flexbox; /* IE10 */
  display: flex;
  -ms-flex-wrap: wrap; /* IE10 */
  flex-wrap: wrap;
  margin: 0 -16px;
}

.col-25 {
  flex: 10%;
}

.col-50 {

  flex: 20%;
}

.col-75 {

  flex: 30%;
}

.col-25,
.col-50,
.col-75 {
  padding: 0 16px;
}
input[type=text],textarea {
  width: 50%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  resize: vertical;
}
.container {
  background-color: #f2f2f2;
  padding: 5px 20px 15px 20px;
  border: 1px solid lightgrey;
  border-radius: 3px;
}

input[type=text] {
  width: 50%;
  margin-bottom: 20px;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 3px;
}

label {
  margin-bottom: 10px;
  display: block;
}

.icon-container {
  margin-bottom: 20px;
  padding: 7px 0;
  font-size: 24px;
}

.btn {
  background-color: #04AA6D;
  color: white;
  padding: 12px;
  margin: 10px 0;
  border: none;
  width: 30%;
  border-radius: 3px;
  cursor: pointer;
  font-size: 17px;
}

.btn:hover {
  background-color: #45a049;
}

a {
  color: #2196F3;
}

hr {
  border: 1px solid lightgrey;
}

span.price {
  color: grey;
}

</style>
</head>
<body>
<h2>Payment Detail</h2>
<div class="row">
  <div class="col-75">
    <div class="container">
        <form action="{{ route('process_payment') }}" method="POST">
        @csrf
          <div class="col-50">
            <h3>Payment Method</h3>
            <select id="payment_method" name="paymentMethod">
            @foreach ($paymentMethods as $method)
                <option value="{{ $method['id'] }}">{{ $method['name'] }}</option>
            @endforeach
            </select>
            <label for="cname">Cardholder Name:</label>
            <input type="text" id="cardholder_name" name="cardholderName" required>
            <label for="card_number">Card Number:</label>
            <input type="text" id="card_number" name="cardNumber" pattern="\d{4}-\d{4}-\d{4}-\d{4}" maxlength="19" required>
            <div class="error" style="color: red;">
        <span id="lbl1">@if(session('success')){!! session('success') !!}@endif</span>
        <span id="lbl2">@if(session('error')){!! session('error') !!}@endif</span>
        </div>
        <label for="card_exp">Expiration Date:</label>
        <input type="text" id="card_exp" name="cardExp" placeholder="MM/YY" pattern="\d{2}/\d{2}" required>
        <label for="cvv">CVV:</label>
        <input type="text" id="cvv" name="cvv" pattern="\d{3}" maxlength="3"required>
        <label for="billing_address">Billing Address:</label>
        <textarea id="billing_address" name="billingAddress" required></textarea>
          </div>
        <p>Total Price:<span class="price" style="color:black"><b>${{ $reservationDetails['totalPrice'] }}</b></span></p>
        <input type="submit" value="Submit Payment" class="btn">
        <a href="{{ route('cancel_payment') }}" class="w3-button w3-red">Cancel Payment</a>
      </form>
    </div>
  </div>
</div>
</body>
</html>