<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;

use Illuminate\Http\Request;
use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $posts = Post::orderBy('created_at', 'DESC')->where('user_id', Auth::user()->id)->get();

        return view('blog.posts', [
            'pages' => 'Manajemen Artikel',
            'buttonDashboard' => '',
            'buttonPosts' => 'active',
            'buttonCategory' => '',
            'buttonSetting' => '',
            'no' => 1,
            'posts' => $posts,
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        return view('blog.create', [
            'pages' => 'Buat Artikel',
            'pages' => 'Buat Artikel',
            'buttonDashboard' => '',
            'buttonPosts' => 'active',
            'buttonCategory' => '',
            'buttonSetting' => '',
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'title' => [
                'required',
                'string'
            ],
            'content' => [
                'string'
            ],
            'categories' => [
                'required',
                'array',
                'min:2'
            ],
            'image' => [
                'required',
                'mimes:jpg,jpeg,png,gif',
                'max:1024',
            ]
        ])->validate();

        $params = $request->all();

        $params['title'] = $request->title;
        $params['slug'] = Str::slug($request->title);
        $params['content'] = $request->content;
        $params['user_id'] = $request->user()->id;
        $params['status'] = 0;
        $params['published_at'] = now();

        if ($request->file('image')) {
            $params['image'] = $request->file('image')->store('post-images');
        }

        $post = Post::create($params);
        $post->categories()->attach($params['categories']);

        Alert::success('Inpo Blog', 'Artikel berhasil disimpan');
        return redirect('/posts');
    }

    public function edit(Request $request)
    {
        $post = Post::find($request->id);
        $categories = $post->categories()->get();

        return view('blog.edit', [
            'pages' => 'Edit Artikel',
            'buttonDashboard' => '',
            'buttonPosts' => 'active',
            'buttonProfile' => '',
            'no' => 1,
            'post' => $post,
        ]);
    }

    public function posting(Request $request)
    {
        $post = Post::find($request->id);

        if ($post->user_id != Auth::user()->id) {
            Alert::toast('Artikel gagal diedit', 'error');
        } else {
            $post->update(['status' => 1]);
            Alert::toast('Artikel berhasil diedit', 'success');
        }
        return redirect()->back();
    }

    public function draft(Request $request)
    {
        $post = Post::find($request->id);

        if ($post->user_id != Auth::user()->id) {
            Alert::toast('Artikel gagal diedit', 'error');
        } else {
            $post->update(['status' => 0]);
            Alert::toast('Artikel berhasil diedit', 'success');
        }
        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $post = Post::find($request->id);

        if ($post->user_id != Auth::user()->id) {
            Alert::toast('Artikel gagal dihapus', 'error');
        } else {
            $post->delete();
            DB::table('category_post')->where('post_id', $post->id)->delete();
            Storage::delete($post->image);
            Alert::toast('Artikel berhasil dihapus', 'success');
        }
        return redirect()->back();
    }
}