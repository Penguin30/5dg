<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cruise;

class CruisesController extends Controller
{
    public function index(Cruise $cruise){
    	$cruises = $cruise->all();
    	return $cruises;
    }
}
