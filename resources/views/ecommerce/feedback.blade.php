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
					<h5>Leave a Review for <span style="color : #DD710E">
							{{ isset($data) ? $data->transaction->product_name : '' }}
						</span> </h5>
					@if ($errors->any())
					<div class="row">
						<div style="color : red;">
							<ul>
								@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					</div>
					@endif
					<form id="form-validation" action="{{route('feedback.store')}}" method="post">
						@csrf
						<div class="rating_submit">
							<div class="form-group">
								<label class="d-block">Overall rating</label>
								<span class="rating mb-0">
									<input type="radio" class="rating-input" name="rate" value="5"><label for="5_star" class="rating-star"></label>
									<input type="radio" class="rating-input" name="rate" value="4"><label for="4_star" class="rating-star"></label>
									<input type="radio" class="rating-input" name="rate" value="3"><label for="3_star" class="rating-star"></label>
									<input type="radio" class="rating-input" name="rate" value="2"><label for="2_star" class="rating-star"></label>
									<input type="radio" class="rating-input" name="rate" value="1"><label for="1_star" class="rating-star"></label>
								</span>
							</div>
						</div>
						<!-- /rating_submit -->
						<div class="form-group">
							<label>Your review</label>
							<textarea class="form-control" name="comment" style="height: 180px;" placeholder="Write your review to help others learn about this online business"></textarea>
							<input type="hidden" name="transaction_id" value="{{ isset($data) ? $data->transaction->id : '' }}">
							<input type="hidden" name="user_id" value="{{ isset($data) ? $data->transaction->user_id : '' }}">
							<input type="hidden" name="product_id" value="{{ isset($data) ? $data->transaction->product_id : '' }}">
						</div>
						<div class="form-group text-right">
							<button class="btn_1">Submit Review</button>
						</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</main>
<!-- /main -->
@endsection

@section('user_defined_script')
@endsection

@section('extend_script')
<!-- page js -->
<script src="{{ asset('vendors/jquery-validation/jquery.validate.min.js') }}"></script>

<script type="text/javascript">
	$("#form-validation").validate({
		ignore: ':hidden:not(:checkbox)',
		errorElement: 'label',
		errorClass: 'is-invalid',
		validClass: 'is-valid',
		rules: {
			rate: {
				required: true,
			},
			comment: {
				required: false
			}
		}
	});
</script>
@endsection