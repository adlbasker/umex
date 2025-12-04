<?php

namespace App\Http\Controllers\Joystick;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Joystick\Controller;

use App\Models\App;
use App\Models\User;
use App\Models\Post;

class AdminController extends Controller
{
    public function index()
    {
        $countApps = App::count();
        $countUsers = User::count();
        $countPosts = Post::count();

        return view('joystick.index', compact('countApps', 'countPosts', 'countUsers'));
    }

    public function filemanager()
    {
        if (! Gate::allows('allow-filemanager', \Auth::user())) {
            abort(403);
        }

    	return view('joystick.filemanager');
    }

    public function frameFilemanager()
    {
    	return view('joystick.frame-filemanager');
    }
}
