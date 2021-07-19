@extends('layouts.admin')

@section('page_title', "Orders")

@section('extend_style')
<!-- page style -->
<link href="{{ asset('vendors/datatables/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('breadcrumb_item')
<a href="{{ route('admin.dashboard')}}" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
<a href="{{ route('order.manage')}}" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Orders</a>
<span class="breadcrumb-item active">Detail</span>
@endsection

@section('content')
  @php
    $order = $data->orders;
  @endphp
<div class="card">
  <div class="card-header">
    <div class="row">
      <div class="col-sm-12 col-md-6">
        <h4 class="card-title">Order Information</h4>
        <meta name="csrf-token" content="{{ csrf_token() }}"/>
      </div>
      <div class="col-sm-12 col-md-6 d-flex justify-content-end">
        {{-- <div class=""> --}}

          <ul class="d-flex align-items-center my-0" style="list-style-type: none;">
            <li class="mx-1  d-inline" data-toggle="tooltip" data-placement="bottom" title="Confirm">
              <button type="button" style="color:white;" class="btn btn-sm btn-success btn-submit" data-id="{{$order->id}}" data-status="confirmed"><i class="far fa-check-circle"></i></button>
            </li>
            <li class="mx-1 d-inline" data-toggle="tooltip" data-placement="bottom" title="Sending">
              <button type="button" style="color:white;" class="btn btn-sm btn-warning btn-submit" data-id="{{$order->id}}" data-status="sending"><i class="fas fa-truck-moving"></i></button>
            </li>
            <li class="mx-1 d-inline" data-toggle="tooltip" data-placement="bottom" title="Reject">
              <button type="button" style="color:white;" class="btn btn-sm btn-danger btn-submit" data-id="{{$order->id}}" data-status="rejected"><i class="far fa-times-circle"></i></button>
            </li>
          </ul>
        {{-- </div> --}}
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="row mb-1">
      <div class="col-sm-12 col-md-6 col-lg-6">
        <div class="row">
          <div class="col col-sm-6 col-md-3">Actual Date</div>
          <div class="col col-sm-6 col-md-3">: <b class="text-primary">{{ $order->created_at }} </b></div>
        </div>
      </div>
      <div class="col-sm-12 col-md-6 col-lg-6">
        <div class="row">
          <div class="col col-sm-6 col-md-3">Transaction ID</div>
          <div class="col col-sm-6 col-md-3">: <b class="text-primary">{{ $order->id }}</b></div>
        </div>
      </div>
    </div>
    <div class="row mb-1">
      <div class="col-sm-12 col-md-6 col-lg-6">
        <div class="row">
          <div class="col col-sm-6 col-md-3">Username</div>
          <div class="col col-sm-6 col-md-9">: {{ ucwords($order->username) }}</div>
        </div>
      </div>
      <div class="col-sm-12 col-md-6 col-lg-6">
        <div class="row">
          <div class="col col-sm-6 col-md-3">Discount</div>
          <div class="col col-sm-6 col-md-9">: {{ $order->discount }}</div>
        </div>
      </div>
    </div>
    <div class="row mb-1">
      <div class="col-sm-12 col-md-6 col-lg-6">
        <div class="row">
          <div class="col col-sm-6 col-md-3">Status</div>
          <div class="col col-sm-6 col-md-9">:
              {{ ucfirst($order->status) }}
          </div>
        </div>
      </div>
      <div class="col-sm-12 col-md-6 col-lg-6">
        <div class="row">
          <div class="col col-sm-6 col-md-3">Total Quantity</div>
          <div class="col col-sm-6 col-md-9">: {{ $data->total->quantity . " Unit" }}</div>
        </div>
      </div>
    </div>
    <div class="row mb-1">
      <div class="col-sm-12 col-md-6 col-lg-6">
        <div class="row">
          <div class="col col-sm-6 col-md-3">Shipping Method</div>
          <div class="col col-sm-6 col-md-9">: {{ strtoupper($order->shipping_method) }}</div>
        </div>
      </div>
      <div class="col-sm-12 col-md-6 col-lg-6">
        <div class="row">
          <div class="col col-sm-6 col-md-3">Shipping Cost</div>
          <div class="col col-sm-6 col-md-9">: {{ "Rp. " . number_format($order->shipping_cost, 0, ',', '.') }}</div>
        </div>
      </div>
    </div>
    <div class="row mb-1">
      <div class="col-sm-12 col-md-6 col-lg-6">
        <div class="row">
          <div class="col col-sm-6 col-md-3">Payment Method</div>
          <div class="col col-sm-6 col-md-9">: {{ strtoupper($order->payment_method) }}</div>
        </div>
      </div>
      <div class="col-sm-12 col-md-6 col-lg-6">
        <div class="row">
          <div class="col col-sm-6 col-md-3">PPN</div>
          <div class="col col-sm-6 col-md-9">: {{ $order->ppn . "%" }}</div>
        </div>
      </div>
    </div>
    <div class="row mb-1">
      <div class="col-sm-12 col-md-6 col-lg-6">
        <div class="row">
          <div class="col col-sm-6 col-md-3">Note</div>
          <div class="col col-sm-6 col-md-9">: {{ $order->note != "" ? ucfirst($order->note) : "-" }}</div>
        </div>
      </div>
      <div class="col-sm-12 col-md-6 col-lg-6">
        <div class="row">
          <div class="col col-sm-6 col-md-3">Total Price</div>
          <div class="col col-sm-6 col-md-9">: <b class="text-primary">{{ "Rp. " . number_format($data->total->price, 0, ',', '.') }}</b></div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <h4 class="card-title">Products</h4>
  </div>
  <div class="card-body">
    @if (session('status'))
    <div class="alert alert-success">
      <div class="d-flex justify-content-start">
        <span class="alert-icon m-r-20 font-size-30">
          <i class="anticon anticon-check-circle"></i>
        </span>
        <div>
          <h5 class="alert-heading">Success</h5>
          <p>{{ session('status') }}</p>
        </div>
      </div>
    </div>
    @endif
    <div class="d-flex row">
      <div class="col-sm-12 col-md-3 col-lg-3">
        <div class="input-affix m-b-10">
          <i class="prefix-icon anticon anticon-search"></i>
          <input type="text" class="form-control" id="product-name-search" placeholder="Search orders">
        </div>
      </div>
    </div>
    <div class="table-responsive">
      <table id="product-data-table" class="table">
        <thead>
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">Name </th>
            <th class="text-center">Brand </th>
            <th class="text-center">Unit </th>
            <th class="text-center">Discount </th>
            <th class="text-center">Quantity</th>
            <th class="text-center">Price</th>
            <th style="white-space: nowrap !important;">Subtotal</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($data->products as $product)
          <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td>
              <a href="{{ route('product.show', $product->id) }}">
                <div class="d-flex align-items-center">
                  @if (count($product->images) > 0)
                    <img class="img-fluid rounded" src="{{ url('images/products/'. $product->images[0]->url) }}" style="max-width: 60px" alt="">
                  @else
                    <img class="img-fluid rounded" src="{{ url('images/products/placeholder_medium.jpg') }}" style="max-width: 60px" alt="">
                  @endif
                    <h6 class="m-b-0 m-l-10">{{ $product->name }}</h6>
                </div>
              </a>
            </td>
            <td>{{ $product->brand }}</td>
            <td class="text-center">{{ $product->unit }}</td>
            <td class="text-center">{{ $product->discount }}</td>
            <td class="text-center">{{ $product->quantity}}</td>
            <td>
              @if ($product->discountPrice != 0)
                {{ "Rp. " . number_format($product->discountPrice, 0, '', '.') }}
                <br>
                <small class="text-muted" style="text-decoration:line-through !important;">
                  {{ "Rp. " . number_format($product->price, 0, '', '.') }}
                </small>
              @else
                {{ "Rp. " . number_format($product->price, 0, '', '.') }}
              @endif

            </td>
            <td>{{ "Rp. " . number_format($product->subtotal, 0, '', '.') }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection

@section('extend_script')
<!-- page js -->
<script src="{{ asset('vendors/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendors/datatables/dataTables.bootstrap.min.js') }}"></script>

<script type="text/javascript">
  // TODO  : need to be edit
  $.fn.dataTable.ext.search.push(
    function(settings, data, dataIndex) {
      var _search = $('#product-name-search').val();
      var _dataName = data[1].toLowerCase(); // use data for the name column
      var _dataBrand = data[2].toLowerCase(); // use data for the brand column
      var _dataQuantity = data[5]; // use data for the quantity column

      console.log(_dataName, _search);
      if (
        _dataName.includes(_search) ||
        _dataBrand.includes(_search) ||
        _dataQuantity.includes(_search)) {
        return true;
      }
      return false;
    }
  );
  $(document).ready(function() {
    var products_table = $('#product-data-table').DataTable({
      "columns": [
        {
          'searchable': false,
          'orderable': true,
        }, // index no
        {
          'searchable': true,
          'orderable': true,
        }, // index name
        {
          'searchable': true,
          'orderable': true,
        }, // index brand
        {
          'searchable': false,
          'orderable': false,
        }, // index unit
        {
          'searchable': false,
          'orderable': false,
        }, // index discount
        {
          'searchable': true,
          'orderable': true,
        }, // index quantity
        {
          'searchable': false,
          'orderable': false,
        }, // index price
        {
          'searchable': false,
          'orderable': false,
        }, // index subtotal
      ],
      lengthChange: false,
      // searching : false
    });
    $('#product-data-table_wrapper').children().first().remove();

    $('#product-name-search').keyup(function() {
      products_table.search($(this).val()).draw();
    });

    $('.btn-submit').click(function() {
      var _id     = $(this).data('id');
      var _status = $(this).data('status');

      swal({
        title: "Are you sure?",
        text: "Once " + _status + ", you will not be able to change this status!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          var _token = $("meta[name='csrf-token']").attr("content");

          $.ajax({
            url: "{{ route('order.update') }}",
            type: 'PUT',
            data: {
              "id"      : _id,
              "status"  : _status,
              "_token"  : _token,
            },
            success: function(data) {
              if(data.status == "success"){
                swal(data.text, {
                  icon: "success",
                  timer : 1200
                });
                setTimeout(function() {
                  top.location.href = '';
                }, 1000);
              }
              else {
                swal(data.text, {
                  icon: "error",
                  timer : 1500
                });
              }
            }
          });
          // swal("Poof! Your imaginary file has been deleted!", {
          //   icon: "success",
          // });
        }
        // else {
        //   swal("Your imaginary file is safe!");
        // }
      });


    });
  });


</script>
@endsection
