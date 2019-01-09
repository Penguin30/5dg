<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\User;

class UsersController extends Controller
{
    public function create($data){
        $user = new User();
        $user_order = $user->where('email',$data['email'])->get();
        if(!$user_order[0]->id){
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
            $order_details = $user->where('email',$data['email'])->get();
            $user_id = $order_details[0]->id;
        }else{
            $user_id = $user_order[0]->id;
        }
        return $user_id;
    }
}