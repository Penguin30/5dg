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
    	$data = $request->data;
    	$user_id = $user->create($data);
    	return $user_id;
    	
    }
}
