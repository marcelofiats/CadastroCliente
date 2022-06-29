<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = "transactions";

    protected $fillable = [
        'id',
        'id_client',
        'type',
        'amount',
        'created_at',
        'updated_at',
    ];

    public function users()
    {
        return $this->hasOne(User::class, 'id_client');
    }
}
