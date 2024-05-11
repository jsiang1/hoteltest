@extends('employee.layout')
@section('content')
<div class="card">
    <div class="card-body">
        <div class="w3-container">
            <div class="w3-responsive">
                <h5 class="card-title fw-semibold mb-4">Edit Room</h5>
                <form action="{{ route('employee.room.update', $room) }}" method="POST">
                    @csrf
                     @method('PUT')
                     <div class="form-group">
                        <label for="roomID">Room ID:</label>
                        <input type="text" name="roomID" id="roomID" class="form-control" value="{{ $room->roomID }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="roomType">Room Type:</label>
                        <input type="text" name="roomType" id="roomType" class="form-control" value="{{ $room->roomType }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="pricePerNight">Price Per Night:</label>
                        <input type="text" name="pricePerNight" id="pricePerNight" class="form-control" value="{{ $room->pricePerNight }}">
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">Update Price</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection