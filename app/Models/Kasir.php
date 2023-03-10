<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Alfa6661\AutoNumber\AutoNumberTrait;

class Kasir extends Model
{
    use HasFactory, SoftDeletes, AutoNumberTrait;
    protected $table = 'kasirs';
    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function karyawan()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
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
            'kd_transaksi' => [
                'format' => function () {
                    return date('d-m-y') . '-KSR-?';
                },
                'length' => 3
            ]
        ];
    }
}
