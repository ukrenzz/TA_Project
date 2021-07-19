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
					<li>Order</li>
				</ul>
			</div>
			<h1>Transaction page</h1>
		</div>
		@if(($data->transactions)->isNotEmpty())
		<!-- /page_header -->
		<table class="table table-striped cart-list">
			<thead>
				<tr>
					<th>Product</th>
					<th>Transaction ID</th>
					<th>Price</th>
					<th>Qty.</th>
					<th>Tax</th>
					<th>Disc</th>
					<th>Shipping</th>
					<th>Status</th>
					<th>Total</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach ($data->transactions as $transaction)
				<tr>
					<td>
						<div class="thumb_cart">
							<img src="{{ asset('ecommerce/img/products/product_placeholder_square_small.jpg') }}" data-src="{{ asset('ecommerce/img/products/shoes/1.jpg') }}" class="lazy" alt="Image">
						</div>
						<span class="item_cart"><a href="{{ route('product.show', ['id' => $transaction->product_id]) }}" class="product-link">{{$transaction->product_name}}</a></span>
					</td>
					<td>
						<strong> {{$transaction->id}}</strong>
					</td>
					<td>
						<strong>Rp
							<?php echo number_format($transaction->price, 0, '', '.') ?> </strong>
					</td>
					<td>
						<strong> {{$transaction->quantity}}</strong>
					</td>
					<td>
						<strong> {{$transaction->ppn}}%</strong>
					</td>
					<td>
						<strong> {{$transaction->discount}}%</strong>
					</td>
					<td>
						<strong>({{strtoupper($transaction->payment_method)}}) Rp{{$transaction->shipping_cost}}</strong>
					</td>
					<td>
						<strong>
							<span style=" {{
                  $transaction->status == 'pending' ? "color: #FFC107;" :
                  ( $transaction->status == 'confirmed' ? "color: #28A745;" :
                  ( $transaction->status == 'sending' ? "color: #6C757D;" :
                  ( $transaction->status == 'rejected' ? "color: #DC3545;" : "color: #17A288;")))  }}">
								{{ ucfirst($transaction->status) }}
							</span>
						</strong>
					</td>
					<td>
						<strong>Rp<?php
											$total = $transaction->price * $transaction->quantity;
											$ppn = ($transaction->ppn) * $total / 100;
											$discount = ($transaction->discount) * $total / 100;
											$total += $ppn - $discount + $transaction->shipping_cost;
											echo number_format($total, 0, '', '.');
											?>
						</strong>
					</td>
					<td>
						<a href="{{route('feedback.form', ['id' => $transaction->id, 'product_id'=> $transaction->product_id]) }}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i>Review</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		<!-- /cart_actions -->
		@else
		<div class="d-flex justify-content-center">
			<h5 style="color:#dd710e">You haven't make any transaction yet.</h5>
		</div>
		@endif
	</div>
</main>
<!-- /main -->
@endsection


@section('user_defined_script')
@endsection