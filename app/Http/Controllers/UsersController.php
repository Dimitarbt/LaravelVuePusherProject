<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
/*use Illuminate\Support\Facades\Mail;
use App\Mail\NewFollowerMail;*/
use App\Events\NewFollowerEvent;
use App\Events\NotificationEvent;
use App\Notifications\newFollower;
use Storage;
class UsersController extends Controller
{   

	public function __construct()
    {
        $this->middleware('auth');
    }
    

    public function show(User $user){

    	$users = User::where('id', '!=', auth()->user()->id)->where('id', '!=', $user->id)->get();

    	return view('users.show', compact('user', 'users'));
    }

    public function update(User $user){
        
        $data = request()->validate([
            'name' => 'required',
            'profile_photo' => 'sometimes|image|max:5000'
        ]);

        $user->update($data);

        $this->storeImage($user);

        session()->flash('status','Succesfully updated');

        return redirect()->back();
    }


    public function storeImage($user){

         if(request()->has('profile_photo')){

            $image = request()->file('profile_photo');

            $imageName = 'img-'.time().'.'.$image->getClientOriginalExtension();

            $oldPhoto = auth()->user()->profile_photo;
   
            if(empty($oldPhoto)){
                 $user->update([
                   'profile_photo' => Null,
                 ]);
            }
            else{

               if(file_exists(public_path('/storage/'.$oldPhoto))){
                    unlink(public_path('/storage/'.$oldPhoto));
                }
                
            }

           $path = $image->storeAs('uploads', $imageName, 'public');

           $user->update([
                 'profile_photo' => $path,
           ]);
            
        }

    }


    public function follow(User $user){

    	$follower = auth()->user();

    	if($follower->is_following($user->id)){
    		return redirect()->back()->with('status',"Sorry, you are friend with $user->name ");
    	}


    	$follower->follow($user->id);

        $msg = 'Started following you';

        event(new NewFollowerEvent($follower, $msg, $user));

    	//Mail::to($user->email)->send(new NewFollowerMail($follower, $msg));

    	$user->notify(new newFollower($follower,$msg));

    	event(new NotificationEvent($follower, $msg));



    	return redirect()->back()->with('status',"Now, you are friend with $user->name ");
    }


    public function unfollow(User $user){

    	$follower = auth()->user();

    	$follower->unfollow($user->id);

    	return redirect()->back()->with('status',"Now, you are not friend with $user->name ");
    }


    public function markasRead($id){

    	$n = auth()->user()->notifications->where('id', $id);

    	
    	foreach ($n as $key => $notification) {
    		//dd($value);
    	}

    	auth()->user()->notifications->where('id', $id)->markAsRead();



    	//dd($notification);
    	$users = User::where('id', '!=', auth()->user()->id)->get();

    	return view('users.display-notification', compact('notification', 'users'));
    }


    public function allNotifications($id){
    	$notifications = auth()->user()->notifications->where('notifiable_id', $id);
        
        $users = User::where('id', '!=', auth()->user()->id)->get();
    	//dd($notifications);
    	return view('users.display-all-notifications', compact('notifications', 'users'));
    }

}
