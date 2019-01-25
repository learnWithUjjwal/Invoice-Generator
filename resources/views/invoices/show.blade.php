@extends('layouts.app')
@section('content')
<div id="flex">
	<div class="flex6">
			
	</div>
	<div class="flex1">
		<a href="/invoice" class="btn btn-info"><i class="fa fa-reply"></i> Back</a>		
	</div>
</div>
<div class="heading center">Invoice Details</div><hr class="hr">
<table class="container-60">
	<tr>
		<td>Customer Name:</td>
		<td><strong>{{$invoiceMaster->customer_name}}</strong></td>
	</tr>
	<tr>
		<td>Invoice Date</td>
		<td>{{$invoiceMaster->invoice_date}}</td>
	</tr>
	<tr>
		<td>Total Amount</td>
		<td>{{$invoiceMaster->total_amount}}/-</td>
	</tr>
</table>
<br><br>
<div class="center"><h3>Invoice Products Details</h3><hr class="hr"></div>
<table class="table">
	<thead>
		<thead>
			<th>Product Name</th>
			<th>Rate</th>
			<th>Unit</th>
			<th>Quantity</th>
			<th>Discount %</th>
			<th>Net Amount</th>
			<th>Total Amount</th>
		</thead>
		<tbody>
			@foreach($invoiceMaster->invoice_details as $item)
			<tr>
				<td>{{$item->product->product_name}}</td>
				<td>{{$item->rate}}</td>
				<td>{{$item->unit}}</td>
				<td>{{$item->quantity}}</td>
				<td>{{$item->discount_percentage}}</td>
				<td>{{$item->net_amount}}</td>
				<td>{{$item->total_amount}}</td>
			</tr>
			@endforeach
		</tbody>
	</thead>
</table>
@endsection