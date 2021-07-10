@extends('layouts.ecommerce')

@section('title', "Neko eCommerce - Best solution for Accessories")

@section('user_defined_style')
<link href="{{ asset('ecommerce/css/home_1.css') }}" rel="stylesheet">
<link href="{{ asset('ecommerce/css/custom.css') }}" rel="stylesheet">
@endsection


@section('content')
<main>
	<div id="carousel-home">
		<div class="owl-carousel owl-theme">
			<div class="owl-slide cover" style="background-image: url({{ asset('ecommerce/img/slides/slide_home_2.jpg') }});">
				<div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(0, 0, 0, 0.5)">
					<div class="container">
						<div class="row justify-content-center justify-content-md-end">
							<div class="col-lg-6 static">
								<div class="slide-text text-right white">
									<h2 class="owl-slide-animated owl-slide-title">Attack Air<br>Max 720 Sage Low</h2>
									<p class="owl-slide-animated owl-slide-subtitle">
										Limited items available at this price
									</p>
									<div class="owl-slide-animated owl-slide-cta"><a class="btn_1" href="listing-grid-1-full.html" role="button">Shop Now</a></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--/owl-slide-->
			<div class="owl-slide cover" style="background-image: url({{ asset('ecommerce/img/slides/slide_home_1.jpg') }});">
				<div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(0, 0, 0, 0.5)">
					<div class="container">
						<div class="row justify-content-center justify-content-md-start">
							<div class="col-lg-6 static">
								<div class="slide-text white">
									<h2 class="owl-slide-animated owl-slide-title">Attack Air<br>VaporMax Flyknit 3</h2>
									<p class="owl-slide-animated owl-slide-subtitle">
										Limited items available at this price
									</p>
									<div class="owl-slide-animated owl-slide-cta"><a class="btn_1" href="listing-grid-1-full.html" role="button">Shop Now</a></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--/owl-slide-->
			<div class="owl-slide cover" style="background-image: url({{ asset('ecommerce/img/slides/slide_home_3.jpg') }});">
				<div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(255, 255, 255, 0.5)">
					<div class="container">
						<div class="row justify-content-center justify-content-md-start">
							<div class="col-lg-12 static">
								<div class="slide-text text-center black">
									<h2 class="owl-slide-animated owl-slide-title">Attack Air<br>Monarch IV SE</h2>
									<p class="owl-slide-animated owl-slide-subtitle">
										Lightweight cushioning and durable support with a Phylon midsole
									</p>
									<div class="owl-slide-animated owl-slide-cta"><a class="btn_1" href="listing-grid-1-full.html" role="button">Shop Now</a></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--/owl-slide-->
			</div>
		</div>
		<div id="icon_drag_mobile"></div>
	</div>
	<!--/carousel-->

	<ul id="banners_grid" class="clearfix">
		<li>
			<a href="#0" class="img_container">
				<img src="{{ asset('ecommerce/img/banners_cat_placeholder.jpg') }}" data-src="{{ asset('ecommerce/img/banner_1.jpg') }}" alt="" class="lazy">
				<div class="short_info opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.5)">
					<h3>Mouse and Keyboard's Collection</h3>
					<div><span class="btn_1">Shop Now</span></div>
				</div>
			</a>
		</li>
		<li>
			<a href="#0" class="img_container">
				<img src="{{ asset('ecommerce/img/banners_cat_placeholder.jpg') }}" data-src="{{ asset('ecommerce/img/banner_2.jpg') }}" alt="" class="lazy">
				<div class="short_info opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.5)">
					<h3>Laptop and Tablet's Collection</h3>
					<div><span class="btn_1">Shop Now</span></div>
				</div>
			</a>
		</li>
		<li>
			<a href="#0" class="img_container">
				<img src="{{ asset('ecommerce/img/banners_cat_placeholder.jpg') }}" data-src="{{ asset('ecommerce/img/banner_3.jpg') }}" alt="" class="lazy">
				<div class="short_info opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.5)">
					<h3>Camera's Collection</h3>
					<div><span class="btn_1">Shop Now</span></div>
				</div>
			</a>
		</li>
	</ul>
	<!--/banners_grid -->

	<div class="container margin_60_35">
		<div class="main_title">
			<h2>Our Products</h2>
			<span>Products</span>
		</div>
		<div class="row small-gutters">
			@foreach($data->products as $product)
			<div class="col-6 col-md-4 col-xl-3">
				<div class="grid_item">
					<figure>
						<span class="ribbon off">-{{$product->discount}}%</span>
						<a href="{{ route('product.show',['id' => $product->id]) }}">
							<img class="img-fluid lazy" src="{{ asset('ecommerce/img/products/product_placeholder_square_medium.jpg') }}" data-src="{{ asset('ecommerce/img/products/shoes/1.jpg') }}" alt="">
							<img class="img-fluid lazy" src="{{ asset('ecommerce/img/products/product_placeholder_square_medium.jpg') }}" data-src="{{ asset('ecommerce/img/products/shoes/1_b.jpg') }}" alt="">
						</a>
					</figure>
					<div class="rating"><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star"></i></div>
					<a href="{{ route('product.show', ['id' => $product->id]) }}">
						<h3>{{$product->name}}</h3>
					</a>
					<div class="price_box">
						<span class="new_price">
							Rp <?php
									$oldprice = $product->price;
									$disc = $product->discount;
									$new = ($oldprice * (100 - $disc)) / 100;
									echo number_format($new, 0, '', '.');
									?>
						</span><span class="percentage">-{{$product->discount}}</span>
						<span class="old_price">Rp <?php echo number_format(($product->price), 0, '', '.'); ?></span>
					</div>
				</div>
				<!-- /grid_item -->
			</div>
			@endforeach
			<!-- /col -->
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</main>
<!-- /main -->
@endsection


@section('user_defined_script')
<script src="{{ asset('ecommerce/js/carousel-home.min.js') }}"></script>
@endsection
