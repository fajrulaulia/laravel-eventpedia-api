<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use App\Models\Attedance;

class AttedanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $currentUserId = $request->user()->id;

        $att= Attedance::join('events', 'attedances.event_id', '=', 'events.id')
        ->join('users', 'attedances.user_id', '=', 'users.id')
        ->where('users.id',"=",$currentUserId)
        ->orderBy('events.created_at', 'ASC')
        ->select(['attedances.id','users.name','events.title','events.datetime'])
        ->paginate(10);

        return response()->json([
            'success'=>true,
            'message'=>  'retrieve attedance success',
            'data'=>$att
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
            'event_id' => 'required|numeric|max:255',
        ]));

        if($validator->fails()){
            return response()->json([
                "error" => 'validation_error',
                "message" => $validator->errors(),
            ], 422);
        }

        $currentUserId = $request->user()->id;

        $att = new Attedance;
        $att->event_id = $request->event_id;
        $att->user_id = $currentUserId;
        $att->save();

        return response()->json([
            'success'=>true,
            'message'=>  'attedance has been added',
            'data'=>$att
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

        $att= Attedance::join('events', 'attedances.event_id', '=', 'events.id')
        ->join('users', 'attedances.user_id', '=', 'users.id')
        ->orderBy('events.created_at', 'ASC')
        ->where('attedances.id',"=",$id)
        ->where('users.id',"=",$currentUserId)
        ->select(['attedances.id','users.name','events.title','events.datetime'])
        ->first();;
        return response()->json([
            'success'=>true,
            'message'=>  'retrieve attedance success',
            'data'=>$att
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
            'event_id' => 'required|numeric|max:255',
        ]));

        if($validator->fails()){
            return response()->json([
                "error" => 'validation_error',
                "message" => $validator->errors(),
            ], 422);
        }

        $currentUserId = $request->user()->id;

        $att = Attedance::find($id);
        $att->event_id = $request->event_id;
        $att->user_id = $currentUserId;
        $att->save();

        return response()->json([
            'success'=>true,
            'message'=>  'attedance has been updated',
            'data'=>$att
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
        $att = Attedance::find($id);
        if(empty($att)){
            return response()->json([
                'success'=>false,
                'message'=>  'attedance data not found',
            ],404);
        }
        $att->delete();
        return response()->json([
            'success'=>true,
            'message'=>  'attedance has been deleted',
            'data'=>$att
        ]);
    }
}
