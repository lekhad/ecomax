<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Category;
use App\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    //
    public function index(){

        // In ascending order (by default)
        $productsAll= Product::get();

        // In descending order
        $productsAll= Product::orderBy('id', 'DESC')->get();

        // In Random Order
        $productsAll= Product::inRandomOrder()->where('status', 1)->get();

        //Get all Categories  and Sub Categories
// First Approach to returning all the Catgories in Menu and SubMenu Sidebar when toggled

//        $categories= Category::where(['parent_id'=> 0])->get();
////        $categories= json_decode(json_encode($categories));
////        echo "<pre>"; print_r($categories); die;
//
//        $categories_menu= "";
//        foreach($categories as $cat){
////            echo $cat->name; echo "<br>";
//
//            $categories_menu .="<div class='panel-heading'>
//                                    <h4 class='panel-title'>
//                                        <a data-toggle='collapse' data-parent='#accordian' href='#".$cat->id."'>
//                                            <span class='badge pull-right'><i class='fa fa-plus'></i></span>
//                                            ".$cat->name."
//                                        </a>
//                                    </h4>
//                                </div>
//
//                                   <div id='".$cat->id."' class='panel-collapse collapse'>
//                                    <div class='panel-body'>
//                                        <ul>";
//                                        $sub_categories= Category::where(['parent_id'=>$cat->id])->get();
//                                        foreach($sub_categories as $subcat){
////                                            echo "----".$subcat->name; echo "<br>";
//                                            $categories_menu .= "<li><a href='".$subcat->url."'>".$subcat->name." </a></li>";
//                                        }
//                                            $categories_menu.= "
//                                        </ul>
//                                    </div>
//                                </div>
//                                ";
//        }

        // Second Approach using relationships

        $categories= Category::with('categories')->where(['parent_id'=> 0])->get();
//        $categories= json_decode(json_encode($categories));
//        echo "<pre>"; print_r($categories);

//        $categories_menu= "";
//        foreach($categories as $cat){
////            echo $cat->name; echo "<br>";
//
//            $categories_menu .="<div class='panel-heading'>
//                                    <h4 class='panel-title'>
//                                        <a data-toggle='collapse' data-parent='#accordian' href='#".$cat->id."'>
//                                            <span class='badge pull-right'><i class='fa fa-plus'></i></span>
//                                            ".$cat->name."
//                                        </a>
//                                    </h4>
//                                </div>
//
//                                   <div id='".$cat->id."' class='panel-collapse collapse'>
//                                    <div class='panel-body'>
//                                        <ul>";
//            $sub_categories= Category::where(['parent_id'=>$cat->id])->get();
//            foreach($sub_categories as $subcat){
////                                            echo "----".$subcat->name; echo "<br>";
//                $categories_menu .= "<li><a href='".$subcat->url."'>".$subcat->name." </a></li>";
//            }
//            $categories_menu.= "
//                                        </ul>
//                                    </div>
//                                </div>
//                                ";
//        }
//        die ;
//        return view('index')->with(compact('productsAll', 'categories_menu', 'categories'));

     $banners= Banner::where('status', '1')->get();
     return view('index')->with(compact('productsAll', 'categories', 'banners'));
    }

}
