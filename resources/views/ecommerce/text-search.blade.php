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
    @if(($data->products)->isNotEmpty())
    <div class="row">
      <!-- /col -->
      <div class="col-lg-12">
        <!-- /toolbox -->
        <div class="row small-gutters">
          @foreach($data->products as $product)
          <div class="col-6 col-md-3">
            <div class="grid_item">
              <figure>
                {!! $product->discount == 0 | $product->discount == "" ? "" : "<span class='ribbon off'>-" . $product->discount . "%</span>" !!}
                <a href="{{ route('product.show',['id' => $product->id]) }}">
                  @if (count($product->product_images) > 0)
                  <img class="img-fluid lazy" src="{{ url('/images/products/' . $product->product_images[0]->url) }}" data-src="{{ url('/images/products/' . $product->product_images[0]->url) }}" alt="">
                  <img class="img-fluid lazy" src="{{ url('/images/products/' . $product->product_images[0]->url) }}" data-src="{{ url('/images/products/' . $product->product_images[0]->url) }}" alt="">
                  @else
                  <img class="img-fluid lazy" src="{{ asset('ecommerce/img/products/product_placeholder_square_medium.jpg') }}" data-src="{{ asset('ecommerce/img/products/product_placeholder_square_medium.jpg') }}" alt="">
                  @endif
                </a>
              </figure>
              <a href="{{ route('product.show',['id' => $product->id]) }}">
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
          <!-- /col -->
        </div>
        <!-- /row -->
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
      </div>
      <!-- /col -->
    </div>
    @else
    <div class="d-flex justify-content-center">
      <h5 style="color:#dd710e">No Result for "{{$data->term}}", try with another keyword!</h5>
    </div>
    @endif
  </div>
  <!-- /container -->
</main>
<!-- /main -->
@endsection


@section('user_defined_script')
<script src="{{ asset('ecommerce/js/sticky_sidebar.min.js') }}"></script>
<script src="{{ asset('ecommerce/js/specific_listing.js') }}"></script>
@endsection