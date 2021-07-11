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
		@if(($data->carts)->isNotEmpty())
		<!-- /page_header -->
		<table class="table table-striped cart-list">
			<thead>
				<tr>
					<th>Product</th>
					<th>Price</th>
					<th>Quantity</th>
					<th>Subtotal</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php $total = 0  ?>
				@foreach ($data->carts as $cart)
				<tr>
					<td>
						<div class="thumb_cart">
							<img src="{{ asset('ecommerce/img/products/product_placeholder_square_small.jpg') }}" data-src="{{ asset('ecommerce/img/products/shoes/1.jpg') }}" class="lazy" alt="Image">
						</div>
						<span class="item_cart"><a href="{{ route('product.show', ['id' => $cart->product_id]) }}" class="product-link">
								<?php echo substr($cart->product_name, 0, 30) . '...' ?></a>
						</span>
					</td>
					<td>
						<strong>Rp <?php echo number_format(($cart->price), 0, '', '.'); ?> </strong>
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
						<strong>Rp<?php echo number_format((($cart->price) * ($cart->quantity)), 0, '', '.'); ?>
							<?php $total += ($cart->price) * ($cart->quantity) ?>
						</strong>
					</td>
					<td class="options">
						<form method="POST" action="{{ route('cart.delete', ['id'=> $cart->product_id , 'from'=>'cart']) }}">
							{{ csrf_field() }}
							{{ method_field('DELETE') }}
							<button type="submit" style="border:none; font-size:larger;"><i class="ti-trash"></i> <span style="font-size: smaller; color: red;"> Delete </span></button>
						</form>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		<!-- /cart_actions -->
	</div>
	<div class="box_cart">
		<div class="container">
			<div class="row justify-content-end">
				<div class="col-xl-4 col-lg-4 col-md-6">
					<ul>
						<li>
							<span>Total</span> Rp
							<?php echo number_format($total, 0, '', '.'); ?>
						</li>
					</ul>
					<a href="{{route('transaction.payment')}}" class="btn_1 full-width cart">Proceed to Checkout</a>
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
@endsection