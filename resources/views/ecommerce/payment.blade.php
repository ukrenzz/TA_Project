@extends('layouts.ecommerce')

@section('title', "Neko eCommerce - Best solution for Accessories")

@section('user_defined_style')
<link href="{{ asset('ecommerce/css/checkout.css') }}" rel="stylesheet">
<link href="{{ asset('ecommerce/css/checkout-table.css') }}" rel="stylesheet">
{{-- <link href="{{ asset('ecommerce/css/cart.css') }}" rel="stylesheet"> --}}
<link href="{{ asset('ecommerce/css/listing.css') }}" rel="stylesheet">
<link href="{{ asset('ecommerce/css/custom.css') }}" rel="stylesheet">
@endsection


@section('content')
<main class="bg_gray">
  <div class="container margin_30">
    <div class="page_header">
      <h1>Checkout</h1>
    </div>
    <!-- /page_header -->
    <div class="row">
      <div class="col-lg-8 col-md-7 col-sm-12 ">
        {{-- Billing information --}}
        <div class="billing-information-box box_general">
          <h5 class="mb-4">Billing address</h5>
          <div class="billing-information">
            <meta name="csrf-token" content="{{ csrf_token() }}" />
            <h6>{{$data->user->name}} <span class="badge badge-info p-1 ml-2">Primary</span></h6>
            <div>Jl. B Hamid dan No. 8 Kec. Medan Johor</div>
            <div>Kota Medan, Sumatera Utara. 20145</div>
            <button type="button" class="btn_1 gray my-3 p-2" name="button">Change</button>
          </div>
        </div>

        {{-- Item list --}}
        <div class="item-list-checkout-box box_general">
          <div class="item-list-checkout mb-3">
            <table class="table table-striped checkout-list">
              <thead>
                <tr>
                  <th>Product</th>
                  <th>Price</th>
                  <th>Quantity</th>
                  <th>Subtotal</th>
                </tr>
              </thead>
              <tbody>
                @php
                $total = 0;
                $ppn = 0.05;
                $ppnTotal = 0;
                @endphp
                @foreach ($data->products as $product)
                @php
                $discount = $product->discount != null || $product->discount != 0 ? $product->discount : 0;
                $newPrice = ((int)$product->price - ((int)$product->price * ((int)$product->discount) / 100));
                @endphp

                <tr>
                  <td>
                    <div class="thumb_checkout">
                      @if ($product->thumbnail != "" || $product->thumbnail != null)
        								<img src="{{ url('images/products/' . $product->thumbnail) }}" data-src="{{ url('images/products/' . $product->thumbnail) }}" class="lazy" alt="Image">
        							@else
        								<img src="{{ url('images/products/placeholder_medium.jpg') }}" data-src="{{ url('images/products/placeholder_medium.jpg') }}" class="lazy" alt="Image">
        							@endif
                    </div>
                    <span class="item_checkout"><a href="{{ route('product.show',['id' => $product->product_id]) }}" class="product-link">
                        <?php echo substr($product->product_name, 0, 30) . '...' ?>
                      </a></span>
                  </td>
                  <td>
                    <strong>
                      {{ $discount != 0 ? "Rp." . number_format($newPrice, 0, '.', '.') : "Rp." . number_format($product->price, 0, '.', '.') }}
                    </strong>
                    @if ($discount != 0)
                    <br>
                    <small style="text-decoration:line-through;">
                      {{ "Rp ". number_format($product->price, 0, '.', '.') }}
                    </small>
                    @endif
                  </td>
                  <td>
                    <strong>{{$product->quantity}}</strong>
                  </td>
                  <td>
                    <strong>Rp<?php echo number_format(($discount != 0 ? $newPrice : $product->price)  * ($product->quantity), 0, '', '.'); ?>
                      @php
                      $total += ($discount != 0 ? $newPrice : $product->price) * ($product->quantity);
                      @endphp
                    </strong>
                  </td>
                </tr>
                @endforeach
                @php
                $ppnTotal = $total * $ppn;
                @endphp
              </tbody>
            </table>
          </div>
        </div>

        {{-- Shipping method selection --}}
        <div class="shipping-method-box box_general">
          <h5 class="mb-4">Choose a shipping method</h5>
          <div class="shipping-method mb-3">
            {{-- Standard --}}
            <div class="filter_col shipping-method-filter">
              <div class="filter_type version_2">
                <h4><a href="#filter_1" data-toggle="collapse" class="opened">Standard</a></h4>
                <div class="collapse show" id="filter_1">
                  <ul>
                    <li>
                      <label class="container_radio">Neko Flash <small>3-7 Hari | Rp.30.000</small>
                        <input type="radio" name="shipping_method" value="neko flash" checked>
                        <span class="checkmark"></span>
                      </label>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-5 col-sm-12">
        <div class="col-12 box_general">
          <h5 class="pb-4">Note</h5>
          <p class="mb-2 text-justify" style="font-size:0.9em;">Write some notes for us. Tell us your specific address, more feature, or anything.</p>
          <small>This form is optional.</small>
          <textarea name="note" rows="3" class="form-control mb-3" style="resize:none;" placeholder="Your message..."></textarea>
        </div>
        <div class="box_general">
          {{-- Summary --}}
          <div class="summary-box">
            <h5 class="pb-4">Summary</h5>
            <div class="summary mt-3">
              <ul>
                <li class="clearfix"><em><strong>Subtotal</strong></em> <span>Rp
                    <?php echo number_format($total, 0, '', '.');  ?>
                  </span></li>
                <li class="clearfix"><em><strong>Shipping</strong></em> <span>Rp 30.000</span></li>
                <li class="clearfix"><em><strong>PPN (5%)</strong></em> <span>Rp {{number_format($ppnTotal, 0, '', '.')}}</span></li>
              </ul>
              <div class="total clearfix">TOTAL
                <span>Rp
                  <?php echo number_format($total + 30000 + $ppnTotal, 0, '', '.');  ?>
                </span>
              </div>
            </div>

            <h5 class="mt-5">Payment method</h5>
            <div class="payment-method-box">
              <ul class="payment-method-list">
                <li>
                  <label class="container_radio">
                    <span class="payment-item-row">
                      <i class="ri-currency-line mr-1 payment-item-icon"></i>
                      <span class="payment-item-name">Cash on Delivery</span>
                    </span>
                    <input type="radio" name="payments_method" value="cod" checked>
                    <span class="checkmark"></span>
                  </label>
                </li>
                </li>
              </ul>
              <a href="#" class="btn_1 full-width mb-4 mt-3" id="orderBtn">Confirm and Order</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /row -->
  </div>
  <!-- /container -->
</main>
<!-- /main -->


@endsection


@section('user_defined_script')
<script>
  // Other address Panel
  $('#other_addr input').on("change", function() {
    if (this.checked)
      $('#other_addr_c').fadeIn('fast');
    else
      $('#other_addr_c').fadeOut('fast');
  });

  $('#orderBtn').click(function(e) {
    e.preventDefault();

    var _token = $("meta[name='csrf-token']").attr("content");
    var shipping_method = $('input[name="shipping_method"]').val();
    var note = $('input[name="note"]').val();
    var payment_method = $('input[name="payments_method"]').val();

    // console.log($('textarea[name="note"]').val());

    $.ajax({
      url: "{{ route('transaction.store.payment') }}",
      type: 'POST',
      data: {
        "shipping_method": shipping_method,
        "note": note,
        "payment_method": payment_method,
        "_token": _token,
      },
      success: function(data) {
        swal({
          title: "Product added to order!",
          text: "Check cart for payment.",
          icon: "success",
          timer: 1300
        });

        setTimeout(function() {
          top.location.href = "{{route('transaction.success')}}";
        }, 500);
      }
    });
  })
</script>
@endsection
