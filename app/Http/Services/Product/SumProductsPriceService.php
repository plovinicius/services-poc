<?php

namespace App\Http\Services\Product;

use App\Http\Services\BaseService;
use App\Models\Product;

class SumProductsPriceService extends BaseService {

    public function execute(array $productsId)
    {
        return Product::whereIn('id', $productsId)
                ->sum('price');
    }
}
