@extends('layouts.app')
@section('content')
<form method="POST" action="{{route('invoice.store')}}">
@csrf
<div class="heading center">Generate Invoice</div><hr class="hr">
<div class="right"></div>
<div id="invoice_master" class="container-60">
	<div id="flex" class="padding-15">
		<div class="flex1">
		Customer Name:	
		</div>
		<div class="flex4">
			<input type="text" name="customer_name" class="form-control">	
		</div>
	</div>
	<div id="flex" class="padding-15">
		<div class="flex1">
		Product:	
		</div>
		<div class="flex3">
			<select class="form-control" id="product" data-products="{{$products}}">
			<option>Select Product</option>
				@foreach($products as $product)
				<option value="{{$product->id}}" data-product="{{$product}}">{{$product->product_name}}</option>
				@endforeach
			</select>	
		</div>
	</div>
	<div id="flex" class="padding-15">
		<div class="flex1">
		Rate:	
		</div>
		<div class="flex3">
			<input type="text" id="rate" readonly="readonly">
		</div>
	</div>
	<div id="flex" class="padding-15">
		<div class="flex1">
		Unit:	
		</div>
		<div class="flex3">
			<input type="text" id="unit" readonly="readonly">
		</div>
	</div>
	<div id="flex" class="padding-15">
		<div class="flex1" >
		Qty:	
		</div>
		<div class="flex3">
			<input type="text" id="quantity">
		</div>
	</div>
	<div id="flex" class="padding-15">
		<div class="flex1">
		Discount %:	
		</div>
		<div class="flex3">
			<input type="text" id="discount_percentage">
		</div>
	</div>
	<div id="flex" class="padding-15">
		<div class="flex1">
		Net Amount:	
		</div>
		<div class="flex3">
			<input type="text" id="net_amount" readonly="readonly">
		</div>
	</div>
	<div id="flex" class="padding-15">
		<div class="flex1">
		Total Amount:	
		</div>
		<div class="flex3">
			<input type="text" id="total_amount" readonly="readonly">
		</div>
	</div>
	<div id="flex" class="padding-15">
		<div class="flex1">
		</div>
		<div class="flex1"><div class="btn btn-primary" id="add_new_row"><i class="fa fa-plus"></i> Add</div>	</div>
		<div class="flex3">
			
		</div>
	</div>
	
</div>

<!-- Invoive Details -->
<div class="container-60">
		<table class="table">
		<thead>
			<th>Product</th>
			<th>Rate</th>
			<th>Unit</th>
			<th>Quantity</th>
			<th>Discount %</th>
			<th>Net Amount</th>
			<th>Total Amount</th>
			<th>Action</th>
		</thead>
		<tbody id="product_details_container">
			
		</tbody>
	</table>
</div>	 
	
<input type="submit" name="submit" class="btn btn-primary">
</form>
@endsection

@section('internal_js')
	<script type="text/javascript">
		$(function(){
			let products_array = JSON.parse($('#product').attr('data-products'));
			console.log(products_array);
			let product_object={};
			$('#product').change(function(){
				let product = $(this).find(":selected").attr('data-product');
				product_object = JSON.parse(product);
				console.log(product_object);
				let {rate, unit} = product_object;
				console.log(rate);
				rate = parseInt(rate);
				$('#rate').val(rate);
				$('#unit').val(unit);
			});

			$('#quantity').keyup(function(){
				let{rate} = product_object;
				let quantity = parseInt($(this).val());
				quantity = parseInt(quantity);
				let net_amount = rate*quantity;
				console.log(net_amount);
				$('#net_amount').val(net_amount);
			});

			$('#discount_percentage').keyup(function(){
				let discount_percentage = parseInt($(this).val());
				let net_amount = parseInt($('#net_amount').val());
				let total_amount = net_amount - ((discount_percentage*net_amount)/100);
				console.log(total_amount);
				$('#total_amount').val(total_amount);
			});

			//On Click of add new button
			$('#add_new_row').click(function(){
				
				console.log('hello');
				//put all the values from the form
				const{product_name, rate, unit} = product_object;
				let quantity = $('#quantity').val();
				let net_amount = $('#net_amount').val();
				let total_amount = $('#total_amount').val();
				let product_selected = JSON.parse($('#product').find(":selected").attr('data-product'));
				console.log(product_selected);

				
				let discount_percentage = $('#discount_percentage').val();
				//put it into the row
				let tr_element = `<tr><td><select name="product_id[]" class="product_id"><option value="${product_selected.id}">${product_selected.product_name}</option>`;
				for(product of products_array){
					if(product.id == product_selected.id){
						continue;
					}
					tr_element+=`<option value="${product.id}">${product.product_name}</option>`;
					console.log(product.product_name);
				}
				tr_element+=`</select></td>
				<td><input type="text" name="rate[]" value="${rate}" class="rate" readonly="readonly"></td>
				<td><input type="text" name="unit[]" value="${unit}" class="unit" readonly="readonly"></td>				
<td><input type="text" name="quantity[]" value="${quantity}" class="quantity"></td>
<td><input type="text" name="discount_percentage[]" value="${discount_percentage}" class="discount_percentage"></td>
<td><input type="text" name="net_amount[]" value="${net_amount}" readonly="readonly" class="net_amount"></td>
<td><input type="text" name="total_amount[]" value="${total_amount}" class="total_amount" readonly="readonly"></td>
<td class="remove_row"><i class="fa fa-minus"></i> Remove</td>
				</tr>`;

				//then insert in into the table
				$('#product_details_container').append(tr_element);
				$('.flex3 input').val('');
			});

			$('#product_details_container').on('click', '.remove_row', function(){
				console.log('Hello')
				$(this).parent('tr').remove();
			});
			$('#product_details_container').on('keyup', '.quantity', function(){
				$rate = $(this).closest('tr').find('.rate');
				let rate = parseInt($(this).closest('tr').find('.rate').val());
				console.log($rate);
				console.log(rate);
				let quantity = parseInt($(this).val());
				let net_amount = rate*quantity;
				$(this).closest('tr').find('.net_amount').val(net_amount);
			});	
			$('#product_details_container').on('keyup', '.discount_percentage', function(){
				$net_amount = $(this).closest('tr').find('.net_amount');
				let net_amount = parseInt($(this).closest('tr').find('.net_amount').val());
				console.log($net_amount);
				console.log(net_amount);
				let discount_percentage = parseInt($(this).val());
				let total_amount = net_amount - ((discount_percentage*net_amount)/100);
				$(this).closest('tr').find('.total_amount').val(total_amount);
			});	
			$('#product_details_container').on('change', '.product_id', function(){
				//get the selected product
				let product_id = $(this).val();
				console.log($(this))
				console.log(product_id);
				let product_data = {};
				for(product of products_array){
					if(product_id == product.id){
						product_data = product;
					}
				}
				console.log(product_data);
				let {rate, unit} = product_data;
				console.log(rate)
				console.log(unit)
				//change the value of rate & unit
				$(this).closest('tr').find('.rate').val(rate);
				$(this).closest('tr').find('.unit').val(unit);
				let $quantity = $(this).closest('tr').find('.quantity');
				let quantity = parseInt($quantity.val());
				let $discount_percentage = $(this).closest('tr').find('.discount_percentage');
				let discount_percentage = parseInt($discount_percentage.val());
				//change the net amount & total amount
				let net_amount = rate*quantity;
				let total_amount = net_amount - ((discount_percentage*net_amount)/100);
				$(this).closest('tr').find('.total_amount').val(total_amount);
				$(this).closest('tr').find('.net_amount').val(net_amount);
			});
		});
	</script>
@endsection
