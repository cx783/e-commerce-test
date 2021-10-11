<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->middleware('auth:sanctum')->except('index', 'show');
        $this->request = $request;
    }

    public function index()
    {
        return response()->json(
            Product::filter($this->request->only('name', 'trashed'))
                ->paginate($this->request->get('per_page', 15)),
            200
        );
    }

    public function show(Product $product)
    {
        return response()->json(
            $product
        );
    }

    public function store()
    {
        $validated = $this->validateRequest();

        $newProduct = Product::create($validated);

        return response()->json(
            $newProduct,
            201
        );
    }

    public function update(Product $product)
    {
        $validated = $this->validateRequest();

        $product->update($validated);

        return response()->json($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([], 204);
    }

    private function validateRequest()
    {
        return $this->request->validate([
            'name' => ['required', 'string'],
            'description' => ['string', 'nullable'],
            'price' => ['required', 'numeric'],
            'status' => ['required', 'boolean']
        ]);
    }
}
