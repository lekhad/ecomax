<?php

namespace App\Http\Controllers;

use App\CmsPage;
use Illuminate\Http\Request;

class CmsController extends Controller
{
    //

    public function addCmsPage(Request $request){
        if($request->isMethod('post')){
            $data= $request->all();
//            echo "<pre>"; print_r($data); die;
            $cmspage= new CmsPage;
            $cmspage->title= $data['title'];
            $cmspage->url= $data['url'];
            $cmspage->description= $data['description'];

            if(empty($data['status'])){
                $status= 0;
            }else{
                $status= 1;
            }
            $cmspage->status= $status;
            $cmspage->save();
            return redirect()->back()->with('flash_message_success', 'CMS Page has been added Successfully');

        }
        return view('admin.pages.add_cms_page');

    }
}
