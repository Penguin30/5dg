<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\User;

class OrdersController extends Controller
{
    public function index(Order $order){
    	$orders = $order->all();
    	return $orders;
    }

    public function create(Order $order, Request $request, User $user){
    	$data = $request->data;

    	$user->role_id 		= 2;
    	$user->name 		= $data['firstName'];
    	$user->email 		= $data['email'];
    	$user->title 		= $data['gender'];
    	$user->last_name 	= $data['laststName'];
    	$user->street 		= $data['street'];
    	$user->country 	 	= $data['country'];
    	$user->city 		= $data['city'];
    	$user->phone 		= $data['phone'];
    	$user->save();
    	return true;
    }
}
