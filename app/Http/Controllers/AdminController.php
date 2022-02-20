<?php

namespace App\Http\Controllers;

use App\Jobs\ExportCategories;
use App\Jobs\ExportProducts;
use App\Jobs\ImportCategories;
use App\Jobs\ImportProducts;
use App\Models\Category;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function admin ()
    {
        return view('admin.admin');
    }

    public function users ()
    {
        $users = User::get();
        $roles = Role::get();

        $data = [
            'title' => 'Список ролей и пользователей',
            'users' => $users,
            'roles' => $roles
        ];

        return view('admin.users', $data);
    }

    public function product (Product $product)
    {
        $data = [
            'title' => 'Редактирование продукта',
            'product' => $product,
        ];

        return view('admin.product', $data);
    }

    public function products ()
    {
        $products = Product::get();
        $categories = Category::get();

        $data = [
            'title' => 'Список товаров',
            'products' => $products,
            'categories' => $categories
        ];

        return view('admin.products', $data);
    }

    public function category (Category $category)
    {

        $data = [
            'title' => 'Редактирование категории',
            'category' => $category,
        ];

        return view('admin.category', $data);
    }

    public function createProduct ()
    {
        $input = request()->all();
        $picture = $input['picture'] ?? null;

        request()->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'category_id' => 'required',
            'picture' => 'mimes:jpg,bmp,png,webp|nullable'
        ]);

        $data = [];

        $data['name'] = $input['name'];
        $data['description'] = $input['description'];

        if ($picture) {
            $ext = $picture->getClientOriginalExtension();
            $fileName = time() . rand(10000, 99999) . '.' . $ext;
            $picture->storeAs('public/products', $fileName);
            $picture = 'products/' . $fileName;
            $data['picture'] = $picture;
        }

        $data['price'] = $input['price'];
        $data['category_id'] = $input['category_id'];

        $product = new Product($data);

        $product->save();

        session()->flash('productCreate');

        return back();
    }

    public function categories ()
    {
        $categories = Category::get();

        $data = [
            'title' => 'Список категорий',
            'categories' => $categories,
        ];

        return view('admin.categories', $data);
    }

    public function createCategory ()
    {
        $input = request()->all();
        $picture = $input['picture'] ?? null;

        request()->validate([
            'name' => 'required',
            'description' => 'required',
            'picture' => 'mimes:jpg,bmp,png,webp|nullable'
        ]);

        $data = [];

        $data['name'] = $input['name'];
        $data['description'] = $input['description'];

        if ($picture) {
            $ext = $picture->getClientOriginalExtension();
            $fileName = time() . rand(10000, 99999) . '.' . $ext;
            $picture->storeAs('public/categories', $fileName);
            $picture = 'categories/' . $fileName;
            $data['picture'] = $picture;
        }

        $category = new Category($data);

        $category->save();

        session()->flash('categoryCreate');

        return back();
    }

    public function enterAsUser ($id)
    {
        Auth::loginUsingId($id);
        return redirect()->route('home');
    }

    public function exportCategories()
    {
        ExportCategories::dispatch();
        session()->flash('startExportCategories');
        return back();
    }

    public function importCategories()
    {
        request()->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);

        $input = request()->all();
        $file = $input['file'];

        $ext = $file->getClientOriginalExtension();
        $fileName = time() . rand(10000, 99999) . '.' . $ext;
        $tmp_file = $file->storeAs('public/tmp', $fileName);

        ImportCategories::dispatch($tmp_file);
        session()->flash('startImportCategories');
        return back();
    }

    public function exportProducts()
    {
        ExportProducts::dispatch();
        session()->flash('startExportProducts');
        return back();
    }

    public function importProducts()
    {
        request()->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);

        $input = request()->all();
        $file = $input['file'];

        $ext = $file->getClientOriginalExtension();
        $fileName = time() . rand(10000, 99999) . '.' . $ext;
        $tmp_file = $file->storeAs('public/tmp', $fileName);

        ImportProducts::dispatch($tmp_file);
        session()->flash('startImportProducts');
        return back();
    }

    public function addRole ()
    {
        request()->validate([
            'name' => 'required|min:3',
        ]);

        Role::create([
            'name' => request('name')
        ]);
        return back();
    }

    public function addRoleToUser ()
    {
        request()->validate([
            'user_id' => 'required',
            'role_id' => 'required',
        ]);

        $user = User::find(request('user_id'));
        $user->roles()->attach(Role::find(request('role_id')));
        return back();
    }

}