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
      		<tr>
      			<td>
      				<div class="thumb_cart">
      					<img src="{{ asset('ecommerce/img/products/product_placeholder_square_small.jpg') }}" data-src="{{ asset('ecommerce/img/products/shoes/1.jpg') }}" class="lazy" alt="Image">
      				</div>
      				<span class="item_cart"><a href="{{ route('product.detail') }}" class="product-link">Armor Air x Fear</a></span>
      			</td>
      			<td>
      				<strong>$140.00</strong>
      			</td>
      			<td class="options">
      				<a href="#" class="text-hover-secondary-danger"><i class="ti-trash"></i></a>
              <button type="button" class="btn_1" name="button"><i class="ri-add-line" style="margin-right:-3px;!important; font-size:.7rem;"></i><i class="ri-shopping-cart-line"></i> Buy</button>
      			</td>
      		</tr>
      		<tr>
      			<td>
      				<div class="thumb_cart">
      					<img src="{{ asset('ecommerce/img/products/product_placeholder_square_small.jpg') }}" data-src="{{ asset('ecommerce/img/products/shoes/2.jpg') }}" class="lazy" alt="Image">
      				</div>
      				<span class="item_cart"><a href="{{ route('product.detail') }}" class="product-link">Armor Okwahn II</a></span>
      			</td>
      			<td>
      				<strong>$110.00</strong>
      			</td>
      			<td class="options">
      				<a href="#" class="text-hover-secondary-danger"><i class="ti-trash"></i></a></a>
              <button type="button" class="btn_1" name="button"><i class="ri-add-line" style="margin-right:-3px;!important; font-size:.7rem;"></i><i class="ri-shopping-cart-line"></i> Buy</button>
      			</td>
      		</tr>
      		<tr>
      			<td>
      				<div class="thumb_cart">
      					<img src="{{ asset('ecommerce/img/products/product_placeholder_square_small.jpg') }}" data-src="{{ asset('ecommerce/img/products/shoes/3.jpg') }}" class="lazy" alt="Image">
      				</div>
      				<span class="item_cart"><a href="{{ route('product.detail') }}" class="product-link">Armor Air Wildwood ACG</a></span>
      			</td>
      			<td>
      				<strong>$90.00</strong>
      			</td>
      			<td class="options">
      				<a href="#" class="text-hover-secondary-danger"><i class="ti-trash"></i></a>
              <button type="button" class="btn_1" name="button"><i class="ri-add-line" style="margin-right:-3px;!important; font-size:.7rem;"></i><i class="ri-shopping-cart-line"></i> Buy</button>
      			</td>
      		</tr>
      	</tbody>
      </table>

			<div class="row add_top_30 flex-sm-row-reverse cart_actions">
				<div class="col-sm-4 text-right">
					<button type="button" class="btn_1 gray">Update Wishlist</button>
				</div>
			</div>
			<!-- /cart_actions -->

		</div>
		<!-- /container -->

	</main>
  <!-- /main -->
@endsection


@section('user_defined_script')
@endsection
