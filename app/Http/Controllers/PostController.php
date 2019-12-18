<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Session;
class PostController extends Controller
{
    

    public function store(){

    	$data = request()->validate([
    		'body'  =>  'required|min:10',
    		'user_id' => 'required'
    	]);

    	Post::create($data);

    	Session::flash('status', 'You just create new Post');

    	return redirect()->back();
    }
}
