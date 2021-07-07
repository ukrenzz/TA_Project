@extends('layouts.ecommerce')

@section('title', "Neko eCommerce - Best solution for Accessories")

@section('user_defined_style')
<link href="{{ asset('ecommerce/css/product_page.css') }}" rel="stylesheet">
<link href="{{ asset('ecommerce/css/custom.css') }}" rel="stylesheet">
@endsection


@section('content')
<main>
  <div class="container margin_30">
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="all">
        <div class="slider pl-3">
          <div class="owl-carousel owl-theme main">
            <div style="background-image: url({{ asset('ecommerce/img/products/shoes/1.jpg') }});" class="item-box">
              <div style="background-image: url({{ asset('ecommerce/img/products/shoes/2.jpg') }});" class="item-box"></div>
              <div style="background-image: url({{ asset('ecommerce/img/products/shoes/3.jpg') }});" class="item-box"></div>
              <div style="background-image: url({{ asset('ecommerce/img/products/shoes/4.jpg') }});" class="item-box"></div>
              <div style="background-image: url({{ asset('ecommerce/img/products/shoes/5.jpg') }});" class="item-box"></div>
              <div style="background-image: url({{ asset('ecommerce/img/products/shoes/6.jpg') }});" class="item-box"></div>
            </div>
            <div class="left nonl"><i class="ti-angle-left"></i></div>
            <div class="right"><i class="ti-angle-right"></i></div>
          </div>
          <div class="slider-two">
            <div class="owl-carousel owl-theme thumbs">
              <div style="background-image: url({{ asset('ecommerce/img/products/shoes/1.jpg') }});" class="item active"></div>
              <div style="background-image: url({{ asset('ecommerce/img/products/shoes/2.jpg') }});" class="item"></div>
              <div style="background-image: url({{ asset('ecommerce/img/products/shoes/3.jpg') }});" class="item"></div>
              <div style="background-image: url({{ asset('ecommerce/img/products/shoes/4.jpg') }});" class="item"></div>
              <div style="background-image: url({{ asset('ecommerce/img/products/shoes/5.jpg') }});" class="item"></div>
              <div style="background-image: url({{ asset('ecommerce/img/products/shoes/6.jpg') }});" class="item"></div>
            </div>
            <div class="left-t nonl-t"></div>
            <div class="right-t"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="breadcrumbs">
        <ul>
          <li><a href="#">Home</a></li>
          <li><a href="#">{{$data->product->product_category}}</a></li>
          <li>{{$data->product->product_name}}</li>
        </ul>
      </div>
      <!-- /page_header -->
      <div class="prod_info">
        <h1>{{$data->product->product_name}}</h1>
        <?php $total_rate = 0;
        $count = 0 ?>
        @foreach($data->feedbacks as $feedback)
        <?php $total_rate += $feedback->rate;
        $count++; ?>
        @endforeach
        <span class="rating"><i class="icon-star voted"></i><em>
            <?php if ($total_rate && $count) echo number_format(floor($total_rate) / $count, 2, '. ', '');
            else echo 0 ?>
          </em></span>
        <p><small>SKU: {{$data->product->id}}</small><br>{{$data->product->description}}</p>
        <div class="prod_options">
          <div class="row">
            <label class="col-xl-5 col-lg-5  col-md-6 col-6 pt-0"><strong>Color</strong></label>
            <label class="col-xl-5 col-lg-5  col-md-6 col-6 pt-0"><strong>{{($data->product->color)}}</strong></label>
          </div>
          <div class="row">
            <label class="col-xl-5 col-lg-5  col-md-6 col-6"><strong>Quantity</strong></label>
            <div class="col-xl-4 col-lg-5 col-md-6 col-6">
              <div class="numbers-row">
                <input type="text" value="1" id="quantity_1" class="qty2" name="quantity_1">
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-5 col-md-6">
            <div class="price_main"><span class="new_price">Rp <?php
                                                                $oldprice = $data->product->price;
                                                                $disc = $data->product->discount;
                                                                $new = ($oldprice * (100 - $disc)) / 100;
                                                                echo $new;
                                                                ?></span><span class="percentage">-{{$data->product->discount}}</span> <span class="old_price">Rp
                {{$data->product->price}}
              </span></div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="btn_add_to_cart"><a href="#0" class="btn_1">Add to Cart</a></div>
          </div>
        </div>
      </div>
      <!-- /prod_info -->
      <div class="product_actions">
        <ul>
          <li>
            @if($data->isWishlist)
            <form method="POST" action="{{ route('wishlist.delete', ['id'=>  $data->product->id, 'from'=>'detail']) }}">
              {{ csrf_field() }}
              {{ method_field('DELETE') }}
              <button class="btn_1" type="submit" style="background-color: white; color: #DD710E; border: 2px solid #DD710E;">
                <span> Remove from Wishlist</span>
              </button>
            </form>
            @else
            <form method="POST" action="{{ route('wishlist.store') }}">
              @csrf
              <input type="hidden" name="product_id" value="{{ isset($data) ? $data->product->id : '' }}">
              <button class="btn_1">
                <i class="ti-heart"></i><span> Add to Wishlist</span>
              </button>
            </form>
            @endif
          </li>
        </ul>
      </div>
      <!-- /product_actions -->
    </div>
  </div>
  <!-- /row -->
  </div>
  <!-- /container -->
  <div class="tabs_product">
    <div class="container">
      <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
          <a id="tab-A" href="#pane-A" class="nav-link active" data-toggle="tab" role="tab">Description</a>
        </li>
        <li class="nav-item">
          <a id="tab-B" href="#pane-B" class="nav-link" data-toggle="tab" role="tab">Reviews</a>
        </li>
      </ul>
    </div>
  </div>
  <!-- /tabs_product -->
  <div class="tab_content_wrapper">
    <div class="container">
      <div class="tab-content" role="tablist">
        <div id="pane-A" class="card tab-pane fade active show" role="tabpanel" aria-labelledby="tab-A">
          <div class="card-header" role="tab" id="heading-A">
            <h5 class="mb-0">
              <a class="collapsed" data-toggle="collapse" href="#collapse-A" aria-expanded="false" aria-controls="collapse-A">
                Description
              </a>
            </h5>
          </div>
          <div id="collapse-A" class="collapse" role="tabpanel" aria-labelledby="heading-A">
            <div class="card-body">
              <div class="row justify-content-between">
                <div class="col-lg-6">
                  <h3>Details</h3>
                  <p>{{$data->product->description}}</p>
                </div>
                <div class="col-lg-5">
                  <h3>Specifications</h3>
                  <div class="table-responsive">
                    <table class="table table-sm table-striped">
                      <tbody>
                        <tr>
                          <td><strong>Color</strong></td>
                          <td>{{$data->product->color}}</td>
                        </tr>
                        <tr>
                          <td><strong>Size</strong></td>
                          <td>150x100x100</td>
                        </tr>
                        <tr>
                          <td><strong>Weight</strong></td>
                          <td>0.6kg</td>
                        </tr>
                        <tr>
                          <td><strong>Manifacturer</strong></td>
                          <td>{{$data->product->brand}}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <!-- /table-responsive -->
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /TAB A -->
        <div id="pane-B" class="card tab-pane fade" role="tabpanel" aria-labelledby="tab-B">
          <div class="card-header" role="tab" id="heading-B">
            <h5 class="mb-0">
              <a class="collapsed" data-toggle="collapse" href="#collapse-B" aria-expanded="false" aria-controls="collapse-B">
                Reviews
              </a>
            </h5>
          </div>
          <div id="collapse-B" class="collapse" role="tabpanel" aria-labelledby="heading-B">
            <div class="card-body">
              <div class="row justify-content-between">
                @foreach($data->feedbacks as $feedback)
                <div class="col-lg-6">
                  <div class="review_content">
                    <div class="clearfix add_bottom_10">
                      <span class="rating"><i class="icon-star"></i><em>{{$feedback->rate}}/5</em></span>
                      <em>{{$feedback->created_at}}</em>
                    </div>
                    <h4>{{$feedback->comment}}</h4>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
            <!-- /card-body -->
          </div>
        </div>
        <!-- /tab B -->
      </div>
      <!-- /tab-content -->
    </div>
    <!-- /container -->
  </div>
  <!-- /tab_content_wrapper -->
  <div class="feat">
    <div class="container">
      <ul>
        <li>
          <div class="box">
            <i class="ti-gift"></i>
            <div class="justify-content-center">
              <h3>Free Shipping</h3>
              <p>For all orders over Rp 499.999,00</p>
            </div>
          </div>
        </li>
        <li>
          <div class="box">
            <i class="ti-wallet"></i>
            <div class="justify-content-center">
              <h3>Secure Payment</h3>
              <p>100% secure payment</p>
            </div>
          </div>
        </li>
        <li>
          <div class="box">
            <i class="ti-headphone-alt"></i>
            <div class="justify-content-center">
              <h3>24/7 Support</h3>
              <p>Online top support</p>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </div>
  <!--/feat-->
</main>
<!-- /main -->
@endsection


@section('user_defined_script')
<script src="{{ asset('ecommerce/js/carousel_with_thumbs.js') }}"></script>
@endsection