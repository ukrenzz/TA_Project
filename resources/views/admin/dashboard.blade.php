@extends('layouts.admin')

@section('page_title', "Dashboard")

@section('content')
	<div class="row">
			<div class="col-md-6 col-lg-3">
					<div class="card">
							<div class="card-body">
									<div class="media align-items-center">
											<div class="avatar avatar-icon avatar-lg avatar-blue">
													<i class="anticon anticon-dollar"></i>
											</div>
											<div class="m-l-15">
													<h2 class="m-b-0">{{ "Rp. " . number_format($data->profits, 0, ',', '.') }}</h2>
													<p class="m-b-0 text-muted">Profit</p>
											</div>
									</div>
							</div>
					</div>
			</div>
			<div class="col-md-6 col-lg-3">
					<div class="card">
							<div class="card-body">
									<div class="media align-items-center">
											<div class="avatar avatar-icon avatar-lg {{ $data->growth > 0 ? 'avatar-cyan' : 'avatar-red' }}">
												<i class="anticon {{ $data->growth > 0 ? 'anticon-rise' : 'anticon-fall' }}"></i>
													{{-- <i class="anticon anticon-line-chart " {{ $data->growth < 0 ? "style='color:red;'" : "" }}></i> --}}
											</div>
											<div class="m-l-15">
													<h2 class="m-b-0">
														@if ($data->growth > 0)
															{{ "+ " . number_format($data->growth, 2, ',', '.') . "%"}}
														@else
															{{ "- " . number_format(($data->growth) * -1, 2, ',', '.') . "%"}}
														@endif
													</h2>
													<p class="m-b-0 text-muted">Growth</p>
											</div>
									</div>
							</div>
					</div>
			</div>
			<div class="col-md-6 col-lg-3">
					<div class="card">
							<div class="card-body">
									<div class="media align-items-center">
											<div class="avatar avatar-icon avatar-lg avatar-gold">
													<i class="anticon anticon-profile"></i>
											</div>
											<div class="m-l-15">
													<h2 class="m-b-0">{{ number_format(($data->order), 0, ',', '.') }}</h2>
													<p class="m-b-0 text-muted">Orders</p>
											</div>
									</div>
							</div>
					</div>
			</div>
			<div class="col-md-6 col-lg-3">
					<div class="card">
							<div class="card-body">
									<div class="media align-items-center">
											<div class="avatar avatar-icon avatar-lg avatar-purple">
													<i class="anticon anticon-user"></i>
											</div>
											<div class="m-l-15">
													<h2 class="m-b-0">{{ number_format(count($data->customers), 0, ',', '.') }}</h2>
													<p class="m-b-0 text-muted">Customers</p>
											</div>
									</div>
							</div>
					</div>
			</div>
	</div>
<div class="row">
	<div class="col-lg-4">
		<div class="card">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-center">
					<h5>Customers</h5>
					<div>
						<a href="{{ route('user.manage') }}" class="btn btn-sm btn-default">View All</a>
					</div>
				</div>
				<div class="m-t-30">
					<div class="table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>ID</th>
									<th>Customer</th>
								</tr>
							</thead>
							<tbody>
								@foreach($data->customers as $user)
								<tr>
									<td>{{$user->id}}</td>
									<td>
										<div class="d-flex align-items-center">
											<div class="d-flex align-items-center">
												<div class="avatar avatar-image" style="height: 30px; min-width: 30px; max-width:30px">
													<img src="{{ asset('admin/images/others/thumb-1.jpg') }}" alt="">
												</div>
												<h6 class="m-l-10 m-b-0">{{$user->name}}</h6>
											</div>
										</div>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-8">
		<div class="card">
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-center">
					<h5>Recent Orders</h5>
					<div>
						<a href="{{ route('order.manage') }}" class="btn btn-sm btn-default">View All</a>
					</div>
				</div>
				<div class="m-t-30">
					<div class="table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>ID</th>
									<th>Customer</th>
									<th>Date</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								@foreach($data->transactions as $transaction)
								<tr>
									<td>{{$transaction->id}}</td>
									<td>
										<div class="d-flex align-items-center">
											<div class="d-flex align-items-center">
												<div class="avatar avatar-image" style="height: 30px; min-width: 30px; max-width:30px">
													<img src="{{ asset('admin/images/others/thumb-1.jpg') }}" alt="">
												</div>
												<h6 class="m-l-10 m-b-0">Jesslyn Yien</h6>
											</div>
										</div>
									</td>
									<td>{{$transaction->created_at}}</td>
									<td>
										<div class="d-flex align-items-center">
											<span>{{$transaction->status}}</span>
										</div>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('extend_script')
<!-- page js -->
<script src="{{asset('vendors/chartjs/Chart.min.js')}}"></script>
<script src="{{asset('admin/js/pages/dashboard-e-commerce.js')}}"></script>
@endsection
