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
          <input type="text" class="form-control" id="categories-name-search" placeholder="Search by name">
        </div>
      </div>
    </div>
    <div class="table-responsive">
      <table id="categories-data-table" class="table">
        <thead>
          <tr>
            <th>No</th>
            <th>Reference</th>
            <th>User </th>
            <th>Status</th>
            <th>Disc.</th>
            <th>Shipping Cost</th>
            <th>Payment Method</th>
            <th>Created At</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($data->orders as $order)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $order->ref }}</td>
            <td>{{ $order->username }}</td>
            <td>{{ $order->status }}</td>
            <td>{{ $order->discount }}</td>
            <td>{{ $order->shipping_cost }}</td>
            <td>{{ $order->payment_method}}</td>
            <td>{{ $order->created_at }}</td>
            <td>
              <ul style="list-style-type: none;">
                <li>
                  <form method="post" action="{{ route('order.update') }}">
                    @csrf
                    @if(isset($order))
                    @method('PUT')
                    @endif
                    <input type="hidden" name="transaction_id" value="{{$order->id}}">
                    <input type="hidden" name="status" value="confirmed">
                    <button type="submit" style="color:white;" class="btn btn-sm btn-success"><i class="far fa-check-circle"></i></button>
                  </form>
                </li>
                <li>
                  <form method="post" action="{{ route('order.update') }}">
                    @csrf
                    @if(isset($order))
                    @method('PUT')
                    @endif
                    <input type="hidden" name="transaction_id" value="{{$order->id}}">
                    <input type="hidden" name="status" value="sending">
                    <button type="submit" style="color:white;" class="btn btn-sm btn-warning"><i class="fas fa-truck-moving"></i></button>
                  </form>
                </li>
                <li>
                  <form method="post" action="{{ route('order.update') }}">
                    @csrf
                    @if(isset($order))
                    @method('PUT')
                    @endif
                    <input type="hidden" name="transaction_id" value="{{$order->id}}">
                    <input type="hidden" name="status" value="rejected">
                    <button type="submit" style="color:white;" class="btn btn-sm btn-danger"><i class="far fa-times-circle"></i></button>
                  </form>
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
      var _search = $('#categories-name-search').val();
      var _dataName = data[1]; // use data for the age column
      var _dataDesc = data[2]; // use data for the age column
      console.log([_search, _dataName, _dataDesc]);
      if (_dataName.includes(_search) || _dataDesc.includes(_search)) {
        return true;
      }
      return false;
    }
  );

  $(document).ready(function() {
    var categories_table = $('#categories-data-table').DataTable({
      "columnDefs": [{
        "targets": [1, 3],
        'searchable': true,
        'orderable': true,
      }],
      "columnDefs": [{
        "targets": 2,
        'searchable': true,
        'orderable': false,
      }],
      "columns": [{
          'searchable': false,
          'orderable': true,
        },
        {},
        {
          'searchable': true,
          'orderable': false,
        },
        {},
        {
          'searchable': false,
          'orderable': false,
        }
      ],
      lengthChange: false,
      // searching : false
    });
    $('#categories-data-table_wrapper').children().first().remove();

    $('#categories-name-search').keyup(function() {
      categories_table.search($(this).val()).draw();
    });
  });
</script>
@endsection