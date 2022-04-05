<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class BlogController extends Controller
{

    public function index()
    {
        $posts = Post::orderBy('published_at', 'DESC')->where('status', '1')->paginate(6);
        $categories = Category::all();

        return view('pages.blog.index', [
            'posts' => $posts,
            'categories' => $categories,
        ]);
    }

    public function showPost($user, $id, $slug)
    {
        $post = Post::find($id);
        $categories = Category::all();

        $next = Post::where('id', '>', $post->id)->orderBy('id')->first();
        $previous = Post::where('id', '<', $post->id)->orderBy('id', 'desc')->first();

        return view('pages.blog.showPost', [
            'post' => $post,
            'categories' => $categories,
            'next' => $next,
            'previous' => $previous,
        ]);
    }

    public function showByCategory($categorySlug)
    {
        $category = Category::where('slug', $categorySlug)->first();
        $posts = $category->posts()->paginate(6);
        $categories = Category::all();

        return view('pages.blog.showByCategory', [
            'posts' => $posts,
            'categories' => $categories
        ]);
    }

    public function showByTag($tagSlug)
    {
        $posts = Post::withAllTags($tagSlug)->paginate(6);
        $categories = Category::all();

        return view('pages.blog.showByTag', [
            'posts' => $posts,
            'categories' => $categories
        ]);
    }

    public function showByUser($user)
    {
        $user = User::where('name', $user)->first();
        $posts = $user->posts()->paginate(6);
        $categories = Category::all();

        return view('pages.blog.showByUser', [
            'posts' => $posts,
            'categories' => $categories
        ]);
    }
}