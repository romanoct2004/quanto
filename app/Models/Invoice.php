<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'from',
        'to',
        'total_price',
        'pdf_file_url',
        'is_paid',
        'pdf_image_url'
    ];

    public function items(): HasMany {
        return $this->hasMany(InvoiceItem::class);
    }
    public function paidInvoice(): HasMany {
        return $this->hasMany(PaidInvoice::class);
    }
}
