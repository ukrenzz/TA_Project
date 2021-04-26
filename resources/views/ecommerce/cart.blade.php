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
      		<tr>
      			<td>
      				<div class="thumb_cart">
      					<img src="{{ asset('ecommerce/img/products/product_placeholder_square_small.jpg') }}" data-src="{{ asset('ecommerce/img/products/shoes/1.jpg') }}" class="lazy" alt="Image">
      				</div>
      				<span class="item_cart"><a href="{{ route('product.show') }}" class="product-link">Armor Air x Fear</a></span>
      			</td>
      			<td>
      				<strong>$140.00</strong>
      			</td>
      			<td>
      				<div class="numbers-row">
      					<input type="text" value="1" id="quantity_1" class="qty2" name="quantity_1">
      				<div class="inc button_inc">+</div><div class="dec button_inc">-</div></div>
      			</td>
      			<td>
      				<strong>$140.00</strong>
      			</td>
      			<td class="options">
      				<a href="#" class="text-hover-secondary-danger"><i class="ti-trash"></i></a>
      			</td>
      		</tr>
      		<tr>
      			<td>
      				<div class="thumb_cart">
      					<img src="{{ asset('ecommerce/img/products/product_placeholder_square_small.jpg') }}" data-src="{{ asset('ecommerce/img/products/shoes/2.jpg') }}" class="lazy" alt="Image">
      				</div>
      				<span class="item_cart"><a href="{{ route('product.show') }}" class="product-link">Armor Okwahn II</a></span>
      			</td>
      			<td>
      				<strong>$110.00</strong>
      			</td>
      			<td>
      				<div class="numbers-row">
      					<input type="text" value="1" id="quantity_2" class="qty2" name="quantity_2">
      				<div class="inc button_inc">+</div><div class="dec button_inc">-</div></div>
      			</td>
      			<td>
      				<strong>$110.00</strong>
      			</td>
      			<td class="options">
      				<a href="#" class="text-hover-secondary-danger"><i class="ti-trash"></i></a>
      			</td>
      		</tr>
      		<tr>
      			<td>
      				<div class="thumb_cart">
      					<img src="{{ asset('ecommerce/img/products/product_placeholder_square_small.jpg') }}" data-src="{{ asset('ecommerce/img/products/shoes/3.jpg') }}" class="lazy" alt="Image">
      				</div>
      				<span class="item_cart"><a href="{{ route('product.show') }}" class="product-link">Armor Air Wildwood ACG</a></span>
      			</td>
      			<td>
      				<strong>$90.00</strong>
      			</td>

      			<td>
      				<div class="numbers-row">
      					<input type="text" value="1" id="quantity_3" class="qty2" name="quantity_3">
      				<div class="inc button_inc">+</div><div class="dec button_inc">-</div></div>
      			</td>
      			<td>
      				<strong>$90.00</strong>
      			</td>
      			<td class="options">
      				<a href="#" class="text-hover-secondary-danger"><i class="ti-trash"></i></a>
      			</td>
      		</tr>
      	</tbody>
      </table>

			<div class="row add_top_30 flex-sm-row-reverse cart_actions">
				<div class="col-sm-4 text-right">
					<button type="button" class="btn_1 gray">Update Cart</button>
				</div>
			</div>
			<!-- /cart_actions -->

		</div>
		<!-- /container -->

		<div class="box_cart">
			<div class="container">
  			<div class="row justify-content-end">
  				<div class="col-xl-4 col-lg-4 col-md-6">
      			<ul>
      				<li>
      					<span>Subtotal</span> $240.00
      				</li>
      				<li>
      					<span>Shipping</span> $7.00
      				</li>
      				<li>
      					<span>Total</span> $247.00
      				</li>
      			</ul>
            <a href="cart-2.html" class="btn_1 full-width cart">Proceed to Checkout</a>
					</div>
				</div>
			</div>
		</div>
		<!-- /box_cart -->

	</main>
  <!-- /main -->
@endsection


@section('user_defined_script')
@endsection
