<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    /**
     * Display a listing of all products.
     */
    public function index(): JsonResponse
    {
        $products = Product::with('user')->get();
        return response()->json($products, 200);
    }

    /**
     * Display the specified product by ID.
     */
    public function show(int $id): JsonResponse
    {
        $product = Product::with('user')->find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json($product, 200);
    }

    /**
     * Store a newly created product (admin only).
     */
    public function store(Request $request): JsonResponse
    {
        // Simple admin check: assume user with ID 1 is admin
        if (auth()->id() !== 1) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image_url' => $request->image_url,
            'stock_quantity' => $request->stock_quantity,
            'user_id' => auth()->id(),
        ]);

        return response()->json($product, 201);
    }

    /**
     * Log or process a request to view product details by ID.
     */
    public function viewDetails(Request $request): JsonResponse
    {
        $id = $request->input('id');

        if (!$id) {
            return response()->json(['error' => 'Product ID is required'], 400);
        }

        $product = Product::with('user')->find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        // Optionally log the request
        \Log::info("Product details requested for ID: {$id}");

        return response()->json(['message' => 'Product details retrieved', 'product' => $product], 200);
    }
}