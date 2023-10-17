<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaidInvoice extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'email',
        'name',
        'kana',
        'zip_code',
        'address1',
        'address2',
        'address3',
        'phone_number',
    ];
}
