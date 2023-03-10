<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Alfa6661\AutoNumber\AutoNumberTrait;

class Cart extends Model
{
    use HasFactory, AutoNumberTrait;
    protected $table = 'carts';
    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at'];

    public function customer()
    {
        return $this->belongsTo(Costumer::class, 'customers_id', 'id');
    }

    public function produk()
    {
        return $this->belongsTo(Product::class, 'products_id', 'id');
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }

    public function getAutoNumberOptions()
    {
        return [
            'kd_carts' => [
                'format' => function () {
                    return date('d-m-y') . '-KSR-?';
                },
                'length' => 3
            ]
        ];
    }
}
