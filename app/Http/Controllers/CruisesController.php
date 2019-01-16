<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TCG\Voyager\Traits\Translatable;
use App\Cruise;


class CruisesController extends Controller
{
	use Translatable;

    public function index(Request $request, Cruise $cruise){
    	$lg = $_GET['lg'];
    	if (\Voyager::translatable($cruise)) {
    		$cruises = $cruise->withTranslation($lg)->get();
    	}else{
    		$cruises = $cruise->all();
    	}
    	return $cruises;
    }
}
