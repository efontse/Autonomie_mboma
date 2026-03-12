<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Liste des notifications de l'utilisateur
     */
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Marquer une notification comme lue
     */
    public function markAsRead($id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if ($notification) {
            $notification->lu = true;
            $notification->save();
        }

        return response()->json(['success' => true]);
    }

    /**
     * Marquer toutes les notifications comme lues
     */
    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('lu', false)
            ->update(['lu' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * Supprimer une notification
     */
    public function destroy($id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if ($notification) {
            $notification->delete();
        }

        return response()->json(['success' => true]);
    }

    /**
     * Nombre de notifications non lues (API)
     */
    public function unreadCount()
    {
        $count = Notification::where('user_id', Auth::id())
            ->where('lu', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    /**
     * Liste des notifications non lues (API)
     */
    public function unreadList()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->where('lu', false)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return response()->json(['notifications' => $notifications]);
    }
}

