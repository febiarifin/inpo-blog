<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Exception;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class BlogController extends Controller
{

    public function index()
    {
        $posts = Post::with(['categories', 'user', 'tagged'])->orderBy('published_at', 'DESC')->where('status', '1')->paginate(9);
        // $posts = Post::with(['categories', 'user', 'taggable'])->get();
        $categories = Category::all();

        return view('pages.blog.posts', [
            'posts' => $posts,
            'categories' => $categories,
            'menuActive' => "",
            'title' => config('app.name'),
        ]);
    }

    public function showPost($user, $id, $slug)
    {
        try {
            $user = User::where('name', $user)->first();
            $post = Post::where('id', $id)->where('slug', $slug)->where('user_id', $user->id)->where('status', 1)->first();

            $relatedPosts = Post::with(['categories', 'user', 'tagged'])->inRandomOrder()->limit(6)->get();

            views($post)->record();

            if (!$post) {
                abort(403);
            }

            $categories = Category::all();

            $next = Post::where('id', '>', $post->id)->orderBy('id')->first();
            $previous = Post::where('id', '<', $post->id)->orderBy('id', 'desc')->first();

            return view('pages.blog.showPost', [
                'post' => $post,
                'categories' => $categories,
                'next' => $next,
                'previous' => $previous,
                'menuActive' => "",
                'relatedPosts' => $relatedPosts,
                'title' => $post->title,
            ]);
        } catch (Exception  $e) {
            report($e);
            abort(403);
        }
    }

    public function showByCategory($categorySlug)
    {
        $category = Category::where('slug', $categorySlug)->first();
        $posts = $category->posts()->with(['categories', 'user', 'tagged'])->where('status', 1)->paginate(9);
        // $posts = $category->posts->load('categories', 'user', 'tagged')->where('status', 1);
        $categories = Category::all();

        return view('pages.blog.showByCategory', [
            'posts' => $posts,
            'categories' => $categories,
            'menuActive' => $categorySlug,
            'title' => 'Show by Category : ' . $categorySlug,
        ]);
    }

    public function showByTag($tagSlug)
    {
        // $posts = Post::withAllTags($tagSlug)->where('status', 1)->paginate(9);
        $posts = Post::withAllTags($tagSlug)->with(['categories', 'user', 'tagged'])->where('status', 1)->paginate(9);
        $categories = Category::all();

        return view('pages.blog.showByTag', [
            'posts' => $posts,
            'categories' => $categories,
            'menuActive' => "",
            'title' => 'Show by Tag : ' . $tagSlug,
        ]);
    }

    public function showByUser($user)
    {
        $user = User::where('name', $user)->first();
        $posts = $user->posts()->with(['categories', 'user', 'tagged'])->where('status', 1)->paginate(9);
        // $posts = $user->posts->load('categories', 'user', 'tagged')->where('status', 1);
        $categories = Category::all();

        return view('pages.blog.showByUser', [
            'posts' => $posts,
            'categories' => $categories,
            'menuActive' => "",
            'title' => 'Show by User : ' . $user->name,
        ]);
    }

    public function search(Request $request)
    {
        $posts = Post::with(['categories', 'user', 'tagged'])->where('title', 'LIKE', '%' . $request->keyword . '%')->where('status', 1)->get();
        $categories = Category::all();

        $message = "";

        if ($posts->isEmpty()) {
            $message = "Kata kunci '<b>" . $request->keyword . "</b>' tidak ditemukan";
        }

        return view('pages.blog.showSearch', [
            'posts' => $posts,
            'categories' => $categories,
            'menuActive' => "",
            'messageResult' => $message,
            'title' => 'Keywords : ' . $request->keyword,
        ]);
    }

    public function showPreview($user, $id, $slug)
    {
        try {
            $user = User::where('name', $user)->first();
            $post = Post::where('id', $id)->where('slug', $slug)->where('user_id', $user->id)->first();
            $categories = Category::all();

            if (!$post) {
                abort(403);
            }

            return view('pages.blog.showPreviewPost', [
                'post' => $post,
                'categories' => $categories,
                'menuActive' => "",
            ]);
        } catch (Exception $e) {
            report($e);
            abort(403);
        }
    }
}