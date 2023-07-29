<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice_Details extends Model
{
    use HasFactory;
    use HasFactory;
    protected $fillable = [
        'invoice_number', 'invoice_id',
        'product', 'section', 'status',
        'value_status', 'notes', 'user'
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
