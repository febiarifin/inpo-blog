<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = User::where('role', '!=', 1)->paginate(10);

        return view('pages.user.users', [
            'pages' => 'Manajemen User',
            'buttonDashboard' => '',
            'buttonPosts' => '',
            'buttonCategory' => '',
            'buttonUser' => 'active',
            'no' => 1,
            'users' => $users,
        ]);
    }

    public function userBanned(Request $request)
    {
        $user = User::find($request->id);
        $user->update(['role' => '2']);
        Post::where('user_id', $request->id)->update(['status' => 2]);

        Alert::toast('User berhasil dibanned', 'success');
        return redirect('/users');
    }

    public function userActivate(Request $request)
    {
        $user = User::find($request->id);
        $user->update(['role' => '0']);
        Post::where('user_id', $request->id)->update(['status' => 0]);

        Alert::toast('User berhasil diaktifkan', 'success');
        return redirect('/users');
    }

    public function userEdit()
    {
        return view('pages.user.profile', [
            'pages' => 'Profil',
            'buttonDashboard' => '',
            'buttonPosts' => '',
            'buttonCategory' => '',
            'buttonUser' => '',
        ]);
    }

    public function userUpdate(Request $request)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ])->validate();

        $id = $request->id;
        $name = $request->name;
        $email = $request->email;
        $password = Hash::make($request->password);

        $user = User::findOrFail($id);
        $user->update(['name' => $name, 'email' => $email, 'password' => $password]);

        Alert::toast('Profil berhasil diperbaharui', 'success');
        return redirect('/home');
    }
}