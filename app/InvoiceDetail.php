<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    protected $fillable=['invoice_id', 'product_id', 'rate', 'unit', 'quantity', 'discount_percentage', 'net_amount', 'total_amount'];

    public function product(){
    	return $this->belongsTo('App\Product', 'product_id');
    }
}
