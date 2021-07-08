@extends('layouts.ecommerce')

@section('title', "Neko eCommerce - Best solution for Accessories")

@section('user_defined_style')
<link href="{{ asset('ecommerce/css/checkout.css') }}" rel="stylesheet">
<link href="{{ asset('ecommerce/css/cart.css') }}" rel="stylesheet">
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
            <h6>{{$data->user->name}} <span class="badge badge-info p-1 ml-2">Primary</span></h6>
            <div>Jl. B Hamid dan No. 8 Kec. Medan Johor</div>
            <div>Kota Medan, Sumatera Utara. 20145</div>
            <button type="button" class="btn_1 gray my-3 p-2" name="button">Change</button>
          </div>
        </div>

        {{-- Item list --}}
        <div class="item-list-checkout-box box_general">
          <div class="item-list-checkout mb-3">
            <table class="table table-striped cart-list">
              <thead>
                <tr>
                  <th>Product</th>
                  <th>Price</th>
                  <th>Quantity</th>
                  <th>Subtotal</th>
                </tr>
              </thead>
              <tbody>
                <?php $total = 0 ?>
                @foreach ($data->carts as $cart)
                <tr>
                  <td>
                    <div class="thumb_cart">
                      <img src="{{ asset('ecommerce/img/products/product_placeholder_square_small.jpg') }}" data-src="{{ asset('ecommerce/img/products/shoes/1.jpg') }}" class="lazy" alt="Image">
                    </div>
                    <span class="item_cart"><a href="" class="product-link">{{$cart->product_name}}</a></span>
                  </td>
                  <td>
                    <strong>Rp<?php echo number_format(($cart->price), 0, '', '.'); ?></strong>
                  </td>
                  <td>
                    <strong>{{$cart->quantity}}</strong>
                  </td>
                  <td>
                    <strong>Rp<?php
                              $total += ($cart->price) * ($cart->quantity);
                              echo number_format((($cart->price) * ($cart->quantity)), 0, '', '.'); ?>
                    </strong>
                  </td>
                </tr>
                @endforeach
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
                        <input type="radio" name="shipping_method" checked>
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
              </ul>
              <div class="total clearfix">TOTAL <span>Rp
                  <?php echo number_format($total + 30000, 0, '', '.');  ?>
                </span></div>
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
                    <input type="radio" name="payments_method" checked>
                    <span class="checkmark"></span>
                  </label>
                </li>
                </li>
              </ul>
              <a href="{{route('transaction.success')}}" class="btn_1 full-width mb-4 mt-3">Confirm and Pay</a>
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

<!-- Modal Payments Method-->
<div class="modal fade" id="payments_method" tabindex="-1" role="dialog" aria-labelledby="payments_method_title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="payments_method_title">Payments Methods</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Lorem ipsum dolor sit amet, oratio possim ius cu. Labore prompta nominavi sea ei. Sea no animal saperet gloriatur, ius iusto ullamcorper ad. Qui ignota reformidans ei, vix in elit conceptam adipiscing, quaestio repudiandae delicatissimi vis ei. Fabulas accusamus no has.</p>
        <p>Et nam vidit zril, pri elaboraret suscipiantur ut. Duo mucius gloriatur at, in vis integre labitur dolores, mei omnis utinam labitur id. An eum prodesset appellantur. Ut alia nemore mei, at velit veniam vix, nonumy propriae conclusionemque ea cum.</p>
      </div>
    </div>
  </div>
</div>
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
</script>
@endsection