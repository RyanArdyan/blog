<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-warning sidebar
					collapse">
   <div class="position-sticky pt-3 sidebar-sticky">
      <ul class="nav flex-column">
			<li class="nav-item">
            <a class="nav-link" href="{{ route('beranda.index') }}">
               <span data-feather="home" class="align-text-bottom"></span>
               Beranda
            </a>
         </li>
         <li class="nav-item">
            <a class="nav-link {{ (Request()->is('dashboard*')) ? 'text-white' : '' }}" aria-current="page" href="{{ route('dashboard') }}">
               <span data-feather="bar-chart-2" class="align-text-bottom"></span>
               Dashboard
            </a>
         </li>
			<li class="nav-item">
            <a class="nav-link {{ request()->is('kategori*') ? 'text-white' : '' }}" href="{{ route('kategori.index') }}">
               <span data-feather="box" class="align-text-bottom"></span>
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
            <a class="nav-link {{ request()->is('pengaturan*') ? 'text-white' : '' }}" href="{{ route('pengaturan.index') }}">
               <span data-feather="settings" class="align-text-bottom"></span>
               Pengaturan
            </a>
         </li>
			<li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}">
               <span data-feather="log-out" class="align-text-bottom"></span>
               Logout
            </a>
         </li>
   </div>
</nav>
