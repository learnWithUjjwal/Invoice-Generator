<?php

namespace App\Http\Controllers;

use App\InvoiceMaster;
use App\Product;
use App\InvoiceDetail;
use Illuminate\Http\Request;

class InvoiceMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = InvoiceMaster::all();
        return view('invoices.index', compact('invoices'));        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::all();
        // dd($products);
        return view('invoices.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   $total_amount = 0;
        // dd($request->total_amount);
        foreach($request->total_amount as $amount){
            $total_amount+=$amount;
        }
        // dd($total_amount);
        // dd($request->all());
        $invoice_count = count(InvoiceMaster::all());
        $invoice = InvoiceMaster::create([
            'invoice_date' => now(),
            'customer_name' => $request->customer_name,
            'total_amount' => $total_amount,
            'invoice_no' => ++$invoice_count
            ]);
        
        $invoice_details = [];
        for($i = 0; $i<count($request->rate); $i++){
            $invoice_details[]=[
                'invoice_id' => $invoice->id,
                'product_id' => $request->product_id[$i],
                'rate' => $request->rate[$i],
                'unit' => $request->unit[$i],
                'quantity' => $request->quantity[$i],
                'net_amount' => $request->net_amount[$i],
                'total_amount' => $request->total_amount[$i],
                'discount_percentage' => $request->discount_percentage[$i],
            ];
        }
        InvoiceDetail::insert($invoice_details);
        // dd($invoice_details);
        return redirect()->route('invoice.index')->with('success', 'Invoice has been generated successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\InvoiceMaster  $invoiceMaster
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoiceMaster = InvoiceMaster::find($id);
        return view('invoices.show', compact('invoiceMaster'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InvoiceMaster  $invoiceMaster
     * @return \Illuminate\Http\Response
     */
    public function edit(InvoiceMaster $invoiceMaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InvoiceMaster  $invoiceMaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InvoiceMaster $invoiceMaster)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InvoiceMaster  $invoiceMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvoiceMaster $invoiceMaster)
    {
        //
    }
}
