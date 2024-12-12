<div class="inside_page_Lft">
  <div class="inside_page_Lft_z01">

    <div class="inside_page_Lft_zprofile">
      <figure>
        <img src="{{ (!empty(Auth::user()->photo)) ? url('upload/user_images/'.Auth::user()->photo):url('upload/no_image.jpg') }}" width="144px" alt="">
      </figure>
      <div class="inside_page_Lft_zprofile_name">
        <h4>{{ Auth::user()->name }}</h4>
      </div>
    </div>

    <div class="inside_page_Lft_zul">
      <ul>
        <li><a href="{{ route('customer.profile') }}" class="{{ request()->is('customer/profile') || request()->is('customer/profile/*') ? 'active' : '' }}">
            <i class="icon-person"></i>
            <span>Profile</span>
          </a></li>

        <li><a href="{{ route('customer.wishlist') }}" class="{{ request()->is('customer/wishlist') || request()->is('customer/wishlist/*') ? 'active' : '' }}">
            <i class="icon-fav"></i>
            <span>Wishlist</span>
          </a></li>
        <li><a href="{{ route('customer.order') }}" class="{{ request()->is('customer/order') || request()->is('customer/order/*') ? 'active' : '' }}">
            <i class="icon-check-mark"></i>
            <span>orders</span>
          </a></li>
        <!-- <li><a href="#">
            <i class="icon-settings"></i>
            <span>Settings</span>
          </a></li> -->
      </ul>
    </div>
  </div>
</div>