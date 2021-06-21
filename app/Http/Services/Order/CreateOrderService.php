<?php

namespace App\Http\Services\Order;

use App\Http\Services\BaseService;
use App\Http\Services\Product\SumProductsPriceService;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class CreateOrderService extends BaseService {

    /**
     * Get the validation rules that apply to the service.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
        ];
    }

    /**
     * Execute service
     *
     * @param array $data
     *
     * @return Order
     * @throws \Exception
     */
    public function execute(array $data): Order
    {
        $this->validate($data);

        DB::beginTransaction();

        try {
            $totalPrice = (new SumProductsPriceService)->execute(array_column($data['products'], 'id'));

            $order = Order::create([
                'user_id' => $data['user_id'],
                'status' => 'pending',
                'total' => $totalPrice
            ]);

            foreach($data['products'] as $product) {
                $order->products()->attach($product['id'], [
                    'quantity' => $product['quantity']
                ]);
            }

            DB::commit();

            return $order;
        } catch (\Exception $ex) {
            DB::rollBack();

            throw $ex;
        }
    }
}
