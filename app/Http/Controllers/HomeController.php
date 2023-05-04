<?php

namespace App\Http\Controllers;

use App\Models\ArtistProfile;
use Carbon\Carbon;
use App\Http\Requests;
use App\Models\Job;
use Illuminate\Http\Request;
use App\Notification;
use App\Models\User;
// use App\Notifications\CustomerNotification;
use App\Notifications\dummynotification;

class HomeController extends AppBaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    // public function notify(){

    //     if(auth()->user()){

    //         $job = Job::first();
    //         $id = $job['id']; 
    //         $data = "new job posted " . $job['title'];
            
    //         auth()->user()->notify(new dummynotification($id,$data));
    //     }
        
    // }

    // public function markAsReadNotification($id){

    //     if($id){
    //         auth()->user()->unreadNotifications->where('id',$id)->markAsRead();
    //     }
    //     dd('ok');
    //     return back();

    // }


    // public function sendNotification()
    // {
    //     $user = auth()->user()->id;
  
    //     $details = [
    //         'type' => 'Customer',
    //         'user_id' => $user,
    //         'notification_for' => 1,
    //         'title' => 'Message',
    //     ];

  
    //     Notification::create($details,new CustomerNotification($details));
    //     return $details;
    // }
    // public function getNotification(){
    //     $user_id = auth()->user()->id;
    //     $artist_profile = ArtistProfile::where('user_id',$user_id)->get();
    //     $notification_null = Notification::where('notification_for', $artist_profile[0]->id)->whereNull('read_at')->get();
    //     $notification_not_null = Notification::where('notification_for', $artist_profile[0]->id)->whereNotNull('read_at')->get();
    //     return response()->json([
    //         'Read_at_=_null'=>$notification_null, 
    //         'Read_at_!=_null'=>$notification_not_null]);
        
        
    // }
    // public function markAsReadNotification(){
    //     $user_id = auth()->user()->id;
    //     $artist_profile = ArtistProfile::where('user_id',$user_id)->get();
    //     $notification_null = Notification::whereReadAt(null)->where('notification_for', $artist_profile[0]->id)->update(['read_at'=> Carbon::now()]);
    //     return response()->json(['read_at'=> $notification_null]);
    // }



}
