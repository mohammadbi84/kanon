<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'organ_id',
        'payment_id',
        'paid',
        'status',
        'invoice_details',
        'transaction_id',
        'transaction_result',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function setInvoiceDetailsAttribute($value)
    {
        $this->attributes['invoice_details'] = serialize($value);
    }
    public function getInvoiceDetailsAttribute($value)
    {
        return unserialize($this->attributes['invoice_details']);
    }
    public function setTransactionResultAttribute($value)
    {
        $this->attributes['transaction_result'] = serialize($value);
    }
    public function getTransactionResultAttribute($value)
    {
        return unserialize($this->attributes['transaction_result']);
    }
}
