<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Exception;
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
        $posts = Post::with('user')->orderBy('created_at', 'DESC')->where('user_id', Auth::user()->id)->paginate(10);

        return view('pages.post.posts', [
            'pages' => 'Manajemen Artikel',
            'buttonDashboard' => '',
            'buttonPosts' => 'active',
            'buttonCategory' => '',
            'buttonUser' => '',
            'no' => 1,
            'posts' => $posts,
        ]);
    }

    public function create()
    {
        $categories = Category::all();

        return view('pages.post.create', [
            'pages' => 'Buat Artikel',
            'pages' => 'Buat Artikel',
            'buttonDashboard' => '',
            'buttonPosts' => 'active',
            'buttonCategory' => '',
            'buttonUser' => '',
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        // try {
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
                'max:2'
            ],
            'image' => [
                'required',
                'mimes:jpg,jpeg,png,gif',
                'max:1024',
            ],
            'tags' => [
                'required'
            ]
        ])->validate();

        $params = $request->all();

        $params['title'] = $params['title'];
        $params['slug'] = Str::slug($params['title']);
        $params['content'] = $params['content'];
        $params['user_id'] = $request->user()->id;
        $params['status'] = 0;

        if ($request->file('image')) {
            $params['image'] = $request->file('image')->store('post-images');
        }

        $tags = explode(",", $params['tags']);

        $post = Post::create($params);
        $post->categories()->attach($params['categories']);
        $post->tag($tags);

        Alert::success('', 'Artikel berhasil disimpan');
        return redirect('/posts');

        // } catch (Exception $e) {
        //     report($e);
        //     Alert::toast($e->getMessage(), 'error');
        //     return redirect('/post-create');
        // }
    }

    public function edit(Request $request)
    {
        $post = Post::find($request->id);
        $categories = Category::all();
        $categoriesPost = $post->categories()->get();

        return view('pages.post.edit', [
            'pages' => 'Edit Artikel',
            'buttonDashboard' => '',
            'buttonPosts' => 'active',
            'buttonCategory' => '',
            'buttonUser' => '',
            'no' => 1,
            'post' => $post,
            'categories' => $categories,
            'categoriesPost' => $categoriesPost,
        ]);
    }

    public function update(Request $request)
    {
        // try {
        $post = Post::findOrFail($request->id);

        if ($post->user_id !== Auth::user()->id) {
            abort(403);
        }

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
                'max:2'
            ],
            'tags' => [
                'required'
            ]
        ])->validate();

        $params = $request->all();

        $params['title'] = $params['title'];
        $params['slug'] = Str::slug($params['title']);
        $params['content'] = $params['content'];
        $params['user_id'] = $request->user()->id;
        $params['status'] = $params['status'];

        if ($request->file('image')) {
            Storage::delete($post->image);
            $params['image'] = $request->file('image')->store('post-images');
        }

        $tags = explode(",", $params['tags']);

        $post->update($params);
        $post->categories()->sync($params['categories']);
        $post->untag();
        $post->tag($tags);

        Alert::success('', 'Artikel berhasil diedit');
        return redirect('/posts');

        // } catch (Exception $e) {
        //     report($e);
        //     Alert::toast($e->getMessage(), 'error');
        //     return redirect('/posts');
        // }
    }

    public function posting(Request $request)
    {
        $post = Post::find($request->id);

        if ($post->user_id !== Auth::user()->id) {
            abort(403);
        }

        $post->update(['status' => 1, 'published_at' => now()]);
        Alert::toast('Artikel berhasil diedit', 'success');

        return redirect('/posts');
    }

    public function draft(Request $request)
    {
        $post = Post::find($request->id);

        if ($post->user_id !== Auth::user()->id) {
            abort(403);
        }

        $post->update(['status' => 0]);
        Alert::toast('Artikel berhasil diedit', 'success');

        return redirect('/posts');
    }

    public function destroy(Request $request)
    {
        $post = Post::find($request->id);

        if ($post->user_id !== Auth::user()->id) {
            abort(403);
        }

        $post->delete();
        $post->untag();
        DB::table('category_post')->where('post_id', $post->id)->delete();
        Storage::delete($post->image);
        Alert::toast('Artikel berhasil dihapus', 'success');

        return redirect('/posts');
    }
}