<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Content;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contents = Content::where('user_id',Auth::user()->id)->get();
        return view('editor', compact('contents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->route('editor.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $content = new Content();
        $content->user_id = Auth::user()->id;
        $content->name = $request->input('name');
        $content->slug = Str::slug(Auth::user()->name." ".$request->input('name'));
        $content->content = $request->input('content');
        $content->save();

        return redirect()->route('editor.show', $content);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Content $editor)
    {
        $contents = Content::where('user_id', Auth::user()->id)->get();
        return view('editor', compact('editor','contents'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Content $editor)
    {
        return redirect()->route('editor.show',$editor);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Content $editor)
    {
        if(Auth::user()->id == $editor->user_id) {
            if($request->has('content'))
                $editor->content = $request->input('content');
            if($request->has('external'))
                $editor->external = $request->input('external');
            $editor->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Content $editor)
    {
        if(Auth::user()->id == $editor->user_id)
            $editor->delete();

        return redirect()->route('editor.index');
    }
}
