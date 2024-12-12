<header class="pG_Hed">
  <nav class="navbar navbar-expand-lg d-flex my-0">
    <div class="hDr_z0 w-100 my-0 h-100">
      <div class="d-flex container cMN_wTh my-0 h-100">
        <a class="navbar-brand my-auto hDr_Logo" href="{{ route('index') }}">
          <img src="/frontend/assets/images/strap_studio_logo.png" alt="Strap Studios" />
        </a>


        <div class="header_wrapz ms-auto me-0">
          @auth
          <div class="header_wrapz_toP">
              
              @if(Auth::user()->type == 'admin')
              <a href="{{ route('admin.schools.index') }}" class="header_wrapz_Each_01">Dashboard</a>
              @elseif(Auth::user()->type == 'customer')
              <div class="header_wrapz_tyP">
                <a href="{{ route('customer.wishlist') }}" class="header_wrapz_Each_02"><i class="icon-fav"></i><span id="wishQty">0</span></a>
                @if(Auth::user()->cn_code == '' || Auth::user()->phone == '' || Auth::user()->address == '')
                <a href="{{ route('customer.profilecart') }}" class="header_wrapz_Each_02"><i class="icon-bag"></i><span id="cartQty">0</span><span>Package</span></a>
                @else
                <a href="{{ route('customer.cart') }}" class="header_wrapz_Each_02"><i class="icon-bag"></i><span id="cartQty">0</span><span>Package</span></a>
                @endif
                <div class="dropdown">
                <button class="header_wrapz_Each_02 dropdown-toggle" type="button" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <i class="icon-chev_down"></i>
                  <span>{{ Auth::user()->name }}</span>
                  <img src="{{ (!empty(Auth::user()->photo)) ? url('upload/user_images/'.Auth::user()->photo):url('upload/no_image.jpg') }}">
                </button>

                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="{{ route('customer.profile') }}">Profile</a></li>
                  <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Sign out</a></li>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
                  </form>                                                     
                </ul>
              </div>

              </div>
              @else
              <a href="{{ route('school.home') }}" class="header_wrapz_Each_01">Dashboard</a>
              @endif
            @if(Auth::user()->type == 'user')
            <div class="header_wrapz_tyP">
              <a href="#" class="header_wrapz_Each_02"><i class="icon-fav"></i><span id="wishQty">0</span></a>
              <a href="#" class="header_wrapz_Each_02"><i
                  class="icon-bag"></i><span>0</span><span>Package</span></a>

              <div class="dropdown">
                <button class="header_wrapz_Each_02 dropdown-toggle" type="button" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <i class="icon-chev_down"></i>
                  <span>{{ Auth::user()->name }}</span>
                  <img src="{{ (!empty(Auth::user()->photo)) ? url('upload/user_images/'.Auth::user()->photo):url('upload/no_image.jpg') }}">
                </button>

                <ul class="dropdown-menu">
                  <!-- <li><a class="dropdown-item" href="#">Action</a></li>
                  <li><a class="dropdown-item" href="#">Another action</a></li> -->
                  <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Sign out</a></li>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
                  </form>                                                     
                </ul>
              </div>

            </div>
            @endif
          </div>
          @else
          <div class="header_wrapz_toP">
            <a href="{{ route('login') }}" class="header_wrapz_Each_01">School Login</a>
            <div class="header_wrapz_tyP">
              
              <a href="{{ route('customer.cart') }}" class="header_wrapz_Each_02"><i class="icon-bag"></i><span id="cartQty">0</span><span>Package</span></a>
              <a href="{{ route('login') }}" class="header_wrapz_Each_02">Login</a>
           
            <a href="{{ route('register') }}" class="header_wrapz_Each_02">Register</a>
            </div>

            

          </div>
          @endif

          <ul class="navbar-nav ms-auto me-0 " id="navbarMenu">
            <li class="nav-item">
              <a class="nav-link {{ request()->is('services') ? 'active' : '' }}" href="{{ route('services') }}">Services</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->is('studiorentals') ? 'active' : '' }}" href="{{ route('studiorentals') }}">Studio Rental</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->is('workshops') ? 'active' : '' }}" href="{{ route('workshops') }}">Workshops</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->is('portfolio') ? 'active' : '' }}" href="{{ route('portfolio') }}">Portfolio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->is('about') ? 'active' : '' }}" href="{{ route('about') }}">About Us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->is('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
            </li>

          </ul>


        </div>



        <button id="mobHam">
          <span></span>
          <span></span>
          <span></span>
        </button>

      </div>


      <div class="lMnu">
        <!-- mobile -->



        <div class="lMnuIns">
          <a class="mbLLogo" href="{{ route('index') }}">
            <img src="/frontend/assets/images/strap_studio_logo.png" alt="Strap Studios" />
          </a>

          <ul class="navbar-nav ms-0 me-0 my-0" id="navbarMenu2">
            <li class="nav-item">
              <a class="nav-link {{ request()->is('services') ? 'active' : '' }}" href="{{ route('services') }}">Services</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->is('studiorentals') ? 'active' : '' }}" href="{{ route('studiorentals') }}">Studio Rentals</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->is('workshops') ? 'active' : '' }}" href="{{ route('workshops') }}">Workshops</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->is('portfolio') ? 'active' : '' }}" href="{{ route('portfolio') }}">Portfolio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->is('about') ? 'active' : '' }}" href="{{ route('about') }}">About Us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->is('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
            </li>


          </ul>
          <div class="d-flex mt-0 mb-auto extra_loginz">
            <a href="{{ route('login') }}" class="header_wrapz_Each_01">School Login</a>
          </div>
        </div>
      </div>

      <div class="aftrHover"></div>
    </div>
  </nav>
</header>