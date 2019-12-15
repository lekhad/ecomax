<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public static function mainCategories(){
        $mainCategories= Category::where(['parent_id'=> 0])->get();
//        $mainCategories= json_encode(json_decode($mainCategories));
//        echo "<pre>".print_r($mainCategories); die;
        return $mainCategories;
    }
}
