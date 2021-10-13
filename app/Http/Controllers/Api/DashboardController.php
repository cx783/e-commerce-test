<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        // This should be in a separate file
        return response()->json([
            'products' => Product::count(),
            'orders' => Order::count(),
            'users' => User::count()
        ]);
    }
}
