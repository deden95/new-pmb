<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class ItemPayment extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak sesuai dengan nama model
    protected $table = 'item_payment';

    // Tentukan kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'name',
        'amount',
        'type_payment',
        'status',
        'note',
    ];

    // Tentukan kolom yang tidak dapat diisi (guarded) jika diperlukan
    // protected $guarded = ['id'];

    // Jika perlu, Anda bisa menambahkan relasi di sini (misalnya, jika model ini berhubungan dengan model lain)
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
}
