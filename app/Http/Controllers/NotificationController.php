<?php
/**
 * @author Pang Jin Siang
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('type', 'review')->latest()->get();
        return view('employee.reviewNotifi', compact('notifications'));
    }
}
