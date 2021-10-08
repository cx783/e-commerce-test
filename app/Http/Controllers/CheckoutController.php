<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CheckoutController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string'],
            'address' => ['required', 'string'],
            'state' => ['required', 'string'],
            'country' => ['required', 'string'],
            'items' => ['required', 'array'],
            'items.*.product_id' => [
                'required',
                Rule::exists('products', 'id')->where(fn ($query) => $query->where('status', 1))
            ],
            'items.*.quantity' => ['required', 'numeric'],
            'items.*.price' => ['required', 'numeric'],
            'payment.credit_card' => ['required', 'numeric'],
            'payment.credit_card_expiration' => ['required', 'string'],
            'payment.credit_card_cvv' => ['required', 'numeric'],
        ]);

        DB::beginTransaction();

        $client = Client::create($request->except(['items', 'payments']));
        
        $order = $client->orders()->create(
            $validated['payment']
        );

        foreach ($validated['items'] as $item) {
            $order->orderItems()->create($item);
        }

        DB::commit();

        return response('', 201);
    }
}
