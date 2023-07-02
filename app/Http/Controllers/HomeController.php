<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function comment(Request $request)
    {
        // this is for ajax request
//        if(! $request->ajax()) {
//            return response()->json([
//                'status' => 'ajax required'
//            ]);
//        }

        $data = $request->validate([
            'commentable_id' => 'required',
            'commentable_type' => 'required',
            'parent_id' => 'required',
            'comment' => 'required',
        ]);

        auth()->user()->comments()->create($data);

        alert('', 'نظر شما با موفقیت ثبت شد', 'success');
        return back();
//        return response()->json([
//            'status' => 'success'
//        ]);
    }
}
