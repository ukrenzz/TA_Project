@extends('layouts.ecommerce')

@section('title', "Neko eCommerce - Best solution for Accessories")

@section('user_defined_style')
<link href="{{ asset('ecommerce/css/listing.css') }}" rel="stylesheet">
<link href="{{ asset('ecommerce/css/custom.css') }}" rel="stylesheet">
@endsection


@section('content')
<main>
  <div class="container margin_30">
    <div class="page_header">
      <div class="breadcrumbs">
        <ul>
          <li><a href="#">Home</a></li>
          <li>Text Search</li>
        </ul>
      </div>
      <h1>Search Result</h1>
    </div>
    <div class="row">
      <!-- /col -->
      <div class="col-lg-12">
        <!-- /toolbox -->
        <div class="row small-gutters">
          @foreach($data->products as $product)
          <div class="col-6 col-md-3">
            <div class="grid_item">
              <span class="ribbon off">-{{$product->discount}}%</span>
              <figure>
                <a href="{{ route('product.show', ['id' => $product->id]) }}">
                  <img class="img-fluid lazy" src="{{ asset('ecommerce/img/products/product_placeholder_square_medium.jpg') }}" data-src="{{ asset('ecommerce/img/products/shoes/1.jpg') }}" alt="">
                </a>
              </figure>
              <a href="{{ route('product.show',['id' => $product->id]) }}">
                <h3>{{$product->name}}</h3>
              </a>
              <div class="price_box">
                <span class="new_price">
                  Rp <?php
                      $oldprice = $product->price;
                      $disc = $product->discount;
                      $new = ($oldprice * (100 - $disc)) / 100;
                      echo $new;
                      ?>
                </span><span class="percentage">-{{$product->discount}}</span>
                <span class="old_price">Rp {{$product->price}}</span>
              </div>
            </div>
            <!-- /grid_item -->
          </div>
          @endforeach
          <!-- /col -->
        </div>
        <!-- /row -->
        <div class="pagination__wrapper">
          <ul class="pagination">
            <li><a href="#0" class="prev" title="previous page">&#10094;</a></li>
            <li>
              <a href="#0" class="active">1</a>
            </li>
            <li>
              <a href="#0">2</a>
            </li>
            <li>
              <a href="#0">3</a>
            </li>
            <li>
              <a href="#0">4</a>
            </li>
            <li><a href="#0" class="next" title="next page">&#10095;</a></li>
          </ul>
        </div>
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
<script src="{{ asset('ecommerce/js/sticky_sidebar.min.js') }}"></script>
<script src="{{ asset('ecommerce/js/specific_listing.js') }}"></script>
@endsection