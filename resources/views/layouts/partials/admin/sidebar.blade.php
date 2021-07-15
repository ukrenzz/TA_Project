<!-- Side Nav START -->
<div class="side-nav">
	<div class="side-nav-inner">
		<ul class="side-nav-menu scrollable">
			<li class="nav-item">
				<a href="{{ route('admin.dashboard') }}" class="">
					<span class="icon-holder">
						<i class="anticon anticon-dashboard"></i>
					</span>
					<span class="title">Dashboard</span>
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('user.manage') }}" class="">
					<span class="icon-holder">
						<i class="anticon anticon-usergroup-add"></i>
					</span>
					<span class="title">Users</span>
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('product.manage') }}" class="">
					<span class="icon-holder" style="font-size: 0.8rem;">
						<i class="fas fa-tv"></i>
					</span>
					<span class="title">Products</span>
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('category.manage') }}" class="">
					<span class="icon-holder">
						<i class="anticon anticon-appstore"></i>
					</span>
					<span class="title">Categories</span>
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('order.manage') }}" class="">
					<span class="icon-holder" style="font-size: 0.8rem;">
						<i class="fas fa-cart-arrow-down"></i>
					</span>
					<span class="title">Orders</span>
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('feedback.manage') }}" class="">
					<span class="icon-holder" style="font-size: 0.8rem;">
						<i class="far fa-comments"></i>
					</span>
					<span class="title">Feedbacks</span>
				</a>
			</li>
		</ul>
	</div>
</div>
<!-- Side Nav END -->