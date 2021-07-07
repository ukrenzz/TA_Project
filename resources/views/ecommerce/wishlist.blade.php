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
		@if(($data->wishlists)->isNotEmpty())
		<!-- /page_header -->
		<table class="table table-striped cart-list">
			<thead>
				<tr>
					<th>Product</th>
					<th>Price</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach($data->wishlists as $wishlist)
				<tr>
					<td>
						<div class="thumb_cart">
							<img src="{{ asset('ecommerce/img/products/product_placeholder_square_small.jpg') }}" data-src="{{ asset('ecommerce/img/products/shoes/1.jpg') }}" class="lazy" alt="Image">
						</div>
						<span class="item_cart"><a href="{{ route('product.show',['id' => $wishlist->product_id]) }}" class="product-link">{{$wishlist->product_name}}</a></span>
					</td>
					<td>
						<strong>Rp {{$wishlist->price}}</strong>
					</td>
					<td class="options">
						<form method="POST" action="{{ route('wishlist.delete', ['id'=>   $wishlist->product_id , 'from'=>'wishlist']) }}">
							{{ csrf_field() }}
							{{ method_field('DELETE') }}
							<button type="submit" style="border:none; font-size:larger;"><i class="ti-trash"></i></button>
						</form>
					</td>
					<td>
						<button type="button" class="btn_1" name="button">Buy</button>
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