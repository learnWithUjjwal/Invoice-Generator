<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceMaster extends Model
{
    protected $fillable=['customer_name', 'total_amount', 'invoice_no', 'invoice_date'];
    public function invoice_details(){
    	return $this->hasMany('App\InvoiceDetail', 'invoice_id');
    }

    
}
