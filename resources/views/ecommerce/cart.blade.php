@extends('layouts.ecommerce')

@section('title', "Neko eCommerce - Best solution for Accessories")

@section('user_defined_style')
<link href="{{ asset('ecommerce/css/cart.css') }}" rel="stylesheet">
<link href="{{ asset('ecommerce/css/custom.css') }}" rel="stylesheet">
@endsection


@section('content')
<main class="bg_gray min-vh-100">
	<div class="container margin_30">
		<div class="page_header">
			<div class="breadcrumbs">
				<ul>
					<li><a href="#">Home</a></li>
					<li>Cart</li>
				</ul>
			</div>
			<h1>Cart page</h1>
		</div>
		@if(($data->carts) != null)
		<!-- /page_header -->
		<table class="table table-striped cart-list">
			<thead>
				<tr>
					<th style="width: 5%;"></th>
					<th style="width: 50%;">Product</th>
					<th style="width: 15%;">Price</th>
					<th style="width: 15%;">Quantity</th>
					<th style="width: 15%;">Subtotal</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php $total = 0  ?>
				@foreach ($data->carts as $cart)
				@php
				$discount = $cart->discount != null || $cart->discount != 0 ? $cart->discount : 0;
				$newPrice = ((int)$cart->price - ((int)$cart->price * ((int)$cart->discount) / 100));
				@endphp
				<tr>
					<td class="text-center">
						<meta name="csrf-token" content="{{ csrf_token() }}" />
						<div class="col-12 text-center">
							<input type="checkbox" name="cartbox" class="form-control" data-id="{{$cart->product_id}}" data-quantity="{{ isset($cart->quantity) ? $cart->quantity : 0 }}" style="height: 20px; width:20px;">
						</div>
					</td>
					<td>
						<div class="thumb_cart">
							@if ($cart->thumbnail != "" || $cart->thumbnail != null)
								<img src="{{ url('images/products/' . $cart->thumbnail) }}" data-src="{{ url('images/products/' . $cart->thumbnail) }}" class="lazy" alt="Image">
							@else
								<img src="{{ url('images/products/placeholder_medium.jpg') }}" data-src="{{ url('images/products/placeholder_medium.jpg') }}" class="lazy" alt="Image">
							@endif
						</div>
						<span class="item_cart"><a href="{{ route('product.show', ['id' => $cart->product_id]) }}" class="product-link">
								<?php echo substr($cart->product_name, 0, 30) . '...' ?></a>
						</span>
					</td>
					<td>
						<strong>
							{{ $discount != 0 ? "Rp." . number_format($newPrice, 0, '.', '.') : "Rp." . number_format($cart->price, 0, '.', '.') }}
						</strong>
						@if ($discount != 0)
						<br>
						<small style="text-decoration:line-through;">
							{{ "Rp ". number_format($cart->price, 0, '.', '.') }}
						</small>
						@endif
					</td>
					<td>
						<form method="post" action="{{ route('cart.update') }}">
							@csrf
							@if(isset($cart))
							@method('PUT')
							@endif
							<input type="hidden" name="product_id" value="{{ isset($cart) ? $cart->product_id : '' }}">
							<div class="numbers-row">
								<input type="text" value="{{ isset($cart->quantity) ? $cart->quantity : '' }}" class="qty2" name="quantity">
								<div class="inc button_inc">+</div>
								<div class="dec button_inc">-</div>
							</div>
							<button style="width: 100%; background : #DD710E; color : white; border: none" type="submit">Refresh</button>
						</form>
					</td>
					<td>
						<strong>Rp<?php echo number_format(($discount != 0 ? $newPrice : $cart->price)  * ($cart->quantity), 0, '', '.'); ?>
							@php
							$total += ($discount != 0 ? $newPrice : $cart->price) * ($cart->quantity);
							@endphp
						</strong>
					</td>
					<td class="options">
						<form method="POST" action="{{ route('cart.delete', ['id'=> $cart->product_id , 'from'=>'cart']) }}">
							{{ csrf_field() }}
							{{ method_field('DELETE') }}
							<button type="submit" style="border:none; font-size:larger;"><i class="ti-trash"></i> <span style="font-size: smaller;"> Delete </span></button>
						</form>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		<!-- /cart_actions -->
		<div class="row add_top_30 flex-sm-row-reverse cart_actions">
			<div class="col-sm-4 text-right">
				<a href="{{ route('cart.index') }}" class="btn_1 gray">Refresh Cart</a>
			</div>
			<div class="col-sm-8">
			</div>
		</div>
	</div>
	<div class="box_cart">
		<div class="container">
			<div class="row justify-content-end">
				<div class="col-xl-4 col-lg-4 col-md-6">
					<a href="#" class="btn_1 full-width cart" id="checkoutBtn">Proceed to Checkout</a>
				</div>
			</div>
		</div>
	</div>
	<!-- /box_cart -->
	@else
	<div class="d-flex justify-content-center">
		<h5 style="color:#dd710e">Nothing here.</h5>
	</div>
	@endif


</main>
<!-- /main -->
@endsection


@section('user_defined_script')
<script type="text/javascript">
	$('#checkoutBtn').click(function(e) {
		e.preventDefault();

		var _selectedProduct = [];
		var _token = $("meta[name='csrf-token']").attr("content");

		$('input[name="cartbox"]').each(function() {
			if ($(this).is(":checked")) {
				var _productData = {
					"product_id": $(this).data('id'),
					"quantity": $(this).data('quantity')
				};

				_selectedProduct.push(_productData);
			}
		});
		// console.log(_selectedProduct);

		$.ajax({
			url: "{{ route('transaction.checkout') }}",
			type: 'POST',
			data: {
				'_token': _token,
				'data': _selectedProduct
			},
			success: function(data) {
				// console.log(data);

				if (data.status == "Success") {

					setTimeout(function() {
						top.location.href = "{{route('transaction.payment')}}";
					}, 500);

				} else if (data.status == "Failed") {
					// console.log("Gagal");
					swal({
						"title": data.error,
						"text": data.text + " Please check again your cart!",
						"icon": "warning",
						"timer": 1200
					});
				}
			}
		});
	})
</script>

@endsection
