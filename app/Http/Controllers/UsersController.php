<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function create($data){
        $user = new User();
        $user_order = $user->where('email',$data['email'])->get();
        if(count($user_order) == 0){
            $user->role_id      = 2;
            $user->name         = $data['firstName'];
            $user->email        = $data['email'];
            $user->title        = $data['gender'];
            $user->last_name    = $data['laststName'];
            $user->street       = $data['street'];
            $user->country      = $data['country'];
            $user->city         = $data['city'];
            $user->phone        = $data['phone'];
            $user->save(); 
            $user_order = $user->where('email',$data['email'])->get();
        }
        $user_id = $user_order[0]->id;
        return $user_id;
    }

    public function SignUpAgency(Request $request, User $user){
        $data = $request['data'];
        $user_order = $user->where('email',$data['email'])->get();
        if(count($user_order) == 0){
            $pass = Str::random(10);
            $user->role_id      = 3;
            $user->company      = $data['company'];
            $user->password     = Hash::make($pass);
            $user->zip          = $data['zip'];
            $user->url          = $data['url'];
            $user->name         = $data['firstName'];
            $user->email        = $data['email'];
            $user->title        = $data['gender'];
            $user->last_name    = $data['laststName'];
            $user->street       = $data['street'];
            $user->country      = $data['country'];
            $user->city         = $data['city'];
            $user->phone        = $data['phone'];
            $user->save(); 

            \Mail::send('emails.agency', [], function ($m) {
                $m->from('stefaniuk3007@gmail.com', 'Cruise reservation system');
                $m->to($data['email'], 'Receiver')->subject('Travel agency registered.');
            });

            $user_order = $user->where('email',$data['email'])->get();
        }
        $user_id = $user_order[0]->id;
        return $user_id;
    }

    public function SignInAgency(Request $request){
        $data = $request['data'];
        if (Auth::attempt(['email' => 'stefaniuk3007@gmail.com', 'password' => '12345'])) {
            return 200;
        }else{
            return 401;
        }
    }
}