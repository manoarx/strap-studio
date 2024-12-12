
<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    <!-- <li class="nav-item">
      <a class="nav-link {{ request()->is('admin/dashboard') || request()->is('admin/dashboard/*') ? '' : 'collapsed' }}" href="{{ route('admin.dashboard') }}">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li> -->

    

    <!-- <li class="nav-item">
      <a class="nav-link  {{ request()->is('admin/students') || request()->is('admin/students/*') ? '' : 'collapsed' }}" href="{{ route('admin.students.index') }}">
        <i class="bi bi-newspaper"></i>
        <span>Students</span>
      </a>
    </li> -->


    @if(Auth::user()->can('rolepermission.menu'))
    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#rolepermissions-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-journal-text"></i><span>Role & Permission</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="rolepermissions-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="{{ route('admin.all.permission') }}">
            <i class="bi bi-circle"></i><span>All Permission</span>
          </a>
        </li>
        <li>
          <a href="{{ route('admin.all.roles') }}">
            <i class="bi bi-circle"></i><span>All Roles</span>
          </a>
        </li>
        <!-- <li>
          <a href="{{ route('admin.add.roles.permission') }}">
            <i class="bi bi-circle"></i><span>Role In Permission</span>
          </a>
        </li> -->
        <li>
          <a href="{{ route('admin.all.roles.permission') }}">
            <i class="bi bi-circle"></i><span>All Role In Permission</span>
          </a>
        </li>
      </ul>
    </li>
    @endif

    @if(Auth::user()->can('manageadminuser.menu'))
    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#manageadmin-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-journal-text"></i><span>Manage Admin User</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="manageadmin-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="{{ route('admin.all.admin') }}">
            <i class="bi bi-circle"></i><span>All Admin</span>
          </a>
        </li>
        <li>
          <a href="{{ route('admin.add.admin') }}">
            <i class="bi bi-circle"></i><span>Add Admin</span>
          </a>
        </li>

      </ul>
    </li>
    @endif

    @if(Auth::user()->can('banner.menu'))
    <li class="nav-item">
      <a class="nav-link  {{ request()->is('admin/banners') || request()->is('admin/banners/*') ? '' : 'collapsed' }}" href="{{ route('admin.banners.index') }}">
        <i class="bi bi-newspaper"></i>
        <span>Banners</span>
      </a>
    </li>
    @endif 

    @if(Auth::user()->can('school.menu'))
    <li class="nav-item">
      <a class="nav-link  {{ request()->is('admin/schools') || request()->is('admin/schools/*') ? '' : 'collapsed' }}" href="{{ route('admin.schools.index') }}">
        <i class="bi bi-newspaper"></i>
        <span>Schools</span>
      </a>
    </li>
    @endif

    @if(Auth::user()->can('schoolofferbanner.menu'))
    <li class="nav-item">
      <a class="nav-link  {{ request()->is('admin/offerbanners') || request()->is('admin/offerbanners/*') ? '' : 'collapsed' }}" href="{{ route('admin.offerbanners.index') }}">
        <i class="bi bi-newspaper"></i>
        <span>School Offer Banners</span>
      </a>
    </li>
    @endif

    @if(Auth::user()->can('testimonial.menu'))
    <li class="nav-item">
      <a class="nav-link  {{ request()->is('admin/testimonials') || request()->is('admin/testimonials/*') ? '' : 'collapsed' }}" href="{{ route('admin.testimonials.index') }}">
        <i class="bi bi-newspaper"></i>
        <span>Testimonials</span>
      </a>
    </li>
    @endif

    @if(Auth::user()->can('coupon.menu'))
    <li class="nav-item">
      <a class="nav-link  {{ request()->is('admin/coupons') || request()->is('admin/coupons/*') ? '' : 'collapsed' }}" href="{{ route('admin.coupons.index') }}">
        <i class="bi bi-newspaper"></i>
        <span>Coupons</span>
      </a>
    </li>
    @endif

    @if(Auth::user()->can('client.menu'))
    <li class="nav-item">
      <a class="nav-link  {{ request()->is('admin/clients') || request()->is('admin/clients/*') ? '' : 'collapsed' }}" href="{{ route('admin.clients.index') }}">
        <i class="bi bi-newspaper"></i>
        <span>Clients</span>
      </a>
    </li>
    @endif

    @if(Auth::user()->can('team.menu'))
    <li class="nav-item">
      <a class="nav-link  {{ request()->is('admin/teams') || request()->is('admin/teams/*') ? '' : 'collapsed' }}" href="{{ route('admin.teams.index') }}">
        <i class="bi bi-newspaper"></i>
        <span>Teams</span>
      </a>
    </li>
    @endif

    @if(Auth::user()->can('service.menu'))
    <li class="nav-item">
      <a class="nav-link  {{ request()->is('admin/services') || request()->is('admin/services/*') ? '' : 'collapsed' }}" href="{{ route('admin.services.index') }}">
        <i class="bi bi-newspaper"></i>
        <span>Services</span>
      </a>
    </li>
    @endif

    @if(Auth::user()->can('studiorental.menu'))
    <li class="nav-item">
      <a class="nav-link  {{ request()->is('admin/studiorentals') || request()->is('admin/studiorentals/*') ? '' : 'collapsed' }}" href="{{ route('admin.studiorentals.index') }}">
        <i class="bi bi-newspaper"></i>
        <span>Studio Rentals</span>
      </a>
    </li>
    @endif

    @if(Auth::user()->can('workshop.menu'))
    <li class="nav-item">
      <a class="nav-link  {{ request()->is('admin/workshops') || request()->is('admin/workshops/*') ? '' : 'collapsed' }}" href="{{ route('admin.workshops.index') }}">
        <i class="bi bi-newspaper"></i>
        <span>Workshops</span>
      </a>
    </li>
    @endif

    @if(Auth::user()->can('portfolio.menu'))
    <li class="nav-item">
      <a class="nav-link  {{ request()->is('admin/portfolios') || request()->is('admin/portfolios/*') ? '' : 'collapsed' }}" href="{{ route('admin.portfolios.index') }}">
        <i class="bi bi-newspaper"></i>
        <span>Portfolios</span>
      </a>
    </li>
    @endif

    @if(Auth::user()->can('videography.menu'))
    <li class="nav-item">
      <a class="nav-link  {{ request()->is('admin/videos') || request()->is('admin/videos/*') ? '' : 'collapsed' }}" href="{{ route('admin.videos.index') }}">
        <i class="bi bi-newspaper"></i>
        <span>Videography</span>
      </a>
    </li>
    @endif

    @if(Auth::user()->can('contactform.menu'))
    <li class="nav-item">
      <a class="nav-link  {{ request()->is('admin/contactforms') || request()->is('admin/contactforms/*') ? '' : 'collapsed' }}" href="{{ route('admin.contactforms.index') }}">
        <i class="bi bi-newspaper"></i>
        <span>Contact Forms</span>
      </a>
    </li>
    @endif

    @if(Auth::user()->can('schoolorder.menu'))
    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#school-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-journal-text"></i><span>School Orders</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="school-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="{{ route('admin.schoolordersprint') }}">
            <i class="bi bi-circle"></i><span>Orders Print</span>
          </a>
        </li>
        <li>
          <a href="{{ route('admin.pending.schoolorder') }}">
            <i class="bi bi-circle"></i><span>Orders</span>
          </a>
        </li>
        <!-- <li>
          <a href="{{ route('admin.confirmed.schoolorder') }}">
            <i class="bi bi-circle"></i><span>Confirmed Order</span>
          </a>
        </li>
        <li>
          <a href="{{ route('admin.processing.schoolorder') }}">
            <i class="bi bi-circle"></i><span>Processing Order</span>
          </a>
        </li>
        <li>
          <a href="{{ route('admin.delivered.schoolorder') }}">
            <i class="bi bi-circle"></i><span>Delivered Order</span>
          </a>
        </li> -->
      </ul>
    </li>
    @endif

    @if(Auth::user()->can('order.menu'))
    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-journal-text"></i><span>Orders</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="{{ route('admin.ordersprint') }}">
            <i class="bi bi-circle"></i><span>Orders Print</span>
          </a>
        </li>
        <li>
          <a href="{{ route('admin.pending.order') }}">
            <i class="bi bi-circle"></i><span>Orders</span>
          </a>
        </li>
        <!-- <li>
          <a href="{{ route('admin.confirmed.order') }}">
            <i class="bi bi-circle"></i><span>Confirmed Order</span>
          </a>
        </li>
        <li>
          <a href="{{ route('admin.processing.order') }}">
            <i class="bi bi-circle"></i><span>Processing Order</span>
          </a>
        </li>
        <li>
          <a href="{{ route('admin.delivered.order') }}">
            <i class="bi bi-circle"></i><span>Delivered Order</span>
          </a>
        </li> -->
      </ul>
    </li>
    @endif


    @if(Auth::user()->can('setting.menu'))
    <li class="nav-item">
      <a class="nav-link  {{ request()->is('admin/settings') || request()->is('admin/settings/*') ? '' : 'collapsed' }}" href="{{ route('admin.settings.index') }}">
        <i class="bi bi-newspaper"></i>
        <span>Settings</span>
      </a>
    </li>
    @endif
    

  </ul>

</aside>