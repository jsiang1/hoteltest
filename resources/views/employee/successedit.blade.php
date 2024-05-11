@extends('employee.layout')
@section('content')
<div class="card">
  <div class="card-body">
    <div class="w3-container">
      <div class="w3-responsive">
        
          <div class="col-md-4">
            <h5 class="card-title fw-semibold mb-4">Edit Room</h5>
            <div class="card">
              <div class="card-header">
                      Success
              </div>
              <div class="card-body">
                <div style="justify-content: center; display: flex;">
                <img src="{{URL::asset('/img/completeicon.jpg')}}">
              </div>
              <h5 class="card-title">Room Price Per Night Updated</h5>
              <a href="{{ route('employee.room.index') }}" class="btn btn-primary">OK</a>
            </div>
          </div>
        
      </div>
    </div>
  </div>
</div>
@endsection