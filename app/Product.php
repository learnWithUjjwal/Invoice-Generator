<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable=['product_name', 'rate', 'unit'];
    public function invoice_details(){
    	return $this->hasMany('App\InvoiceDetail', 'product_id');
    }

}
