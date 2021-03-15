<header class="version_1">
  <div class="layer"></div><!-- Mobile menu overlay mask -->
  <div class="main_header">
    <div class="container">
      <div class="row small-gutters">
        <div class="col-xl-3 col-lg-3 d-lg-flex align-items-center">
          <div id="logo">
            <a href="{{ route('product.index') }}"><img src="{{ asset('ecommerce/img/logo.svg') }}" alt="" width="100" height="35"></a>
          </div>
        </div>
        <nav class="col-xl-6 col-lg-7">
          <a class="open_close" href="javascript:void(0);">
            <div class="hamburger hamburger--spin">
              <div class="hamburger-box">
                <div class="hamburger-inner"></div>
              </div>
            </div>
          </a>
          <!-- Mobile menu button -->
          <div class="main-menu">
            <div id="header_menu">
              <a href="{{ route('product.index') }}"><img src="{{ asset('ecommerce/img/logo_black.svg') }}" alt="" width="100" height="35"></a>
              <a href="#" class="open_close" id="close_in"><i class="ti-close"></i></a>
            </div>
            <ul>
              <li>
                <a href="{{ route('product.index') }}">Home</a>
              </li>
              <li>
                <a href="{{ route('product.category') }}">All Categories</a>
              </li>
              <li class="submenu">
                <a href="javascript:void(0);" class="show-submenu">Service</a>
                <ul>
                  <li><a href="#">Track your orders</a></li>
                  <li><a href="#">FAQ</a></li>
                </ul>
              </li>
              <li>
                <a href="#">About Us</a>
              </li>
              <li>
                <a href="#">Contact</a>
              </li>
            </ul>
          </div>
          <!--/main-menu -->
        </nav>
        <div class="col-xl-3 col-lg-2 d-lg-flex align-items-center justify-content-end text-right">
          <a class="phone_top" href="tel://9438843343"><strong><span>Need Help?</span>+94 423-23-221</strong></a>
        </div>
      </div>
      <!-- /row -->
    </div>
  </div>
  <!-- /main_header -->

  <div class="main_nav inner Sticky">
    <div class="container">
      <div class="row small-gutters">
        <div class="col-xl-3 col-lg-3 col-md-3">
          <nav class="categories">
            <ul class="clearfix">
              <li><span>
                  <a href="{{ route('product.category') }}">
                    <span class="hamburger hamburger--spin">
                      <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                      </span>
                    </span>
                    Categories
                  </a>
                </span>
                <div id="menu">
                  <ul>
                    <li><span><a href="#0">Collections</a></span>
                      <ul>
                        <li><a href="#">Trending</a></li>
                        <li><a href="#">Life style</a></li>
                        <li><a href="#">Running</a></li>
                        <li><a href="#">Training</a></li>
                        <li><a href="#">View all Collections</a></li>
                      </ul>
                    </li>
                    <li><span><a href="#">Men</a></span>
                      <ul>
                        <li><a href="#">Offers</a></li>
                        <li><a href="#">Shoes</a></li>
                        <li><a href="#">Clothing</a></li>
                        <li><a href="#">Accessories</a></li>
                        <li><a href="#">Equipment</a></li>
                      </ul>
                    </li>
                    <li><span><a href="#">Women</a></span>
                      <ul>
                        <li><a href="#">Best Sellers</a></li>
                        <li><a href="#">Clothing</a></li>
                        <li><a href="#">Accessories</a></li>
                        <li><a href="#">Shoes</a></li>
                      </ul>
                    </li>
                    <li><span><a href="#">Boys</a></span>
                      <ul>
                        <li><a href="#">Easy On Shoes</a></li>
                        <li><a href="#">Clothing</a></li>
                        <li><a href="#">Must Have</a></li>
                        <li><a href="#">All Boys</a></li>
                      </ul>
                    </li>
                    <li><span><a href="#">Girls</a></span>
                      <ul>
                        <li><a href="#">New Releases</a></li>
                        <li><a href="#">Clothing</a></li>
                        <li><a href="#">Sale</a></li>
                        <li><a href="#">Best Sellers</a></li>
                      </ul>
                    </li>
                    <li><span><a href="#">Customize</a></span>
                      <ul>
                        <li><a href="#">For Men</a></li>
                        <li><a href="#">For Women</a></li>
                        <li><a href="#">For Boys</a></li>
                        <li><a href="#">For Girls</a></li>
                      </ul>
                    </li>
                  </ul>
                </div>
              </li>
            </ul>
          </nav>
        </div>
        <div class="col-xl-6 col-lg-7 col-md-6 d-none d-md-block">
          <div class="custom-search-input">
            <input type="text" placeholder="Search over 10.000 products">
            <button type="submit"><i class="header-icon_search_custom"></i></button>
          </div>
        </div>
        <div class="col-xl-3 col-lg-2 col-md-3">
          <ul class="top_tools">
            <li>
              @if (Route::has('login'))
                    @auth
                      <div class="dropdown dropdown-cart">
                        <a href="{{ route('cart') }}" class="cart_bt"><strong>2</strong></a>
                        <div class="dropdown-menu">
                          <ul>
                            <li>
                              <a href="{{ route('product.detail') }}">
                                <figure><img src="{{ asset('ecommerce/img/products/product_placeholder_square_small.jpg') }}" data-src="{{ asset('ecommerce/img/products/shoes/thumb/1.jpg') }}" alt="" width="50" height="50" class="lazy"></figure>
                                <strong><span>1x Armor Air x Fear</span>$90.00</strong>
                              </a>
                              <a href="#0" class="action"><i class="ti-trash"></i></a>
                            </li>
                            <li>
                              <a href="{{ route('product.detail') }}">
                                <figure><img src="{{ asset('ecommerce/img/products/product_placeholder_square_small.jpg') }}" data-src="{{ asset('ecommerce/img/products/shoes/thumb/2.jpg') }}" alt="" width="50" height="50" class="lazy"></figure>
                                <strong><span>1x Armor Okwahn II</span>$110.00</strong>
                              </a>
                              <a href="0" class="action"><i class="ti-trash"></i></a>
                            </li>
                          </ul>
                          <div class="total_drop">
                            <div class="clearfix"><strong>Total</strong><span>$200.00</span></div>
                            <a href="{{ route('cart') }}" class="btn_1 outline">View Cart</a><a href="{{ route('payment') }}" class="btn_1">Checkout</a>
                          </div>
                        </div>
                      </div>
                      <!-- /dropdown-cart-->
                    @endauth
              @endif
            </li>
            <li>
              @if (Route::has('login'))
                @auth
                  <a href="{{ route('wishlist') }}" class="wishlist"><span>Wishlist</span></a>
                @endauth
              @endif
            </li>
            <li>
              <div class="dropdown dropdown-access">
                <a href="{{ route('login') }}" class="access_link"><span>Account</span></a>
                <div class="dropdown-menu">
                  <ul>
                    @if (Route::has('login'))
                      @auth
                        <li>
  												<a href="#"><i class="ti-truck"></i>Track your Order</a>
  											</li>
  											<li>
  												<a href="#"><i class="ti-package"></i>My Orders</a>
  											</li>
  											<li>
  												<a href="{{ route('profile.show') }}"><i class="ti-user"></i>My Profile</a>
  											</li>
                        <li>
                          <!-- Authentication -->
                          <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" class="text-danger" onclick="event.preventDefault();this.closest('form').submit();">
                              <i class="ti-user"></i>Log Out
                            </a>
                          </form>
  											</li>
                      @else
                        <li>
                          <a href="{{ route('login') }}"><i class="ri-login-box-line" style="margin-top:-5px!important"></i>Login</a>
                        </li>
                        <li>
                          <a href="{{ route('register') }}"><i class="ri-user-add-line" style="margin-top:-5px!important"></i>Create new account</a>
                        </li>
                      @endauth
                    @endif
                  </ul>
                </div>
              </div>
              <!-- /dropdown-access-->
            </li>
            <li>
              <a href="javascript:void(0);" class="btn_search_mob"><span>Search</span></a>
            </li>
            <li>
              <a href="#menu" class="btn_cat_mob">
                <div class="hamburger hamburger--spin" id="hamburger">
                  <div class="hamburger-box">
                    <div class="hamburger-inner"></div>
                  </div>
                </div>
                Categories
              </a>
            </li>
          </ul>
        </div>
      </div>
      <!-- /row -->
    </div>
    <div class="search_mob_wp">
      <input type="text" class="form-control" placeholder="Search over 10.000 products">
      <input type="submit" class="btn_1 full-width" value="Search">
    </div>
    <!-- /search_mobile -->
  </div>
  <!-- /main_nav -->
</header>
<!-- /header -->
