<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\User;
use App\Http\Controllers\UsersController;

class OrdersController extends Controller
{
    public function index(Order $order){
    	$orders = $order->all();
    	return $orders;
    }

    public function create(Order $order, Request $request, UsersController $user){
    	$data 		= $request->data;
    	$user_id 	= $user->create($data);

    	$order->cruise_id = $data['cruise_id'];
    	$order->user_id	  = $user_id;
    	$order->date 	  = $data['date'];
    	$order->time 	  = $data['time'];
    	$order->n_persons = $data['n_persons'];
    	$order->ages 	  = json_encode($data['ages']);

    	$order->save();
    	\Mail::send('emails.test', [], function ($m) {
            $m->from('stefaniuk3007@gmail.com', 'Cruise reservation system');
            $m->to('stefaniuk3007@gmail.com', 'Receiver')->subject('Reservation of cruise.');
        });
    }
}
