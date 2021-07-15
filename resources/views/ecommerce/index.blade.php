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
			<div class="owl-slide cover" style="background-image: url({{ asset('ecommerce/img/slides/XierraMouseCover.png') }});">
				<div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(0, 0, 0, 0.5)">
					<div class="container">
						<div class="row justify-content-center justify-content-md-end">
							<div class="col-lg-6 static">
								<div class="slide-text text-right white">
									<div class="owl-slide-animated owl-slide-cta"><a class="btn_1" href="listing-grid-1-full.html" role="button">Shop Now</a></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--/owl-slide-->
			<div class="owl-slide cover" style="background-image: url({{ asset('ecommerce/img/slides/KeyboardAULA.jpg') }});">
				<div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(0, 0, 0, 0.5)">
					<div class="container">
						<div class="row justify-content-center justify-content-md-start">
							<div class="col-lg-6 static">
								<div class="slide-text white">
									<h2 class="owl-slide-animated owl-slide-title">Keyboard Gaming AULA RGB Display Rainbow</h2>
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
			<div class="owl-slide cover" style="background-image: url({{ asset('ecommerce/img/slides/FujifilmXA3Slide.png') }});">
				<div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(255, 255, 255, 0.5)">
					<div class="container">
						<div class="row justify-content-center justify-content-md-start">
							<div class="col-lg-12 static">
								<div class="slide-text text-center black">
									<h2 class="owl-slide-animated owl-slide-title">Fujifilm XA3</h2>
									<p class="owl-slide-animated owl-slide-subtitle">
									 X Series Mirrorless
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
				<img src="{{ asset('ecommerce/img/XierraMouse.png') }}" data-src="{{ asset('ecommerce/img/XierraMouse.png') }}" alt="" class="lazy">
				<div class="short_info opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.5)">
					<h3>Mouse and Keyboard's Collection</h3>
					<div><span class="btn_1">Shop Now</span></div>
				</div>
			</a>
		</li>
		<li>
			<a href="#0" class="img_container">
				<img src="{{ asset('ecommerce/img/banners_cat_placeholder.jpg') }}" data-src="{{ asset('ecommerce/img/HuaweiMatePad4Inch.png') }}" alt="" class="lazy">
				<div class="short_info opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.5)">
					<h3>Laptop and Tablet's Collection</h3>
					<div><span class="btn_1">Shop Now</span></div>
				</div>
			</a>
		</li>
		<li>
			<a href="#0" class="img_container">
				<img src="{{ asset('ecommerce/img/banners_cat_placeholder.jpg') }}" data-src="{{ asset('ecommerce/img/FujifilmXA3Square.png') }}" alt="" class="lazy">
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
						{!! $product->discount == 0 | $product->discount == "" ? "" : "<span class='ribbon off'>-" . $product->discount . "%</span>" !!}
						<a href="{{ route('product.show',['id' => $product->id]) }}">
							@if (count($product->product_images) > 0)
								<div class="image-thumbnail" style="background: url('{{ url('/images/products/' . $product->product_images[0]->url) }}')"></div>
							@else
								<img class="img-fluid lazy" src="{{ url('/images/products/placeholder_medium.jpg') }}" data-src="{{ url('/images/products/placeholder_medium.jpg') }}" alt="">
							@endif
						</a>
					</figure>
					<div class="rating"><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star"></i></div>
					<a href="{{ route('product.show', ['id' => $product->id]) }}">
						<h3>
							<?php echo substr($product->name, 0, 20) . '...' ?>
						</h3>
					</a>
					<div class="price_box">
						<span class="new_price">
							Rp <?php
									$oldprice = $product->price;
									$disc = $product->discount;
									$new = ($oldprice * (100 - $disc)) / 100;
									echo number_format($new, 0, '', '.');
									?>
						</span>
						{!! $product->discount == 0 | $product->discount == "" ? "" : "<span class='old_price ml-1'>Rp " . number_format(($product->price), 0, '', '.') . "</span>" !!}
					</div>
				</div>
				<!-- /grid_item -->
			</div>
			@endforeach

			<div class="pagination__wrapper">
				<ul class="pagination">
					<li><a href="{{ $data->products->previousPageUrl() }}" class="prev" title="previous page">&#10094;</a></li>
					@for ($i=1; $i < ($data->products->total() / $data->products->perPage()) + 1; $i++)
						<li>
							<a href="{{ $data->products->url($i) }}" class="{{ $data->products->currentPage() == $i ? "active" : "" }}">{{ $i }}</a>
						</li>
					@endfor
					<li><a href="{{ $data->products->nextPageUrl() }}" class="next" title="next page">&#10095;</a></li>
				</ul>
			</div>

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
<script type="text/javascript">
  var img_thumb = $('.image-thumbnail');
  console.log(img_thumb.width())
  // $('.image-thumbnail').css("height", img_thumb.width() + " !important");
  $('.image-thumbnail').height(img_thumb.width());
</script>
@endsection
