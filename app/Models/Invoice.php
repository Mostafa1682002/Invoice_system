<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'invoice_number', 'invoice_date', 'due_date',
        'product', 'section_id', 'discount',
        'amount_collection', 'amount_commission',
        'rate_vat', 'value_vat', 'total',
        'status', 'value_status', 'notes', 'payment_date'
    ];
    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
