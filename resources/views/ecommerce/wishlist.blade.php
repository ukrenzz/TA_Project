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
					<li>Wishlist</li>
				</ul>
			</div>
			<h1>Your favorites</h1>
		</div>
		@if (session('status'))
		<div style="margin-top: 5px; background : #cdfbcd; padding : 10px; margin-bottom: 5px">
			<p style="color: #2fec00; margin:0">{{ session('status') }}</p>
		</div>
		@endif
		@if(($data->wishlists) != null)
		<!-- /page_header -->
		<table class="table table-striped cart-list">
			<thead>
				<tr>
					<th>Product</th>
					<th>Price</th>
				</tr>
			</thead>
			<tbody>
				@foreach($data->wishlists as $wishlist)
				<tr>
					<td>
						<div class="thumb_cart">
							@if ($wishlist->thumbnail != "" || $wishlist->thumbnail != null)
								<img src="{{ url('images/products/' . $wishlist->thumbnail) }}" data-src="{{ url('images/products/' . $wishlist->thumbnail) }}" class="lazy" alt="Image">
							@else
								<img src="{{ url('images/products/placeholder_medium.jpg') }}" data-src="{{ url('images/products/placeholder_medium.jpg') }}" class="lazy" alt="Image">
							@endif
						</div>
						<span class="item_cart"><a href="{{ route('product.show',['id' => $wishlist->product_id]) }}" class="product-link">
								<?php echo substr($wishlist->product_name, 0, 60) . '...' ?>
							</a></span>
					</td>
					<td>
						<strong>Rp
							<?php echo number_format(($wishlist->price), 0, '', '.'); ?>
						</strong>
					</td>
					<td class="options">
						<form method="POST" action="{{ route('wishlist.delete', ['id'=>   $wishlist->product_id , 'from'=>'wishlist']) }}">
							{{ csrf_field() }}
							{{ method_field('DELETE') }}
							<button type="submit" style="border:none; font-size:larger;"><i class="ti-trash"></i> <span style="font-size: smaller;"> Delete </span></button>
						</form>
					</td>
					<td class="options">
						<form method="POST" action="{{ route('cart.store') }}">
							@csrf
							<input type="hidden" name="product_id" value="{{ isset($data) ? $wishlist->product_id : '' }}">
							<input type="hidden" name="quantity" value="1">
							<button type="submit" class="btn_1">
								<span style="white-space: nowrap;"> Add to Cart</span>
							</button>
						</form>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		@else
		<div class="d-flex justify-content-center">
			<h5 style="color:#dd710e">Browse for some products and Add to your wishlist!</h5>
		</div>
		@endif
	</div>
	<!-- /container -->

</main>
<!-- /main -->
@endsection


@section('user_defined_script')
@endsection
