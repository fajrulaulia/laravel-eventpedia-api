<?php

namespace App\Http\Controllers;
use App\Models\Event;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $currentUserId = $request->user()->id;

        $event= Event::join('users', 'events.user_id', '=', 'users.id')
            ->orderBy('events.created_at', 'ASC')
            ->select(['users.name', 'events.*'])
            ->where('users.id',"=",$currentUserId)
            ->paginate(10);

        return response()->json([
            'success'=>true,
            'message'=>  'retrieve event success',
            'data'=>$event
        ]);
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'online' => 'required',
            'contact' => 'required',
            'datetime' => 'required',
        ]));

        if($validator->fails()){
            return response()->json([
                "error" => 'validation_error',
                "message" => $validator->errors(),
            ], 422);
        }

        $currentUserId = $request->user()->id;

        $event = new Event;
        $event->title = $request->title;
        $event->subtitle = $request->subtitle;
        $event->address = $request->address;
        $event->online = $request->online;
        $event->contact = $request->contact;
        $event->datetime = $request->datetime;
        $event->user_id = $currentUserId;
        $event->save();

        return response()->json([
            'success'=>true,
            'message'=>  'event has been added',
            'data'=>$event
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,Request $request)
    {
        $currentUserId = $request->user()->id;

        $event= Event::join('users', 'events.user_id', '=', 'users.id')
        ->orderBy('events.created_at', 'ASC')
        ->select(['users.name', 'events.*'])
        ->where('users.id',"=",$currentUserId)
        ->where('events.id',"=",$id)
        ->first();
        return response()->json([
            'success'=>true,
            'message'=>  'retrieve event success',
            'data'=>$event
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'online' => 'required',
            'contact' => 'required',
            'datetime' => 'required',
        ]));

        if($validator->fails()){
            return response()->json([
                "error" => 'validation_error',
                "message" => $validator->errors(),
            ], 422);
        }

        $currentUserId = $request->user()->id;

        $event = Event::find($id);
        if(empty($event)){
            return response()->json([
                'success'=>false,
                'message'=>  'event data not found',
            ],404);
        }
        
        $event->title = $request->title;
        $event->subtitle = $request->subtitle;
        $event->address = $request->address;
        $event->online = $request->online;
        $event->contact = $request->contact;
        $event->datetime = $request->datetime;
        $event->save();

        return response()->json([
            'success'=>true,
            'message'=>  'event has been updated',
            'data'=>$event
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::find($id);
        if(empty($event)){
            return response()->json([
                'success'=>false,
                'message'=>  'event data not found',
            ],404);
        }
        $event->delete();
        return response()->json([
            'success'=>true,
            'message'=>  'event has been deleted',
            'data'=>$event
        ]);
    }
}
