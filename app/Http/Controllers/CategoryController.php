<?php

namespace App\Http\Controllers;

use App\Models\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Exception;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::user()->role !== 1) {
            return redirect('/home');
        }

        $categories = Category::paginate(10);

        return view('pages.category.categories', [
            'pages' => 'Manajemen Kategori',
            'buttonDashboard' => '',
            'buttonPosts' => '',
            'buttonCategory' => 'active',
            'buttonSetting' => '',
            'no' => 1,
            'categories' => $categories,
            'form' => 'category-create',
            'buttonText' => 'Tambah',
            'categoryId' => '',
            'categoryName' => '',
        ]);
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 1) {
            Alert::toast('Kamu tidak memiliki akses untuk menambah kategori', 'error');
            return back();
        }

        Validator::make($request->all(), [
            'name' => [
                'required',
                'string'
            ]
        ])->validate();

        $params = $request->all();
        $params['name'] = $params['name'];
        $params['slug'] = Str::slug($params['name']);

        try {
            Category::create($params);
            Alert::toast('Kategori berhasil ditambahkan', 'success');
        } catch (Exception $e) {
            report($e);
            Alert::toast('Kategori gagal ditambahkan', 'error');
        }

        return redirect('/categories');
    }

    public function edit(Request $request)
    {
        $categories = Category::all();

        return view('pages.category.categories', [
            'pages' => 'Edit Kategori',
            'buttonDashboard' => '',
            'buttonPosts' => '',
            'buttonCategory' => 'active',
            'buttonSetting' => '',
            'no' => 1,
            'categories' => $categories,
            'form' => 'category-update',
            'buttonText' => 'Edit',
            'categoryId' => $request->id,
            'categoryName' => $request->name,
        ]);
    }

    public function update(Request $request)
    {
        $category = Category::findOrFail($request->id);

        if (Auth::user()->role !== 1) {
            Alert::toast('Kamu tidak memiliki akses untuk mengedit kategori', 'error');
            return back();
        }

        $params = $request->all();
        $params['name'] = $params['name'];
        $params['slug'] = Str::slug($params['name']);

        try {
            $category->update($params);
            Alert::toast('Kategori berhasil diedit', 'success');
        } catch (Exception $e) {
            report($e);
            Alert::toast('Kategori gagal diedit', 'error');
        }

        return redirect('/categories');
    }

    public function destroy(Request $request)
    {
        $category = Category::find($request->id);

        if (Auth::user()->role !== 1) {
            Alert::toast('Kamu tidak memiliki akses untuk menghapus kategori', 'error');
        } else {
            if ($category->posts()->exists()) {
                Alert::toast('Kategori tidak bisa dihapus', 'error');
            } else {
                $category->delete();
                DB::table('category_post')->where('category_id', $category->id)->delete();
                Alert::toast('Kategori berhasil dihapus', 'success');
            }
        }

        return redirect('/categories');
    }
}