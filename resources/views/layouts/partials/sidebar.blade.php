<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        {{-- <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
        <span class="brand-text font-weight-light">Gudang</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div> --}}

        <!-- SidebarSearch Form -->
        {{-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> --}}

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link {{-- active --}}">
                        <i class="nav-icon fas fa-desktop"></i>
                        <p>
                            Dashboard
                            {{-- <span class="right badge badge-danger">New</span> --}}
                        </p>
                    </a>
                </li>

                <li class="nav-item {{-- menu-open --}}">
                    <a href="#" class="nav-link {{-- active --}}">
                        <i class="nav-icon fas fa-tags"></i>
                        <p>
                            Barang
                            <i class="right fas fa-angle-left"></i>{{-- start tambah ini jika menambah level menu --}}
                        </p>
                    </a>
                    {{-- start tambah ini jika menambah level menu --}}
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('product') }}" class="nav-link {{-- active --}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Barang</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('product_category') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kategori</p>
                            </a>
                        </li>
                    </ul>
                    {{-- end tambah ini jika menambah level menu --}}
                </li>

                <li class="nav-item">
                    <a href="{{ route('supplier') }}" class="nav-link">
                        <i class="nav-icon fas fa-parachute-box"></i>
                        <p>
                            Supplier
                            {{-- <span class="right badge badge-danger">New</span> --}}
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('customer') }}" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Pelanggan
                            {{-- <span class="right badge badge-danger">New</span> --}}
                        </p>
                    </a>
                </li>

                <li class="nav-item {{-- menu-open --}}">
                    <a href="#" class="nav-link {{-- active --}}">
                        <i class="nav-icon fas fa-shopping-basket"></i>
                        <p>
                            Pembelian
                            <i class="right fas fa-angle-left"></i>{{-- start tambah ini jika menambah level menu --}}
                        </p>
                    </a>
                    {{-- start tambah ini jika menambah level menu --}}
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('purchase') }}" class="nav-link {{-- active --}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pembelian</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Retur</p>
                            </a>
                        </li>
                    </ul>
                    {{-- end tambah ini jika menambah level menu --}}
                </li>

                <li class="nav-item {{-- menu-open --}}">
                    <a href="#" class="nav-link {{-- active --}}">
                        <i class="nav-icon fas fa-cash-register"></i>
                        <p>
                            Penjualan
                            <i class="right fas fa-angle-left"></i>{{-- start tambah ini jika menambah level menu --}}
                        </p>
                    </a>
                    {{-- start tambah ini jika menambah level menu --}}
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link {{-- active --}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Penjualan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Retur</p>
                            </a>
                        </li>
                    </ul>
                    {{-- end tambah ini jika menambah level menu --}}
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-question-circle"></i>
                        <p>
                            Help
                            {{-- <span class="right badge badge-danger">New</span> --}}
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
