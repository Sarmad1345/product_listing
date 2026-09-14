<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // public function dbGet()
    // {
    //     DB::connection()->getPdo();
    //     $user = DB::select("select * from products");
    //     if($user){
    //         return $user;
    //     } else {
    //         return "No data found!";
    //     }
    // }


    // public function dbPostData()
    // {
    //    $user =  DB::insert("insert into products (title, description, category, price, image, seller_name) values (?, ?, ?, ?, ?, ?)", [
    //         'test',
    //         'test',
    //         'test',
    //         1.00,
    //         'test',
    //         'test'
    //     ]);

    //     if ($user) {
    //         return "Data inserted successfully!";
    //     } else {
    //         return "Data not inserted!";
    //     }

    // }
    // public function updateData()
    // {
    //    $user =  DB::update("update products set title = ?, price = ? where id = ?", [
    //         'test updated',
    //         2.00,
    //         1
    //     ]);

    //     if($user)
    //     {
    //         return "Data updated successfully!";
    //     } else {
    //         return "Data not updated!";
    //     }


    // }
    // public function deleteData($id)
    // {
    //     $user = DB::delete("delete from products where id = ?", [$id]);
    //     if ($user) {
    //         return "Data deleted successfully!";
    //     } else {
    //         return "Data not found!";
    //     }
    // }



    public function index(Request $request)
    {
        $query = Product::query();

        // Search
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Sort
        match($request->sort) {
            'price_low_high' => $query->orderBy('price', 'asc'),
            'price_high_low' => $query->orderBy('price', 'desc'),
            'a_z'            => $query->orderBy('title', 'asc'),
            'z_a'            => $query->orderBy('title', 'desc'),
            default          => $query->latest(),
        };

        $products = $query->get();

        return view('products.index', [
            'products' => $products,
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'required',
                'string',
                'max:5000',
            ],

            'category' => [
                'required',
                'string',
                'max:100',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
                'max:99999999.99',
            ],

            'image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'seller_name' => [
                'required',
                'string',
                'max:100',
            ],
        ]);


        // Upload image
        $imagePath = $request
            ->file('image')
            ->store('products', 'public');

        Product::create([
            'title'       => $validated['title'],
            'description' => $validated['description'],
            'category'    => $validated['category'],
            'price'       => $validated['price'],
            'image'       => $imagePath,
            'seller_name' => $validated['seller_name'],
        ]);

        return redirect()
            ->route('products.index')
            ->with('success', 'Item uploaded successfully.');
    }
}
