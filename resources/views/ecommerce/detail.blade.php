@extends('layouts.ecommerce')

@section('title', "Neko eCommerce - Best solution for Accessories")

@section('user_defined_style')
<link href="{{ asset('ecommerce/css/product_page.css') }}" rel="stylesheet">
<link href="{{ asset('ecommerce/css/custom.css') }}" rel="stylesheet">
@endsection


@section('content')
<main>
  <div class="container margin_30">
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
        <div class="breadcrumbs" style="padding : 10px; margin : 2px;">
          <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">{{$data->product->product_category}}</a></li>
            <li>
              <?php echo substr($data->product->product_name, 0, 30) . '...' ?>
            </li>
          </ul>
        </div>

        <div class="prod_info">
          <h1>{{$data->product->product_name}}</h1>
          <span class="rating">
            @php
              $rating = 0;
              if(count($data->feedbacks) != null || count($data->feedbacks) != 0){
                $rating = $data->rating / count($data->feedbacks);
              }
            @endphp
            @for ($i=1; $i < 6; $i++)
              @if ($i <= $rating)
                <i class="icon-star voted"></i>
              @else
                <i class="icon-star"></i>
              @endif
            @endfor
            <em>{{count($data->feedbacks) . " reviews"}}</em>
          </span>
          <p>
            <small>{{"SKU: " . $data->product->id}}</small>
            <br>
          </p>
        <div class="prod_options">
          <div class="row">
            <label class="col-xl-7 col-lg-7  col-md-6 col-6 pt-0"><strong>Color</strong></label>
            <div class="col-xl-4 col-lg-5 col-md-6 col-6 colors">
              <ul>
                @php
                  $colors = explode(";", $data->product->color);
                @endphp
                @foreach ($colors as $key=>$color)
                  <li><a href="#0" class="color color-shadow {{$key == 0 ? "active" : ""}}" style="background:{{str_replace(' ', '', $color)}}; {{$color == 'white' ? 'color:black;' : ''}}"></a></li>
                @endforeach
              </ul>
            </div>
          </div>
          <div class="row {{ $data->product->stock > 0 ? "" : "text-center mt-4 mb-4" }}">
            @if ($data->product->stock > 0)
              <label class="col-xl-7 col-lg-7  col-md-6 col-6"><strong>Quantity</strong></label>
              <div class="col-xl-4 col-lg-5 col-md-6 col-6">
              <div class="numbers-row">
                <input type="text" value="1" id="quantity" class="qty2" name="quantity" min="1" max="{{ $data->product->stock }}" required>
              </div>
              <div class="col-12 text-center">
                <small class="text-secondary">Available : {{ $data->product->stock }} {{ $data->product->unit }}</small>
              </div>
            </div>
            @else
              <div class="col-12">
                <span class="out-stock w-100 d-block"><b>Sorry</b>, Stock not available!</span>
              </div>
            @endif
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12 col-md-12">
            <div class="price_main">
              <span class="new_price">
                {{ $data->product->discount != null ||  $data->product->discount != 0 ? "Rp." . number_format((int)$data->product->price - ((int)$data->product->price * ((int)$data->product->discount) / 100), 0, '.', '.') : "Rp." . number_format($data->product->price, 0, '.', '.') }}
              </span>
              @if ($data->product->discount != null ||  $data->product->discount != 0)
                <span class="percentage">{{ "-" . $data->product->discount }}</span>
                <span class="old_price ml-2">{{ "Rp." . number_format($data->product->price, 0, '.', '.') }}</span>
              @endif
            </div>
          </div>
        </div>
        @if(Auth::id())
          <div class="row">
            <div class="col-lg-7 col-md-6"></div>
            <div class="col-lg-4 col-md-6 mt-3">
              <div class="btn_add_to_cart">
                <button class="btn_1" id="cartBtn">
                  <span> Add to Cart</span>
                </button>
              </div>
            </div>
          </div>
        @endif
      </div>
      <!-- /prod_info -->
      <div class="row mt-3 mb-5">
        @if (Auth::id())
          <div class="col-12">
            <meta name="csrf-token" content="{{ csrf_token() }}"/>
            <a href="" style="" id="wishlistBtn">
              <i class="mr-2" id="wishlistIcon"></i>
              <span id="wishlistText"></span>
            </a>
          </div>
        @endif
      </div>
      <!-- /product_actions -->
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
                          <td style="vertical-align:middle"><strong>Color</strong></td>
                          <td>
                            @php
                              $colors_data = explode(";", $data->product->color)
                            @endphp
                            @foreach ($colors_data as $color)
                              <span class="color_box mr-2" data-toggle="tooltip" data-placement="bottom" title="{{ ucwords($color) }}" style="background:{{str_replace(' ', '', ucwords($color))}};"></span>
                            @endforeach
                          </td>
                        </tr>
                        <tr>
                          <td><strong>Unit Type</strong></td>
                          <td>{{ ucfirst($data->product->unit) }}</td>
                        </tr>
                        <tr>
                          <td><strong>Status</strong></td>
                          <td>
                              {{ ucfirst($data->product->status) }}
                          </td>
                        </tr>
                        <tr>
                          <td><strong>Manifacturer</strong></td>
                          <td>{{ $data->product->brand }}</td>
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
            @if(($data->feedbacks)->isEmpty())
            <div class="d-flex justify-content-center">
              <h5 style="color:#dd710e">No reviews yet.</h5>
            </div>
            @else
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
            @endif
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

<script type="text/javascript">

  $('.dec').click(function(e) {
    if(parseInt($('#quantity').val()) > 0){

      $('#quantity').val(parseInt($('#quantity').val()));

    } else {
      $('#quantity').val(1);

    }

  })

  $('.inc').click(function(e) {
    if(parseInt($('#quantity').val()) < {{ $data->product->stock > 1 ? (int)$data->product->stock : 0 }}){

      $('#quantity').val(parseInt($('#quantity').val()));

    } else {
      $('#quantity').val({{ $data->product->stock > 1 ? (int)$data->product->stock : 0 }});
    }

  })

  function checkWishlist() {
    $wishlistCheckin = {{ $data->isWishlist ? 1 : 0 }};

    if($wishlistCheckin == 1){
      $('#wishlistText').text("Remove to Wishlist");
      $('#wishlistIcon').addClass("ri-heart-fill color-primary");
    } else {
      $('#wishlistText').text("Add to Wishlist");
      $('#wishlistIcon').addClass("ri-heart-line");
    }
  }

  checkWishlist();

  $('#wishlistBtn').click(function(e) {
    e.preventDefault();

    var product_id = "{{ $data->product->id }}";
    var token = $("meta[name='csrf-token']").attr("content");

    $.ajax({
      url: "{{ route('wishlist.process') }}",
      type: 'POST',
      data: {
        "product_id": product_id,
        "_token": token,
      },
      success: function(data) {
        if(data.action == "store" && data.status == "success"){
          $('#wishlistText').text("Remove to Wishlist");
          $('#wishlistIcon').removeClass("ri-heart-line");
          $('#wishlistIcon').addClass("ri-heart-fill color-primary");
        }
        else if(data.action == "deleted" && data.status == "success"){
          $('#wishlistText').text("Add to Wishlist");
          $('#wishlistIcon').removeClass("ri-heart-fill color-primary");
          $('#wishlistIcon').addClass("ri-heart-line");
        }
        // console.log(data);
      }
    });

  })

  $('#cartBtn').click(function(e) {
    e.preventDefault();
    var product_id  = "{{ $data->product->id }}";
    var quantity    = $('#quantity').val();
    var _token      = $("meta[name='csrf-token']").attr("content");

    console.log(quantity);

    if(parseInt(quantity) > 0){
      console.log("Ok");
      $.ajax({
        url: "{{ route('cart.store') }}",
        type: 'POST',
        data: {
          "product_id": product_id,
          "quantity" : quantity,
          "_token": _token,
        },
        success: function(data) {
          swal({
            title : "Product added to cart!",
            text : "Check cart for payment.",
            icon: "success",
            timer: 1300
          });
        }
      });
    } else {
      console.log("No");
      console.log(quantity);
    }
  })

</script>

@endsection
