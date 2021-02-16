<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        try{
            return Notification::orderBy("updated_at", "DESC")->limit(200)->get();
        }catch(\Exception $exception){
            return $exception->getMessage();
        }
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
        try {
            $data=$request->all();

            Notification::create($data);

            return ["message"=>"success", "ok"=>true];

        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show(Notification $notification)
    {
        //
        try {
            if ($notification) {
                return $notification;
            }else{
                return response("Ntoification not found", 400);
            }
        }catch (\Exception $exception){
            return $exception->getMessage();
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notification $notification)
    {
        //
        try {

            if ($notification){
                if($notification->update($request->all())){
                    return ["message"=>"success", "ok"=>true];
                }
                else{
                    return response("Not updated", 500);
                }

            }

        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        //
        try {
            if (!empty($notification)){
                $notification->delete();
            }
            return ["ok"=>true, "message"=>"success"];
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }
}
