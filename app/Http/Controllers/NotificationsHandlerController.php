<?php namespace App\Http\Controllers;

use App\Invoice;
use App\Transformers\InvoiceTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Notification;
use App\Account;
use App\User;
use Carbon\Carbon;

class NotificationsHandlerController extends Controller
{
    public function show($uuid) {
        $user = User::findByUuid($uuid);
        return $user->notifications;
    }

    public function updateOpenedAt(Request $request, $uuid) {
        $user = User::findByUuid($uuid);
        $notifications = $user->notifications;
        foreach($notifications as $notification) {
            if($notification->opened_at == null) {
                $notification->opened_at = Carbon::now();
                $notification->save();
            }
        }
        return $this->show($uuid);
    }

    public function updateReadAt($uuid ,$id) {
        $user = User::findByUuid($uuid);
        $notification = $user->notifications->where('id', $id)->markAsRead();
    }

    public function updateAllReadAt($uuid) {
        $user = User::findByUuid($uuid);
        $notification = $user->notifications->markAsRead();
    }
}