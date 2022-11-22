<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-warning sidebar
					collapse">
   <div class="position-sticky pt-3 sidebar-sticky">
      <ul class="nav flex-column">
         <li class="nav-item">
            <a class="nav-link {{ (Request()->is('dashboard*')) ? 'text-white' : '' }}" aria-current="page" href="{{ route('dashboard') }}">
               <span data-feather="home" class="align-text-bottom"></span>
               Dashboard
            </a>
         </li>
			<li class="nav-item">
            <a class="nav-link {{ request()->is('kategori*') ? 'text-white' : '' }}" href="{{ route('kategori.index') }}">
               <span data-feather="check-square" class="align-text-bottom"></span>
               Kategori
            </a>
         </li>
			<li class="nav-item">
            <a class="nav-link {{ request()->is('postingan*') ? 'text-white' : '' }}" href="{{ route('postingan.index') }}">
               <span data-feather="edit" class="align-text-bottom"></span>
               Posting
            </a>
         </li>
         <li class="nav-item">
            <a class="nav-link" href="#">
               <span data-feather="user-plus" class="align-text-bottom"></span>
               Jadikan admin
            </a>
         </li>
         <li class="nav-item">
            <a class="nav-link" href="#">
               <span data-feather="shopping-cart" class="align-text-bottom"></span>
               Products
            </a>
         </li>
         <li class="nav-item">
            <a class="nav-link" href="#">
               <span data-feather="users" class="align-text-bottom"></span>
               Customers
            </a>
         </li>
         <li class="nav-item">
            <a class="nav-link" href="#">
               <span data-feather="bar-chart-2" class="align-text-bottom"></span>
               Reports
            </a>
         </li>
         <li class="nav-item">
            <a class="nav-link" href="#">
               <span data-feather="layers" class="align-text-bottom"></span>
               Integrations
            </a>
         </li>
      </ul>

      <h6
         class="sidebar-heading d-flex justify-content-between
							align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
         <span>Saved reports</span>
         <a class="link-secondary" href="#" aria-label="Add a new report">
            <span data-feather="plus-circle" class="align-text-bottom"></span>
         </a>
      </h6>
      <ul class="nav flex-column mb-2">
         <li class="nav-item">
            <a class="nav-link" href="#">
               <span data-feather="file-text" class="align-text-bottom"></span>
               Current month
            </a>
         </li>
         <li class="nav-item">
            <a class="nav-link" href="#">
               <span data-feather="file-text" class="align-text-bottom"></span>
               Last quarter
            </a>
         </li>
         <li class="nav-item">
            <a class="nav-link" href="#">
               <span data-feather="file-text" class="align-text-bottom"></span>
               Social engagement
            </a>
         </li>
         <li class="nav-item">
            <a class="nav-link" href="#">
               <span data-feather="file-text" class="align-text-bottom"></span>
               Year-end sale
            </a>
         </li>
      </ul>
   </div>
</nav>