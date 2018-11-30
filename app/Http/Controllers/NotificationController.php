<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index() {
        $notifications = Notification::where('user_id', \Auth::user()->id)
                            ->where('read', false)
                            ->get();

        $quantidade = count($notifications);
        if ( !$quantidade ) {
            return response()->json([]);
        } else {
            if ( $quantidade == 1 ) {
                return response()->json(
                    [[
                        "title" => "Nova Notificação",
                        "text" => $notifications[0]->message,
                        "url" => $notifications[0]->url,
                    ]]
                );
            } else {
                return response()->json(
                    [[
                        "title" => "Novas Notificações",
                        "text" => "Você tem " . $quantidade . " notificações novas.",
                        "url" => route('notifications'),
                    ]]
                );
            }
        }
    }

    public function list() {

        $notifications = Notification::where('user_id', \Auth::user()->id)
            ->where('read', false)
            ->get();

        return view('notifications.index')
                ->with('notifications', $notifications);
    }
}
