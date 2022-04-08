<?php

namespace App\Http\Controllers;

use App\Models\Post;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $postCount = Post::where('user_id', Auth::user()->id)->count();
        $postPostingCount = Post::where('user_id', Auth::user()->id)->where('status', 1)->count();
        $postDraftCount = Post::where('user_id', Auth::user()->id)->where('status', 0)->count();
        $latestPost = Post::orderBy('published_at', 'DESC')->where('user_id', Auth::user()->id)->where('status', 1)->limit(3)->get();

        $postViews = DB::table('views')->count();
        $date = Carbon::now();

        $message = "";
        if ($latestPost->isEmpty()) {
            $message = "Belum ada artikel yang di posting";
        }

        return view('pages.home.home', [
            'pages' => 'Dashboard',
            'buttonDashboard' => 'active',
            'buttonPosts' => '',
            'buttonCategory' => '',
            'buttonUser' => '',
            'postCount' => $postCount,
            'postPostingCount' => $postPostingCount,
            'postDraftCount' => $postDraftCount,
            'status' => Auth::user()->role,
            'latestPost' => $latestPost,
            'no' => 1,
            'message' => $message,
            'postViews' => $postViews,
            'date' => $date,
        ]);
    }
}