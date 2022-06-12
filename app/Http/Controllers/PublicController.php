<?php

namespace App\Http\Controllers;
use App\Models\Event;

use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function getEventAll(Request $request)
    {
        $event= Event::join('users', 'events.user_id', '=', 'users.id')
            ->orderBy('events.created_at', 'ASC')
            ->select(['users.name', 'events.*'])
            ->paginate(10);

        return response()->json([
            'success'=>true,
            'message'=>  'retrieve public event success',
            'data'=>$event
        ]);
    
    }
}
