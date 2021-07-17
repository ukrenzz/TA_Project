@extends('layouts.admin')

@section('page_title', "Orders")

@section('extend_style')
<!-- page style -->
<link href="{{ asset('vendors/datatables/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('breadcrumb_item')
<a href="{{ route('admin.dashboard')}}" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
<span class="breadcrumb-item active">Orders</span>
@endsection

@section('content')

<div class="card">
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
          <input type="text" class="form-control" id="order-name-search" placeholder="Search orders">
        </div>
      </div>
    </div>
    <div class="table-responsive">
      <table id="order-data-table" class="table">
        <thead>
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">User </th>
            <th class="text-center">Quantity </th>
            <th class="text-center">Total </th>
            <th class="text-center">Status</th>
            <th class="text-center">Payment Method</th>
            <th>Ordered at</th>
            <th style="white-space: nowrap !important;"></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($data->orders as $order)
          <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td class="text-center">{{ $order->id }}</td>
            <td class="text-center">{{ $order->username }}</td>
            <td class="text-center">{{ $order->quantity }}</td>
            <td class="text-center">{{ "Rp. " . number_format($order->total, 0, '', '.') }}</td>
            <td class="text-center">
              <span class=" btn btn-tone {{
                $order->status == 'pending' ? "btn-warning" :
                ( $order->status == 'confirmed' ? "btn-success" :
                ( $order->status == 'sending' ? "btn-secondary" :
                ( $order->status == 'rejected' ? "btn-danger" : "btn-info")))  }}">

                {{ ucfirst($order->status) }}

              </span>
            </td>
            <td class="text-center">{{ $order->payment_method}}</td>
            <td>{{ $order->created_at }}</td>
            <td>
              <meta name="csrf-token" content="{{ csrf_token() }}"/>
              <ul class="d-flex" style="list-style-type: none;">
                <li class="mx-1" data-toggle="tooltip" data-placement="bottom" title="Detail">
                  <a href="#" class="btn btn-sm btn-info"><i class="fas fa-info-circle" ></i></a>
                </li>
                <li class="mx-1" data-toggle="tooltip" data-placement="bottom" title="Confirm">
                  {{-- <form method="post" action="{{ route('order.update') }}">
                    @csrf
                    @if(isset($order))
                    @method('PUT')
                    @endif
                    <input type="hidden" name="transaction_id" value="{{$order->id}}">
                    <input type="hidden" name="status" value="confirmed"> --}}
                    <button type="button" style="color:white;" class="btn btn-sm btn-success btn-submit" data-id="{{$order->id}}" data-status="confirmed"><i class="far fa-check-circle"></i></button>
                  {{-- </form> --}}
                </li>
                <li class="mx-1" data-toggle="tooltip" data-placement="bottom" title="Sending">
                  {{-- <form method="post" action="{{ route('order.update') }}">
                    @csrf
                    @if(isset($order))
                    @method('PUT')
                    @endif
                    <input type="hidden" name="transaction_id" value="{{$order->id}}">
                    <input type="hidden" name="status" value="sending"> --}}
                    <button type="button" style="color:white;" class="btn btn-sm btn-warning btn-submit" data-id="{{$order->id}}" data-status="sending"><i class="fas fa-truck-moving"></i></button>
                  {{-- </form> --}}
                </li>
                <li class="mx-1" data-toggle="tooltip" data-placement="bottom" title="Reject">
                  {{-- <form method="post" action="{{ route('order.update') }}">
                    @csrf
                    @if(isset($order))
                    @method('PUT')
                    @endif
                    <input type="hidden" name="transaction_id" value="{{$order->id}}">
                    <input type="hidden" name="status" value="rejected"> --}}
                    <button type="button" style="color:white;" class="btn btn-sm btn-danger btn-submit" data-id="{{$order->id}}" data-status="rejected"><i class="far fa-times-circle"></i></button>
                  {{-- </form> --}}
                </li>
              </ul>
            </td>
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
      var _search = $('#order-name-search').val();
      var _dataId = data[0]; // use data for the id column
      var _dataUsername = data[1]; // use data for the username column
      var _dataQuantity = data[2]; // use data for the quantity column
      var _dataTotal = data[3]; // use data for the total column
      var _dataStatus = data[4]; // use data for the status column

      if (
        _dataId.includes(_search) ||
        _dataUsername.includes(_search) ||
        _dataQuantity.includes(_search) ||
        _dataTotal.includes(_search) ||
        _dataStatus.includes(_search)) {
        return true;
      }
      return false;
    }
  );

  $(document).ready(function() {
    var orders_table = $('#order-data-table').DataTable({
      "columns": [
        {
          'searchable': true,
          'orderable': true,
        }, // index id
        {
          'searchable': true,
          'orderable': true,
        }, // index username
        {
          'searchable': true,
          'orderable': true,
        }, // index quantity
        {
          'searchable': true,
          'orderable': false,
        }, // index total
        {
          'searchable': true,
          'orderable': true,
        }, // index status
        {
          'searchable': false,
          'orderable': false,
        }, // index payment method
        {
          'searchable': false,
          'orderable': false,
        }, // index ordered at
        {
          'searchable': false,
          'orderable': false,
        }, // index action
      ],
      lengthChange: false,
      // searching : false
    });
    $('#order-data-table_wrapper').children().first().remove();

    $('#order-name-search').keyup(function() {
      orders_table.search($(this).val()).draw();
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
