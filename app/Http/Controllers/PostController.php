<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Post::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return Post::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Post::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post= Post::find($id);
        $response = Gate::inspect('update',$post);
        if($response->allowed())
        {
            $post->update($request->all());
            return $post;
        }
        else{
            return $response->message();
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post= Post::find($id);
        $response = Gate::inspect('delete',$post);
        if($response->allowed())
        {
            return Post::destroy($id);
        }
        else{
            return $response->message();
        }
    }

       /**
     * Remove the specified resource from storage.
     *
     * @param  string  $subject
     * @return \Illuminate\Http\Response
     */
    public function search($subject)
    {
        return Post::where('subject','like','%'.$subject.'%')->get();
    }
}
