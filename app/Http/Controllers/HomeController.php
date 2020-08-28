<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
 use App\Post;
 use App\User;
use Storage;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $this->authorize('create', Post::class);

        if (auth()->user()->manager == 0) {
            return view('home');
        } else {
            $posts['posts'] = Post::all();
            $users['users'] = User::all();
            return view('managerhome', $users, $posts );
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function store(Request $request)
    {
        $this->authorize('create', Post::class);

        if($request->hasFile('file')){
            $file=$request->file('file');
            $request->file('file')->storeAs('pictures', '2.txt');
        } else {
            return 'No file selected';
        }

        $attributes = $this->validate(request(), [
            'title' => 'required|min:2',
            'text' => 'required',
        ]);

        auth()->user()->posts()->create($attributes);

        return redirect('/');
    }
}
