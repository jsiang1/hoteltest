<style>
* {
  box-sizing: border-box;
}

input[type=text], select, textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  resize: vertical;
}

label {
  padding: 12px 12px 12px 0;
  display: inline-block;
}

input[type=submit] {
  background-color: #04AA6D;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  float: right;
}

input[type=submit]:hover {
  background-color: #45a049;
}

.container {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}

.col-25 {
  float: ;
  width: 25%;
  margin-top: 6px;
}

.col-75 {
  float: ;
  width: 50%;
  margin-top: 6px;
}

/* Clear floats after the columns */
.row::after {
  content: "";
  display: table;
  clear: both;
}

/* Responsive layout - when the screen is less than 600px wide, make the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 600px) {
  .col-25, .col-75, input[type=submit] {
    width: 100%;
    margin-top: 0;
  }
}
</style>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Write Review') }}
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <form action="{{ route('submit_review') }}" method="post">
    @csrf
    <input type="hidden" name="reservationID" value="{{ $reservationID }}">
    <input type="hidden" name="roomID" value="{{ $roomID }}">
            <div class="row">
    <div class="col-25">
      <label for="rate">Rate:</label>
    </div>
    <div class="col-75">
        <select id="rate" name="rate">
        @foreach ($rates as $rate)
                <option value="{{ $rate['id'] }}">{{ $rate['name'] }}</option>
         @endforeach
        </select>
    </div>

    <div class="row">
    <div class="col-25">
      <label for="comment">Comment</label>
    </div>
    <div class="col-75">
      <textarea id="comment" name="comment" placeholder="Write something.." style="height:200px"></textarea>
    </div>
  </div>
  <div class="row">
    <input type="submit" value="Submit">
  </div>
            </div>
        </div>
    </div>
    

</x-app-layout>