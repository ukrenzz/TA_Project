@extends('layouts.admin')

@section('page_title', "Dashboard")

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-md-6">
				<div class="card">
					<div class="card-body">
						<div class="d-flex justify-content-between align-items-center">
							<div>
								<p class="m-b-0 text-muted">Sales</p>
								<h2 class="m-b-0">$23,523</h2>
							</div>
							<span class="badge badge-pill badge-cyan font-size-12">
								<i class="anticon anticon-arrow-up"></i>
								<span class="font-weight-semibold m-l-5">6.71%</span>
							</span>
						</div>
						<div class="m-t-40">
							<div class="d-flex justify-content-between">
								<div class="d-flex align-items-center">
									<span class="badge badge-primary badge-dot m-r-10"></span>
									<span class="text-gray font-weight-semibold font-size-13">Monthly Goal</span>
								</div>
								<span class="text-dark font-weight-semibold font-size-13">70% </span>
							</div>
							<div class="progress progress-sm w-100 m-b-0 m-t-10">
								<div class="progress-bar bg-primary" style="width: 70%"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card">
					<div class="card-body">
						<div class="d-flex justify-content-between align-items-center">
							<div>
								<p class="m-b-0 text-muted">Orders</p>
								<h2 class="m-b-0">1,753</h2>
							</div>
							<span class="badge badge-pill badge-red font-size-12">
								<i class="anticon anticon-arrow-down"></i>
								<span class="font-weight-semibold m-l-5">2.71%</span>
							</span>
						</div>
						<div class="m-t-40">
							<div class="d-flex justify-content-between">
								<div class="d-flex align-items-center">
									<span class="badge badge-warning badge-dot m-r-10"></span>
									<span class="text-gray font-weight-semibold font-size-13">Monthly Goal</span>
								</div>
								<span class="text-dark font-weight-semibold font-size-13">45% </span>
							</div>
							<div class="progress progress-sm w-100 m-b-0 m-t-10">
								<div class="progress-bar bg-warning" style="width: 45%"></div>
							</div>
						</div>
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
								@foreach($data->users as $user)
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