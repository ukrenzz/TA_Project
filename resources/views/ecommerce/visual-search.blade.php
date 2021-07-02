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
          <li>Visual Search</li>
        </ul>
      </div>
      <h1>Search Result</h1>
    </div>
    <div class="row">
      <aside class="col-lg-3" id="sidebar_fixed">
        <div class="filter_col">
          <div class="inner_bt"><a href="#" class="open_filters"><i class="ti-close"></i></a></div>
          <div class="filter_type version_2">
            <h4><a href="#filter_1" data-toggle="collapse" class="opened">Categories</a></h4>
            <div class="collapse show" id="filter_1">
              <ul>
                @foreach($data->categories as $category )
                <li>
                  <label class="container_check">{{$category->name}} <small>12</small>
                    <input type="checkbox">
                    <span class="checkmark"></span>
                  </label>
                </li>
                @endforeach
              </ul>
            </div>
          </div>
          <div class="buttons">
            <a href="#0" class="btn_1">Filter</a> <a href="#0" class="btn_1 gray">Reset</a>
          </div>
        </div>
      </aside>
      <!-- /col -->
      <div class="col-lg-9">
        <!-- /toolbox -->
        <div class="row small-gutters">
          <div class="col-6 col-md-4">
            <div class="grid_item">
              <span class="ribbon off">-30%</span>
              <figure>
                <a href="{{ route('product.show') }}">
                  <img class="img-fluid lazy" src="{{ asset('ecommerce/img/products/product_placeholder_square_medium.jpg') }}" data-src="{{ asset('ecommerce/img/products/shoes/1.jpg') }}" alt="">
                </a>
                <div data-countdown="2019/05/15" class="countdown"></div>
              </figure>
              <a href="{{ route('product.show') }}">
                <h3>Armor Air x Fear</h3>
              </a>
              <div class="price_box">
                <span class="new_price">$48.00</span>
                <span class="old_price">$60.00</span>
              </div>
              <ul>
                <li><a href="#0" class="tooltip-1" data-toggle="tooltip" data-placement="left" title="Add to favorites"><i class="ti-heart"></i><span>Add to favorites</span></a></li>
                <li><a href="#0" class="tooltip-1" data-toggle="tooltip" data-placement="left" title="Add to cart"><i class="ti-shopping-cart"></i><span>Add to cart</span></a></li>
              </ul>
            </div>
            <!-- /grid_item -->
          </div>
          <!-- /col -->

          <div class="col-6 col-md-4">
            <div class="grid_item">
              <span class="ribbon off">-30%</span>
              <figure>
                <a href="{{ route('product.show') }}">
                  <img class="img-fluid lazy" src="{{ asset('ecommerce/img/products/product_placeholder_square_medium.jpg') }}" data-src="{{ asset('ecommerce/img/products/shoes/2.jpg') }}" alt="">
                </a>
                <div data-countdown="2019/05/10" class="countdown"></div>
              </figure>
              <a href="{{ route('product.show') }}">
                <h3>Armor Okwahn II</h3>
              </a>
              <div class="price_box">
                <span class="new_price">$90.00</span>
                <span class="old_price">$170.00</span>
              </div>
              <ul>
                <li><a href="#0" class="tooltip-1" data-toggle="tooltip" data-placement="left" title="Add to favorites"><i class="ti-heart"></i><span>Add to favorites</span></a></li>
                <li><a href="#0" class="tooltip-1" data-toggle="tooltip" data-placement="left" title="Add to cart"><i class="ti-shopping-cart"></i><span>Add to cart</span></a></li>
              </ul>
            </div>
            <!-- /grid_item -->
          </div>
          <!-- /col -->

          <div class="col-6 col-md-4">
            <div class="grid_item">
              <span class="ribbon off">-50%</span>
              <figure>
                <a href="{{ route('product.show') }}">
                  <img class="img-fluid lazy" src="{{ asset('ecommerce/img/products/product_placeholder_square_medium.jpg') }}" data-src="{{ asset('ecommerce/img/products/shoes/3.jpg') }}" alt="">
                </a>
                <div data-countdown="2019/05/21" class="countdown"></div>
              </figure>
              <a href="{{ route('product.show') }}">
                <h3>Armor Air Wildwood ACG</h3>
              </a>
              <div class="price_box">
                <span class="new_price">$75.00</span>
                <span class="old_price">$155.00</span>
              </div>
              <ul>
                <li><a href="#0" class="tooltip-1" data-toggle="tooltip" data-placement="left" title="Add to favorites"><i class="ti-heart"></i><span>Add to favorites</span></a></li>
                <li><a href="#0" class="tooltip-1" data-toggle="tooltip" data-placement="left" title="Add to cart"><i class="ti-shopping-cart"></i><span>Add to cart</span></a></li>
              </ul>
            </div>
            <!-- /grid_item -->
          </div>
          <!-- /col -->

          <div class="col-6 col-md-4">
            <div class="grid_item">
              <span class="ribbon new">New</span>
              <figure>
                <a href="{{ route('product.show') }}">
                  <img class="img-fluid lazy" src="{{ asset('ecommerce/img/products/product_placeholder_square_medium.jpg') }}" data-src="{{ asset('ecommerce/img/products/shoes/4.jpg') }}" alt="">
                </a>
              </figure>
              <a href="{{ route('product.show') }}">
                <h3>Armor ACG React Terra</h3>
              </a>
              <div class="price_box">
                <span class="new_price">$110.00</span>
              </div>
              <ul>
                <li><a href="#0" class="tooltip-1" data-toggle="tooltip" data-placement="left" title="Add to favorites"><i class="ti-heart"></i><span>Add to favorites</span></a></li>
                <li><a href="#0" class="tooltip-1" data-toggle="tooltip" data-placement="left" title="Add to cart"><i class="ti-shopping-cart"></i><span>Add to cart</span></a></li>
              </ul>
            </div>
            <!-- /grid_item -->
          </div>
          <!-- /col -->

          <div class="col-6 col-md-4">
            <div class="grid_item">
              <span class="ribbon new">New</span>
              <figure>
                <a href="{{ route('product.show') }}">
                  <img class="img-fluid lazy" src="{{ asset('ecommerce/img/products/product_placeholder_square_medium.jpg') }}" data-src="{{ asset('ecommerce/img/products/shoes/5.jpg') }}" alt="">
                </a>
              </figure>
              <a href="{{ route('product.show') }}">
                <h3>Armor Air Zoom Alpha</h3>
              </a>
              <div class="price_box">
                <span class="new_price">$140.00</span>
              </div>
              <ul>
                <li><a href="#0" class="tooltip-1" data-toggle="tooltip" data-placement="left" title="Add to favorites"><i class="ti-heart"></i><span>Add to favorites</span></a></li>
                <li><a href="#0" class="tooltip-1" data-toggle="tooltip" data-placement="left" title="Add to cart"><i class="ti-shopping-cart"></i><span>Add to cart</span></a></li>
              </ul>
            </div>
            <!-- /grid_item -->
          </div>
          <!-- /col -->

          <div class="col-6 col-md-4">
            <div class="grid_item">
              <span class="ribbon new">New</span>
              <figure>
                <a href="{{ route('product.show') }}">
                  <img class="img-fluid lazy" src="{{ asset('ecommerce/img/products/product_placeholder_square_medium.jpg') }}" data-src="{{ asset('ecommerce/img/products/shoes/6.jpg') }}" alt="">
                </a>
              </figure>
              <a href="{{ route('product.show') }}">
                <h3>Armor Air Alpha</h3>
              </a>
              <div class="price_box">
                <span class="new_price">$130.00</span>
              </div>
              <ul>
                <li><a href="#0" class="tooltip-1" data-toggle="tooltip" data-placement="left" title="Add to favorites"><i class="ti-heart"></i><span>Add to favorites</span></a></li>
                <li><a href="#0" class="tooltip-1" data-toggle="tooltip" data-placement="left" title="Add to cart"><i class="ti-shopping-cart"></i><span>Add to cart</span></a></li>
              </ul>
            </div>
            <!-- /grid_item -->
          </div>
          <!-- /col -->

          <div class="col-6 col-md-4">
            <div class="grid_item">
              <span class="ribbon hot">Hot</span>
              <figure>
                <a href="{{ route('product.show') }}">
                  <img class="img-fluid lazy" src="{{ asset('ecommerce/img/products/product_placeholder_square_medium.jpg') }}" data-src="{{ asset('ecommerce/img/products/shoes/7.jpg') }}" alt="">
                </a>
              </figure>
              <a href="{{ route('product.show') }}">
                <h3>Armor Air 98</h3>
              </a>
              <div class="price_box">
                <span class="new_price">$115.00</span>
              </div>
              <ul>
                <li><a href="#0" class="tooltip-1" data-toggle="tooltip" data-placement="left" title="Add to favorites"><i class="ti-heart"></i><span>Add to favorites</span></a></li>
                <li><a href="#0" class="tooltip-1" data-toggle="tooltip" data-placement="left" title="Add to cart"><i class="ti-shopping-cart"></i><span>Add to cart</span></a></li>
              </ul>
            </div>
            <!-- /grid_item -->
          </div>
          <!-- /col -->

          <div class="col-6 col-md-4">
            <div class="grid_item">
              <span class="ribbon hot">Hot</span>
              <figure>
                <a href="{{ route('product.show') }}">
                  <img class="img-fluid lazy" src="{{ asset('ecommerce/img/products/product_placeholder_square_medium.jpg') }}" data-src="{{ asset('ecommerce/img/products/shoes/8.jpg') }}" alt="">
                </a>
              </figure>
              <a href="{{ route('product.show') }}">
                <h3>Armor Air 720</h3>
              </a>
              <div class="price_box">
                <span class="new_price">$120.00</span>
              </div>
              <ul>
                <li><a href="#0" class="tooltip-1" data-toggle="tooltip" data-placement="left" title="Add to favorites"><i class="ti-heart"></i><span>Add to favorites</span></a></li>
                <li><a href="#0" class="tooltip-1" data-toggle="tooltip" data-placement="left" title="Add to cart"><i class="ti-shopping-cart"></i><span>Add to cart</span></a></li>
              </ul>
            </div>
            <!-- /grid_item -->
          </div>
          <!-- /col -->

          <div class="col-6 col-md-4">
            <div class="grid_item">
              <span class="ribbon hot">Hot</span>
              <figure>
                <a href="{{ route('product.show') }}">
                  <img class="img-fluid lazy" src="{{ asset('ecommerce/img/products/product_placeholder_square_medium.jpg') }}" data-src="{{ asset('ecommerce/img/products/shoes/9.jpg') }}" alt="">
                </a>
              </figure>
              <a href="{{ route('product.show') }}">
                <h3>Armor 720</h3>
              </a>
              <div class="price_box">
                <span class="new_price">$100.00</span>
              </div>
              <ul>
                <li><a href="#0" class="tooltip-1" data-toggle="tooltip" data-placement="left" title="Add to favorites"><i class="ti-heart"></i><span>Add to favorites</span></a></li>
                <li><a href="#0" class="tooltip-1" data-toggle="tooltip" data-placement="left" title="Add to cart"><i class="ti-shopping-cart"></i><span>Add to cart</span></a></li>
              </ul>
            </div>
            <!-- /grid_item -->
          </div>
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