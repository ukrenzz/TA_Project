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
					<li>Review</li>
				</ul>
			</div>
			<h1>Review page</h1>
		</div>

		<div class="row justify-content-center">
			<div class="col-lg-8">
				<div class="write_review">
					<h1>Leave a Review</h1>
					<div class="rating_submit">
						<div class="form-group">
							<label class="d-block">Overall rating</label>
							<span class="rating mb-0">
								<input type="radio" class="rating-input" id="5_star" name="rating-input" value="5 Stars"><label for="5_star" class="rating-star"></label>
								<input type="radio" class="rating-input" id="4_star" name="rating-input" value="4 Stars"><label for="4_star" class="rating-star"></label>
								<input type="radio" class="rating-input" id="3_star" name="rating-input" value="3 Stars"><label for="3_star" class="rating-star"></label>
								<input type="radio" class="rating-input" id="2_star" name="rating-input" value="2 Stars"><label for="2_star" class="rating-star"></label>
								<input type="radio" class="rating-input" id="1_star" name="rating-input" value="1 Star"><label for="1_star" class="rating-star"></label>
							</span>
						</div>
					</div>
					<!-- /rating_submit -->
					<div class="form-group">
						<label>Title of your review</label>
						<input class="form-control" type="text" placeholder="If you could say it in one sentence, what would you say?">
					</div>
					<div class="form-group">
						<label>Your review</label>
						<textarea class="form-control" style="height: 180px;" placeholder="Write your review to help others learn about this online business"></textarea>
					</div>
					<a href="confirm.html" class="btn_1">Submit review</a>
				</div>
			</div>
		</div>
	</div>
</main>
<!-- /main -->
@endsection


@section('user_defined_script')
@endsection