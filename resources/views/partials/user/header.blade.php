<header class="pG_Hed">
      <nav class="navbar navbar-expand-lg d-flex my-0">
        <div class="hDr_z0 w-100 my-0 h-100">
          <div class="d-flex container cMN_wTh my-0 h-100">
            <div class="dash_logz">
              <div class="dash_logz_l1">
                <figure>
                  <img src="{{ (!empty($userData->school->image)) ? asset($userData->school->image) : url('upload/no_image.jpg') }}">
                </figure>
                <div class="dash_logz_l_txt">
                  <a href="{{ route('school.home') }}"><h4>{{ $userData->school->school_name ?? '' }} SCHOOL</h4></a>
                  <a href="{{ route('school.home') }}" class="dash_logz_l_txtLink">Photo Outlet</a>
                </div>
              </div>
              <div class="dash_logz_l2">
                <a class="navbar-brand my-auto dash_logz_lLogo" href="{{ route('index') }}">
                  <img src="/frontend/assets/images/strap_studio_logo.png" alt="Strap Studios" />
                </a>
              </div>



            </div>



            <div class="head_dashboard ms-auto me-0 my-auto">

              <div class="dropdown">
                <a class="head_Drop dropdown-toggle head_Drop_item"  href="{{ route('school.home') }}">
                  <i class="icon-ion_card"></i>
                  <span class="cart_name">Dashboard</span>
                </a>
              </div>
              <div class="dropdown">
                @if(Auth::user()->cn_code == '' || Auth::user()->phone == '' || Auth::user()->address == '')
                <a class="head_Drop dropdown-toggle head_Drop_item"  href="{{ route('school.profilecart') }}">
                @else
                <a class="head_Drop dropdown-toggle head_Drop_item"  href="{{ route('school.cart') }}">
                @endif
                  <i class="icon-bag"></i>
                  <span class="cart_name">Cart</span>
                  <span class="items_name"><span id="cartQty">0</span> <span class="cartItem_itm"> Items</span> </span>
                  <i class="icon-arrow_right"></i>
                </a>

                <!-- <button class="head_Drop dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="icon-bag"></i>
                  <span class="cart_name">Cart</span>
                  <span class="items_name"><span id="cartQty">0</span> Items</span>
                  <i class="icon-arrow_down"></i>
                </button>
                
                 -->
              <!--   <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="{{ route('school.cart') }}">View Cart</a></li> -->

                  <!-- <li><a class="dropdown-item" href="#">Another action</a></li>
                  <li><a class="dropdown-item" href="#">Something else here</a></li> -->
               
                  <!--  </ul> -->
              </div>

              <div class="dropdown ">
                <button class="head_Drop head_Drop_b dropdown-toggle" type="button" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <i class="icon-chev_down"></i>
                  <span class="usR_name">{{ Auth::user()->name }}</span>
                </button>

                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="sigNouT">Sign out</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
                </form>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="{{ route('school.profile') }}">Profile</a></li>
                  <li><a class="dropdown-item" href="{{ route('school.home') }}">Dashboard</a></li>
                  <li><a class="dropdown-item" href="{{ route('school.orders') }}">Orders</a></li>
                  <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#passwordModal">Change Password</a></li>
                  <li><a class="dropdown-item onMobile_view" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign out</a></li>
                  <!-- <li><a class="dropdown-item" href="#">Something else here</a></li> -->
                </ul>
              </div>



            </div>




          </div>



        </div>
      </nav>
    </header>