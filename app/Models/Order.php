<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\belongsToMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'status', 'total'];
    protected $casts = ['created_at'];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return belongsToMany
     */
    public function products(): belongsToMany
    {
           return $this->belongsToMany(Product::class, 'order_products')
                ->withPivot('quantity');
    }
}
