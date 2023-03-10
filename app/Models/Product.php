<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Alfa6661\AutoNumber\AutoNumberTrait;

class Product extends Model
{
    use HasFactory, AutoNumberTrait;
    protected $table = 'products';
    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at'];

    public function kategori()
    {
        return $this->belongsTo(Category::class, 'categoris_id', 'id');
    }

    public function cart()
    {
        return $this->hasMany(Cart::class, 'products_id', 'id');
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
            'kd_product' => [
                'format' => function () {
                    return date('Y.m.d') . '-BRG-?';
                },
                'length' => 5
            ]
        ];
    }
}
