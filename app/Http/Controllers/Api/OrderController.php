<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Services\Order\CreateOrderService;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $orders = Order::latest()->get();

        return OrderResource::collection($orders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse | OrderResource
     */
    public function store(Request $request)
    {
        try {
            $order = app(CreateOrderService::class)->execute($request->all());
        } catch (ValidationException $e) {
            throw $e;
        }

        return new OrderResource($order);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            return new OrderResource(Order::findOrFail($id));
        } catch (\Exception $ex) {
            return response()->json('Pedido não encontrado!', 404);
        }
    }
}
