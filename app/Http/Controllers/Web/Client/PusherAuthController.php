<?php

namespace App\Http\Controllers\Web\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;
use Pusher\Pusher;

class PusherAuthController extends Controller
{

    public function __construct(){

    }
    public function pusherAuth(Request $request)
    {
        if (Auth::check()) {
            return Broadcast::auth($request);
        }

        return response()->json(['message' => 'Unauthorized'], 403);
    }
}