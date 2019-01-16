<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\User;
use App\Cruise;
use App\Http\Controllers\UsersController;

class OrdersController extends Controller
{
    public function index(Order $order){
    	$orders = $order->all();
    	return $orders;
    }

    public function create(Cruise $cruise,Order $order, Request $request, UsersController $user){
    	$data 		= $request->data;
        $email      = $data['email'];
    	$user_id 	= $user->create($data);
        if($data['time_start'] == "NaN:NaN" && $data['time_end'] == "NaN:NaN"){
            $cr = $cruise->where('id',$data['cruise_id'])->get();
            $cr = $cr[0];
            $order->time_start = $cr->time_start;
            $order->time_end = $cr->time_end;
        }else{
            $order->time_start= $data['time_start'];
            if($data['stop']){
                $order->stop = true;
                return 
                $order->time_end  = '20:30';
            }else{
                $order->time_end  = $data['time_end'];
            }
        }
    	$order->cruise_id = $data['cruise_id'];
    	$order->user_id	  = $user_id;
    	$order->date 	  = $data['date'];
    	$order->n_persons = $data['n_persons'];
    	$order->ages 	  = json_encode($data['ages']);
        $order->status    = '';
 
    	$order->save();
    	\Mail::send('emails.test', [], function ($m) {
            $m->from('stefaniuk3007@gmail.com', 'Cruise reservation system');
            $m->to('stefaniuk3007@gmail.com', 'Receiver')->subject('Reservation of cruise.');
        });
    }

    public function check_time(Request $request, Order $order, Cruise $cruise){
        $flag   = 0;        
        $data   = $request->data;
        if($data['time_start'] == "NaN:NaN" || $data['time_end'] == "NaN:NaN"){
            $cr = $cruise->where('id',$data['cruise'])->get();
            $cr = $cr[0];
            $t_st   = strtotime(date('Y-m-d')  ." ". $cr->time_start);
            $t_ed   = strtotime(date('Y-m-d')  ." ". $cr->time_end); 
        }else{
            $t_st   = strtotime(date('Y-m-d')  ." ". $data['time_start']);
            $t_ed   = strtotime(date('Y-m-d')  ." ". $data['time_end']); 
        }        
        $orders = $order->where('date',$data['date'])->where('status','<>','option2')->get();
        foreach($orders as $ordr){
            if( $t_st > strtotime(date('Y-m-d')  ." ". $ordr->time_end) || $t_ed < strtotime(date('Y-m-d')  ." ". $ordr->time_start) ){
                
            }else{
                $flag = 1;
            }
        }
        if( $flag == 0 ){
            return 'ok';
        }else{
            return 'bad';
        }
    }
}
