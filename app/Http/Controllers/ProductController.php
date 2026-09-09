<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // Method 1: Using new and save
    public function addProduct()
    {
        $product = new Product();
        $product->name = 'Laptop';
        $product->description = 'High-performance laptop for work';
        $product->price = 999.99;
        $product->stock = 10;
        $product->status = 'active';
        $product->save();

        return 'Product Added Successfully!';
    }

    // Method 2: Using create method
    public function addProductWithCreate()
    {
        $product = Product::create([
            'name' => 'Smartphone',
            'description' => 'Latest smartphone with 5G',
            'price' => 599.99,
            'stock' => 25,
            'status' => 'active'
        ]);

        return 'Product Added Successfully! ID: ' . $product->id;
    }

    // Method 3: Using insert method
    public function addProductWithInsert()
    {
        DB::table('products')->insert([
            'name' => 'Tablet',
            'description' => '10-inch tablet with stylus',
            'price' => 299.99,
            'stock' => 15,
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return 'Product Added Successfully!';
    }

    // Method 4: Using firstOrCreate
    public function firstOrCreateProduct()
    {
        $product = Product::firstOrCreate(
            ['name' => 'Laptop'],
            [
                'description' => 'Premium laptop',
                'price' => 1299.99,
                'stock' => 5,
                'status' => 'active'
            ]
        );

        return 'Product Added Successfully!';
    }

    // Method 5: Using updateOrCreate
    public function updateOrCreateProduct()
    {
        $product = Product::updateOrCreate(
            ['name' => 'Laptop'],
            [
                'description' => 'New description',
                'price' => 1399.99,
                'stock' => 8,
                'status' => 'active'
            ]
        );

        return 'Product Added Successfully!';
    }

    // Insert Multiple Products at Once
    public function addMultipleProducts()
    {
        $products = [
            [
                'name' => 'Product 1',
                'description' => 'Description 1',
                'price' => 100.00,
                'stock' => 10,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Product 2',
                'description' => 'Description 2',
                'price' => 200.00,
                'stock' => 20,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('products')->insert($products);

        return 'Multiple Products Added Successfully!';
    }
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'status' => 'required|in:active,inactive'
    ]);

    $product = Product::create($validated);

    return response()->json([
        'message' => 'Product created successfully!',
        'data' => $product
    ], 201);
}
}