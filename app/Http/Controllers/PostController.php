<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use URL;

use App\Models\Page;
use App\Models\Post;
use App\Models\Comment;

class PostController extends Controller
{
    public function posts($lang)
    {
        $page = Page::where('slug', 'news')->where('lang', $lang)->first();
        $posts = Post::orderBy('created_at', 'desc')->where('lang', $lang)->paginate(15);

        return view('posts', compact('page', 'posts'));
    }

    public function postSingle($lang, $uri)
    {
        $page = Page::where('slug', 'news')->where('lang', $lang)->first();
        $post = Post::where('slug', $uri)->first();

        return view('post-single', compact('page', 'post'));
    }

    public function saveComment(Request $request)
    {
        $this->validate($request, [
            'comment' => 'required|min:5|max:500',
        ]);

        $url = explode('posts/', URL::previous());
        $postSingle = Post::where('slug', $url[1])->first();

        if ($request->id == $postSingle->id) {
            $comment = new Comment;
            $comment->parent_id = $request->id;
            $comment->parent_type = 'App\posts';
            $comment->name = \Auth::user()->name;
            $comment->email = \Auth::user()->email;
            $comment->comment = $request->comment;
            // $comment->stars = (int) $request->stars;
            $comment->save();
        }

        if (!$comment) {
            return redirect()->back()->with('status', 'Ошибка!');
        }

        return redirect()->back()->with('status', 'Отзыв добавлен!');
    }
}
