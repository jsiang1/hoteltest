@extends('employee.layout')
@section('content')
<div class="card">
    <div class="card-body">
        <div class="w3-container">
            <div class="w3-responsive">
                <h5 class="card-title fw-semibold mb-4">Review Notification</h5>
                    <table class="w3-table-all">
                        <tr>
                            <th>ID</th>
                            <th>Message</th>
                            <th>Created At</th>
                        </tr>
                        @foreach ($notifications as $notification)
                        <tr>
                            <td>{{ $notification->notificationID }}</td>
                            <td>{{ $notification->message }}</td>
                            <td>{{ $notification->created_at }}</td>
                        </tr>
                        @endforeach
                    </table>
            </div>
        </div>
    </div>
</div>
@endsection