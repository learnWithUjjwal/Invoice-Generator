@extends('layouts.app')
@section('content')
<div id="flex">
	<div class="flex6">
			
	</div>
	<div class="flex1">
		<a href="/invoice/create" class="btn btn-info"><i class="fa fa-plus"></i> Generate Invoice</a>		
	</div>
</div>
<div class="heading center">Invoice Master</div><hr class="hr">	

<table class="table container-60">
	<thead>
		<th>Invoice No.</th>
		<th>Customer Name</th>
		<th>Invoice Date</th>
		<th>Total Amount</th>
		
		<th>Action</th>
	</thead>
	<tbody>
		@foreach($invoices as $invoice)
		<tr>
			<td>{{$invoice->invoice_no}}</td>
			<td>{{$invoice->customer_name}}</td>
			<td>{{$invoice->invoice_date}}</td>
			<td>{{$invoice->total_amount}}</td>
			<td>{{$invoice->customer_name}}</td>

			<td><a href="/invoice/{{$invoice->id}}"><i class="fa fa-eye"></i></a></td>
		</tr>
		@endforeach
	</tbody>
</table>
@endsection