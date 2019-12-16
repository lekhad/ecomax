<?php

namespace App\Http\Controllers;

use App\Country;
use App\Coupon;
use App\DeliveryAddress;
use App\Order;
use App\OrdersProduct;
use App\ProductsAttribute;
use App\ProductsImage;
use App\User;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Session;
use Image;
use App\Category;
use App\Product;

use Illuminate\Http\Request;

class ProductsController extends Controller
{
    //
    public function addProduct(Request $request){

        if($request->isMethod('post')){
            $data= $request->all();
//            echo "<pre>"; print_r($data); die;
            // The echo statement will reveal all the data including the image array
            if(empty($data['category_id'])){
                return redirect()->back()->with('flash_message_error', 'Under Category is Missing!');
            }
            $product=   new Product;
            $product->category_id=  $data['category_id'];
            $product->product_name= $data['product_name'];
            $product->product_code= $data['product_code'];
            $product->product_color= $data['product_color'];

            if(!empty($data['description'])){
                $product->description = $data['description'];
            }else{
                $product->description='';
            }
            if(!empty($data['care'])){
                $product->care = $data['care'];
            }else{
                $product->care='';
            }

            $product->price =       $data['price'];

            //Upload Image
//            The resize image works with the installation of intervention image package
            if($request->hasFile('image')){
                $image_tmp= Input::file('image');
                if($image_tmp->isValid()){
//                    echo "test"; die;
                    $extension= $image_tmp->getClientOriginalExtension();
                    $filename= rand(111, 99999).'.'. $extension;
                    $large_image_path= 'images/backend_images/products/large/'.$filename;
                    $medium_image_path= 'images/backend_images/products/medium/'.$filename;
                    $small_image_path= 'images/backend_images/products/small/'.$filename;
                    // Resize Images
//                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(1200, 1200)->save($large_image_path);
                    Image::make($image_tmp)->resize(600, 600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300, 300)->save($small_image_path);

                    //Store image name product table;

                    $product->image= $filename;


                }
            }

            if(empty($data['status'])){
                $status=0;
            }else{
                $status=1;
            }
            $product->status= $status;
            $product->save();
//            return redirect()->back()->with('flash_message_success', 'Product has been added Successfully');
            return redirect('/admin/view-products')->with('flash_message_success', 'Product has been added successfully');

        }

        // Categories dropdown starts
        $categories= Category::where(['parent_id'=>0])->get();
        $categories_dropdown= "<option value='' selected disabled> Select </option>";
        foreach($categories as $cat){
            $categories_dropdown .= "<option value='" .$cat->id. "'>".$cat->name. "</option>";

            $sub_categories= Category::where(['parent_id'=> $cat->id])->get();
            foreach($sub_categories as $sub_cat){
                $categories_dropdown .= "<option value= '" .$sub_cat->id."'>&nbsp; -- &nbsp;".$sub_cat->name."</option>";
            }
        }
        // Categories dropdown ends;

        return view('admin.products.add_product')->with(compact('categories_dropdown'));
    }

    public function editProduct(Request $request, $id=null){
        if($request->isMethod('post')){
            $data= $request->all();
//            echo "<pre>"; print_r($data); die;

            if($request->hasFile('image')){
                $image_tmp= Input::file('image');
                if($image_tmp->isValid()){
//                    echo "test"; die;
                    $extension= $image_tmp->getClientOriginalExtension();
                    $filename= rand(111, 99999).'.'. $extension;
                    $large_image_path= 'images/backend_images/products/large/'.$filename;
                    $medium_image_path= 'images/backend_images/products/medium/'.$filename;
                    $small_image_path= 'images/backend_images/products/small/'.$filename;
                    // Resize Images
//                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(1200, 1200)->save($large_image_path);
                    Image::make($image_tmp)->resize(600, 600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300, 300)->save($small_image_path);

                }
            }else{
                $filename= $data['current_image'];
            }

            if(empty($data['description'])){
                $data['description']='';
            }

            if(empty($data['care'])){
                $data['care']='';
            }

            if(empty($data['status'])){
                $status=0;
            }else{
                $status=1;
            }

            // Updating the product
            Product::where(['id'=> $id])->update(['category_id'=>$data['category_id'],'product_name'=>$data['product_name'], 'product_code'=>$data['product_code'],'product_color'=>$data['product_color'],'description'=>$data['description'],'care'=>$data['care'], 'price'=>$data['price'], 'image'=> $filename, 'status'=>$status]);
            return redirect()->back()->with('flash_message_success', 'Product has been updated Successfully');
        }

        // Get product details
        $productDetails= Product::where(['id'=> $id])->first();

        // Categories dropdown starts
        $categories= Category::where(['parent_id'=>0])->get();
        $categories_dropdown= "<option value='' selected disabled> Select </option>";
        foreach($categories as $cat){
            if($cat->id == $productDetails->category_id){
                $selected= "selected";
            }else{
                $selected= "";
            }
            $categories_dropdown .= "<option value='" .$cat->id. "' ".$selected.">".$cat->name. "</option>";

            $sub_categories= Category::where(['parent_id'=> $cat->id])->get();
            foreach($sub_categories as $sub_cat){
                if($sub_cat->id == $productDetails->category_id){
                    $selected= "selected";
                }else{
                    $selected= "";
                }

                $categories_dropdown .= "<option value= '" .$sub_cat->id."' ".$selected.">&nbsp; -- &nbsp;".$sub_cat->name."</option>";
            }
        }
        // Categories dropdown ends;

        return view('admin.products.edit_product')->with(compact('productDetails', 'categories_dropdown'));
    }

    public function viewProducts(){
        $products= Product::orderBy('id', 'DESC')->get();
        $products = json_decode(json_encode($products));

        foreach($products as $key => $val){
            // This is used to display the categories name of the product and it is been returned in the for $product->category_name in view_products.blade.php->
            $category_name= Category::where(['id'=> $val->category_id])->first();
            $products[$key]->category_name = $category_name->name;
        }

//        echo "<pre>"; print_r($products); die;
        return view('admin.products.view_products')->with(compact('products'));
    }

    public function deleteProduct($id=null){
        Product::where(['id'=>$id])->delete();
        ProductsAttribute::where(['product_id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success', 'Product has been deleted Successfully');
    }

    public function deleteAltImage($id= null){
        // Get Product Image Name

        $productImage= ProductsImage::where(['id'=>$id])->first();

//        echo $productImage->image; die;
        // Get product image path
        $large_image_path= 'images/backend_images/products/large/';
        $medium_image_path= 'images/backend_images/products/medium/';
        $small_image_path= 'images/backend_images/products/small/';

        //Delete Large Image if not exists in folder

        if(file_exists($large_image_path.$productImage->image)){
            unlink($large_image_path.$productImage->image);
        }

        //Delete Medium Image if not exists in folder

        if(file_exists($medium_image_path.$productImage->image)){
            unlink($medium_image_path.$productImage->image);
        }

        //Delete Large Image if not exists in folder

        if(file_exists($small_image_path.$productImage->image)){
            unlink($small_image_path.$productImage->image);
        }

        // Delete Image from Products table

        ProductsImage::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success', 'Product Alternate Image has been deleted Successfully');
    }
    public function deleteProductImage($id= null){
        // Get Product Image Name

        $productImage= Product::where(['id'=>$id])->first();

//        echo $productImage->image; die;
        // Get product image path
        $large_image_path= 'images/backend_images/products/large/';
        $medium_image_path= 'images/backend_images/products/medium/';
        $small_image_path= 'images/backend_images/products/small/';

        //Delete Large Image if not exists in folder

        if(file_exists($large_image_path.$productImage->image)){
            unlink($large_image_path.$productImage->image);
        }

        //Delete Medium Image if not exists in folder

        if(file_exists($medium_image_path.$productImage->image)){
            unlink($medium_image_path.$productImage->image);
        }

        //Delete Large Image if not exists in folder

        if(file_exists($small_image_path.$productImage->image)){
            unlink($small_image_path.$productImage->image);
        }

        // Delete Image from Products table

        Product::where(['id'=>$id])->update(['image'=>'']);
        return redirect()->back()->with('flash_message_success', 'Product Image has been deleted Successfully');
    }


    public function addAttributes(Request $request, $id= null){
//        echo "test";die;
        $productDetails= Product::with('attributes')->where(['id'=> $id])->first();
//        $productDetails= json_decode(json_encode($productDetails));
//        echo "<pre>"; print_r($productDetails); die;

        if($request->isMethod('post')){
            $data= $request->all();
//            echo "<pre>"; print_r($data); die;
            foreach($data['sku'] as $key => $val){
                if(!empty($val)){
                    // Prevent duplicate SKU Check
                    $attrCountSKU = ProductsAttribute::where('sku', $val)->count();
                    if($attrCountSKU > 0){
                        return redirect('admin/add-attributes/'.$id)->with('flash_message_error', 'SKU already exists! Please add another SKU');
                    }
                    // Prevent duplicate size Check
                    $attrCountSizes= ProductsAttribute::where(['product_id'=>$id, 'size'=>$data['size'][$key]])->count();
                    if($attrCountSizes> 0){
                        return redirect('admin/add-attributes/'.$id)->with('flash_message_error', '"'.$data['size'][$key].'"' .'Size already exists! Please add another Size');
                    }
                    $attribute = new ProductsAttribute;
                    $attribute->product_id= $id;
                    $attribute->sku= $val;
                    $attribute->size= $data['size'][$key];
                    $attribute->price= $data['price'][$key];
                    $attribute->stock= $data['stock'][$key];
                    $attribute->save();
                }
            }


            return redirect('/admin/add-attributes/'.$id)->with('flash_message_success', 'Product Attributes has been added successfully');
        }
        return view('admin.products.add_attributes')->with(compact('productDetails'));
    }

    public function editAttributes(Request $request, $id=null){
        if($request->isMethod('post')){
            $data= $request->all();
//            echo "<pre>"; print_r($data); die;
            foreach($data['idAttr'] as $key=> $attr){
                productsAttribute::where(['id'=>$data['idAttr'][$key]])->update(['price'=> $data['price'][$key], 'stock'=> $data['stock'][$key]]);
            }

            return redirect()->back()->with('flash_message_success', 'Products Attributes has been updated successfully');
        }
    }

    public function addImages(Request $request, $id= null){

        if($request->isMethod('post')){
            // add images
            $data= $request->all();
//            echo "<pre>"; print_r($data); die;
            if($request->hasFile('image')){
                $files=$request->file('image');
                foreach($files as $file){
                    //                echo "<pre>"; print_r($files); die;
                    // Upload Images after resize
                    $image= new ProductsImage;
                    $extension= $file->getClientOriginalExtension();
                    $filename= rand(111, 99999). '.'.$extension;
                    $large_image_path= 'images/backend_images/products/large/'.$filename;
                    $medium_image_path= 'images/backend_images/products/medium/'.$filename;
                    $small_image_path= 'images/backend_images/products/small/'.$filename;
//                Image::make($file)->save($large_image_path);
                    Image::make($file)->resize(1200, 1200)->save($large_image_path);
                    Image::make($file)->resize(600, 600)->save($medium_image_path);
                    Image::make($file)->resize(300, 300)->save($small_image_path);
                    $image->image= $filename;
                    $image->product_id= $data['product_id'];
                    $image->save();
                }
            }

            return redirect('/admin/add-images/'.$id)->with('flash_message_success', 'Product Image has been added Successfully');

        }

        $productDetails=Product::with('attributes')->where(['id'=> $id])->first();

        $productsImg= ProductsImage::where(['product_id'=> $id])->get();

//        $productsImg= json_decode(json_encode($productsImg));
//        echo "<pre>"; print_r($productsImg); die;

        $productsImages= "";
        foreach($productsImg as $img){
            $productsImages .= "<tr>
                <td>".$img->id."</td>
                <td>".$img->product_id."</td>
                <td><img width='150px' src='/images/backend_images/products/small/$img->image'></td>
                <td> <a rel='$img->id' rel1='delete-alt-image' href='javascript:' class='btn btn-danger btn-mini deleteRecord' title='Delete Product Image'>Delete</a></td>
            </tr>";
        }
        return view('admin.products.add_images')->with(compact('productDetails', 'productsImages'));
    }

    public function deleteAttribute($id= null){
        ProductsAttribute::where(['id'=> $id])->delete();
        return redirect()->back()->with('flash_message_success', 'Attributes has been deleted Successfully');
    }

//    public function products($url= null){
//
//        // This helps in returning all the listing s tp the main products based for subcategories sidebar only
////        echo $url; die;
//        $categories= Category::with('categories')->where(['parent_id'=> 0])->get();
//
//        $categoryDetails= Category::where(['url'=> $url])->first();
//
////        echo $categoryDetails->id; die;
//        $productsAll=Product::where(['category_id'=> $categoryDetails->id])->get();
//        return view('products.listing')->with(compact('categories','categoryDetails', 'productsAll'));
//    }

    public function products($url= null){
//        echo $url; die;

        // Show 404 page if the url category does not exist

        $countCategory= Category::where(['url'=> $url, 'status'=>1])->count();
        if($countCategory==0){
            abort(404);
        }
//        echo $countCategory; die;

        $categories= Category::with('categories')->where(['parent_id'=> 0])->get();

        $categoryDetails= Category::where(['url'=> $url])->first();

        // Started working for Vd 025
        if($categoryDetails->parent_id == 0){
            // If url is main category url
            $subCategories= Category::where(['parent_id'=> $categoryDetails->id])->get();
//            $cat_ids= "";
            foreach($subCategories as $subcat){
//                if ($key==1) $cat_ids .= ",";
//                $cat_ids .= trim($subcat->id);
                $cat_ids[]= $subcat->id;
            }
//            echo $cat_ids; die;
//            print_r($cat_ids); die;
            $productsAll= Product::whereIn('category_id', $cat_ids)->where('status', 1)->get();
            $productsAll = json_decode(json_encode($productsAll));
//            echo "<pre>"; print_r($productsAll); die;
        }else{
            // if url is sub category url
            $productsAll= Product::where(['category_id' => $categoryDetails->id])->where('status', 1)->get();
        }
        // End working for Vd 025

        return view('products.listing')->with(compact('categories','categoryDetails', 'productsAll'));
    }

    public function product($id= null){

        //Show 404 Page if product is disabled
        $productsCount= Product::where(['id'=> $id, 'status'=>1])->count();
        if($productsCount==0){
            abort(404);
        }

        // Get Product Details
        $productDetails= Product::with('attributes')->where('id', $id)->first();

        $productDetails= json_decode(json_encode($productDetails));
//        echo "<pre>"; print_r($productDetails); die;

        $relatedProducts= Product::where('id', '!=', $id)->where(['category_id'=>$productDetails->category_id])->get();
//        echo "<pre>"; print_r($relatedProducts); die;
//        $relatedProducts= json_decode(json_encode($relatedProducts));

//        foreach($relatedProducts->chunk(3) as $chunk){
//            foreach($chunk as $item){
//                echo $item; echo "<br>";
//            }
//            echo "<br><br><br>";
//        }
//        die;

        $categories= Category::with('categories')->where(['parent_id'=>0])->get();

        //Get Alternate Images
        $productAltImages= ProductsImage::where('product_id', $id)->get();
//        $productAltImages= json_decode(json_encode($productAltImages));
//        echo "<pre>"; print_r($productAltImages); die;

        $total_stock= ProductsAttribute::where('product_id', $id)->sum('stock');

        return view('products.detail')->with(compact('productDetails', 'categories', 'productAltImages', 'total_stock', 'relatedProducts'));
    }

    public function getProductPrice(Request $request){
        $data = $request->all();
//        echo "<pre>"; print_r($data); die;
        $proArr= explode("-", $data['idSize']);
        //echo $proArr[0]; echo $proArr[1]; die;
        $proAttr= ProductsAttribute::where(['product_id'=> $proArr[0], 'size'=> $proArr[1]])->first();
        echo $proAttr->price;
        echo "#";
        echo $proAttr->stock;
    }

    public function addtocart(Request $request){

        Session::forget('CouponAmount');
        Session::forget('CouponCode');

        $data= $request->all();
//        echo "<pre>"; print_r($data); die;
        // The price is also updated in the main.js for the ajax ("#price").val

//
//        if(empty($data['user_email'])){
//            $data['user_email']= '';
//        }
        if(empty(Auth::user()->email)){
            $data['user_email']='';
        }else{
            $data['user_email']= Auth::user()->email;
        }

        $session_id= Session::get('session_id');

        if(empty($session_id)){
            $session_id= str_random(40);
            Session::put('session_id', $session_id);
        }

        $sizeArr= explode("-", $data['size']);

        $countProducts= DB::table('cart')->where(['product_id'=>$data['product_id'], 'product_color'=>$data['product_color'],'size'=>$sizeArr[1], 'session_id'=>$session_id])->count();

//        echo $countProducts; die;
        if($countProducts> 0){
            return redirect()->back()->with('flash_message_error', 'Product already exist in cart');
        }else{
            // Updating the SKU size for the cart table
            $getSKU= ProductsAttribute::select('sku')->where(['product_id'=>$data['product_id'], 'size'=>$sizeArr[1]])->first();

            DB::table('cart')->insert(['product_id'=>$data['product_id'], 'product_name'=>$data['product_name'], 'product_code'=> $getSKU->sku, 'product_color'=>$data['product_color'],'price'=>$data['price'],'size'=>$sizeArr[1],'quantity'=>$data['quantity'],'user_email'=>$data['user_email'],'session_id'=>$session_id]);

//            DB::table('cart')->insert(['product_id'=>$data['product_id'], 'product_name'=>$data['product_name'], 'product_code'=>$data['product_code'],'product_color'=>$data['product_color'],'price'=>$data['price'],'size'=>$sizeArr[1],'quantity'=>$data['quantity'],'user_email'=>$data['user_email'],'session_id'=>$session_id]);
        }

        return redirect('cart')->with('flash_message_success', 'Product has been added in Cart!');
    }

    public function cart(){

        $session_id= Session::get('session_id');

        if(Auth::check()){
            $user_email= Auth::user()->email;
            $userCart=  DB::table('cart')->where(['user_email'=>$user_email])->get();
        }else{
            $session_id= Session::get('session_id');
            $userCart=  DB::table('cart')->where(['session_id'=>$session_id])->get();
        }
//        $userCart=  DB::table('cart')->where(['session_id'=>$session_id])->get();
        foreach($userCart as $key=> $product){
//            echo $product->product_id; die;
            $productDetails= Product::where('id', $product->product_id)->first();
//            $userCart[$key]->image= "test";
            $userCart[$key]->image= $productDetails->image;
        }

//        echo "<pre>"; print_r($userCart); die;
        return view('products.cart')->with(compact('userCart'));
    }


    public function deleteCartProduct($id= null){
        Session::forget('CouponAmount');
        Session::forget('CouponCode');

//        echo $id; die;
        DB::table('cart')->where('id', $id)->delete();
        return redirect('cart')->with('flash_message_success', 'Product has been deleted from Cart');
    }

    public function updateCartQuantity($id= null, $quantity= null){
        Session::forget('CouponAmount');
        Session::forget('CouponCode');

        $getCartDetails= DB::table('cart')->where('id', $id)->first();
//        $getCartDetails= json_decode(json_encode($getCartDetails));
//        echo "<pre>"; print_r($getCartDetails); die;
        $getAttributeStock= ProductsAttribute::where('sku', $getCartDetails->product_code)->first();
        echo $getAttributeStock->stock; echo "--";
        echo $updated_quantity= $getCartDetails->quantity + $quantity;
//        die;
        if($getAttributeStock->stock >= $updated_quantity){
            DB::table('cart')->where('id', $id)->increment('quantity', $quantity);
            return redirect('cart')->with('flash_message_success', 'Product Quantity has been updated Successfully');
        }else{
            return redirect('cart')->with('flash_message_error', 'Required Product Quantity is not available!');
        }
    }

    public function applyCoupon(Request $request){
        Session::forget('CouponAmount');
        Session::forget('CouponCode');
        $data= $request->all();
//        echo "<pre>"; print_r($data); die;
        $couponCount=   Coupon::where('coupon_code', $data['coupon_code'])->count();
        if($couponCount==0){
            return redirect()->back()->with('flash_message_error', 'This Coupon does not exists!');
        }else{
//            echo "Success"; die;
            // witb perform other checks like Active/Inactive, Expiry Date

            //Get Coupon Details
            $couponDetails= Coupon::where('coupon_code', $data['coupon_code'])->first();

            // If coupon is Inactive
            if($couponDetails->status==0){
                return redirect()->back()->with('flash_message_error', 'This coupon is not active');
            }
            // If Coupon has expired
//            echo $expiry_date= $couponDetails->expiry_date;
//            echo $current_date= date('Y-m-d'); die;
            $expiry_date= $couponDetails->expiry_date;
            $current_date= date('Y-m-d');
            if($expiry_date< $current_date){
                return redirect()->back()->with('flash_message_error','This coupon has expired');
            }


            //Coupon is Valid for discount
            //Check if amount type is fixed or percentage

            // Get Cart Total Amount



            $session_id= Session::get('session_id');
            $userCart= DB::table('cart')->where(['session_id'=> $session_id])->get();

            if(Auth::check()){
                $user_email= Auth::user()->email;
                $userCart= DB::table('cart')->where(['user_email'=>$user_email])->get();
            }else{
                $session_id= Session::get('session_id');
                $userCart= DB::table('cart')->where(['session_id'=> $session_id])->get();
            }

            $total_amount=0;
            foreach($userCart as $item){
                $total_amount= $total_amount + ($item->price* $item->quantity);
            }

//            if($couponDetails->amount_type=="Percentage"){
//                $couponAmount= $total_amount * ($couponDetails->amount/100);
//            }else{
//                $couponAmount= $couponDetails->amount;
//            }

            if($couponDetails->amount_type=="Fixed"){
                $couponAmount= $couponDetails->amount;
            }else{
//                echo $total_amount; die;
                // The Total Amount worked until the if Auth::check is done above
                $couponAmount= $total_amount * ($couponDetails->amount/100);
            }
//                        echo $couponAmount; die;
            //Add Coupon Code & Amount in Session
            Session::put('CouponAmount', $couponAmount);
            Session::put('CouponCode', $data['coupon_code']);
            return redirect()->back()->with('flash_message_success', 'Coupon Code successfully applied. You are availing discount');

        }
    }

    public function checkout(Request $request){
        $user_id= Auth::user()->id;
        $user_email= Auth::user()->email;

        $userDetails= User::find($user_id);
        $countries= Country::get();

        //Check if shipping Address exists

        $shippingCount= DeliveryAddress::where('user_id', $user_id)->count();

        $shippingDetails= array();
        if($shippingCount > 0){
            $shippingDetails = DeliveryAddress::where('user_id', $user_id)->first();
        }

        // Intuitive way of solving the bug withour assigning array to the shippingDetails and the checking if array exist in vlaues of input fields of checkout.blade.php
//
//        if($shippingCount > 0){
//            $shippingDetails = DeliveryAddress::where('user_id', $user_id)->first();
//        }else{
////            return view('products.checkout');
//            $data= $request->all();
//            $shipping= new DeliveryAddress;
//            $shipping->user_id= $user_id;
//            $shipping->user_email= $user_email;
//            $shipping->name=    '';
//            $shipping->address= '';
//            $shipping->city=    '';
//            $shipping->state=  '';
//            $shipping->pincode= '';
//            $shipping->country= '';
//            $shipping->mobile= '';
//            $shipping->save();
//            die;
//        }

        // Update cart Table with the user email
        $session_id= Session::get('session_id');
        DB::table('cart')->where(['session_id'=>$session_id])->update(['user_email'=> $user_email]);

        if($request->isMethod('post')){
            $data= $request->all();
//            echo "<pre>"; print_r($data); die;

            // Return to checkout page if any of the field is empty

            if(empty($data['billing_name']) || empty($data['billing_address']) || empty($data['billing_city']) || empty($data['billing_state']) || empty($data['billing_country']) || empty($data['billing_pincode']) || empty($data['billing_mobile']) || empty($data['shipping_name']) || empty($data['shipping_address']) || empty($data['shipping_city']) || empty($data['shipping_state']) || empty($data['shipping_country']) || empty($data['shipping_pincode']) || empty($data['shipping_mobile'])){

                return redirect()->back()->with('flash_message_error', 'Please fill all fields to checkout');
            }

            // Update User Details
            User::where('id', $user_id)->update(['name'=>$data['billing_name'], 'address'=>$data['billing_address'], 'city'=>$data['billing_city'], 'state'=>$data['billing_state'], 'pincode'=>$data['billing_pincode'], 'country'=>$data['billing_country'], 'mobile'=>$data['billing_mobile']]);
//            die;

            if($shippingCount> 0){

                //Update Shipping Address
                DeliveryAddress::where('user_id', $user_id)->update(['name'=>$data['shipping_name'], 'address'=>$data['shipping_address'], 'city'=>$data['shipping_city'], 'state'=>$data['shipping_state'], 'pincode'=>$data['shipping_pincode'], 'country'=>$data['shipping_country'], 'mobile'=>$data['shipping_mobile']]);

            }else{
                // Add New Shipping Address
                $shipping= new DeliveryAddress;
                $shipping->user_id= $user_id;
                $shipping->user_email= $user_email;
                $shipping->name=    $data['shipping_name'];
                $shipping->address= $data['shipping_address'];
                $shipping->city=    $data['shipping_city'];
                $shipping->state=   $data['shipping_state'];
                $shipping->pincode= $data['shipping_pincode'];
                $shipping->country= $data['shipping_country'];
                $shipping->mobile=  $data['shipping_mobile'];
                $shipping->save();
            }
//            echo "Redirect to Order Review Page"; die;
            return redirect()->action('ProductsController@orderReview');
        }
        return view('products.checkout')->with(compact('userDetails', 'countries', 'shippingDetails'));

    }

    public function orderReview(){
        $user_id= Auth::user()->id;
        $user_email= Auth::user()->email;

        $userDetails= User::where('id', $user_id)->first();
        $shippingDetails= DeliveryAddress::where('user_id', $user_id)->first();
//        $shippingDetails= json_decode(json_encode($shippingDetails));
//        echo "<pre>"; print_r($shippingDetails); die;

        $userCart=  DB::table('cart')->where(['user_email'=> $user_email])->get();
        foreach($userCart as $key=> $product){
            $productDetails= Product::where('id', $product->product_id)->first();
            $userCart[$key]->image= $productDetails->image;
        }
//        foreach ($userCart as $cart){
//            echo "<pre>"; print_r($cart); die;
//        }

//        echo "<pre>"; print_r($productDetails); die;
//        echo "<pre>"; print_r($userCart); die;
        return view('products.order_review')->with(compact('userDetails', 'shippingDetails', 'userCart'));
    }

    public function placeOrder(Request $request){
        if($request->isMethod('post')){
            $data= $request->all();
            $user_id= Auth::user()->id;
            $user_email= Auth::user()->email;
//            echo "<pre>"; print_r($data); die;

            // Get Shipping Address of User
            $shippingDetails= DeliveryAddress::where(['user_email'=>$user_email])->first();
            $shippingDetails= json_decode(json_encode($shippingDetails));

//            echo "<pre>"; print_r($shippingDelivery); die;
//            echo $username= Auth::user()->name;

            if(empty(Session::get('CouponCode'))){
                $coupon_code= '';
            }else{
                $coupon_code= Session::get('CouponCode');
            }

            if(empty(Session::get('CouponAmount'))){
                $coupon_amount= '';
            }else{
                $coupon_amount= Session::get('CouponAmount');
            }
            $order= new Order;
            $order->user_id= $user_id;
            $order->user_email= $user_email;
            $order->name= $shippingDetails->name;
            $order->address= $shippingDetails->address;
            $order->city= $shippingDetails->city;
            $order->state= $shippingDetails->state;
            $order->pincode= $shippingDetails->pincode;
            $order->country= $shippingDetails->country;
            $order->mobile= $shippingDetails->mobile;
            $order->coupon_code= $coupon_code;
            $order->coupon_amount= $coupon_amount;
            $order->order_status= "New";
            $order->payment_method= $data['payment_method'];
            $order->grand_total= $data['grand_total'];
            $order->save();

            $order_id= DB::getPdo()->lastInsertId();

            $cartProducts= DB::table('cart')->where(['user_email'=>$user_email])->get();
            foreach($cartProducts as $pro){
                $cartPro= new OrdersProduct;
                $cartPro->order_id= $order_id;
                $cartPro->user_id= $user_id;
                $cartPro->product_id=    $pro->product_id;
                $cartPro->product_code=  $pro->product_code;
                $cartPro->product_name=  $pro->product_name;
                $cartPro->product_color= $pro->product_color;
                $cartPro->product_size=  $pro->size;
                $cartPro->product_price= $pro->price;
                $cartPro->product_qty=   $pro->quantity;
                $cartPro->save();
            }

            Session::put('order_id', $order_id);
            Session::put('grand_total', $data['grand_total']);

            //Redirect user to thanks page after saving order
            return redirect('/thanks');
        }
    }

    public function thanks(Request $request){
        return view('products.thanks');
    }

}
