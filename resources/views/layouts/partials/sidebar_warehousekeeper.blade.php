<header class="main-nav">
    <div class="sidebar-user text-center"><a class="setting-primary" href="{{ url('/profiles') }}"><i
                data-feather="settings"></i></a>
        @if (Auth::user()->employeeBy->photo == 'blank')
            <img class="img-90 rounded-circle" src="{{ asset('images/blank.png') }}" alt="">
        @else
            <img class="img-90 rounded-circle" src="{{ asset('images/employees/' . Auth::user()->employeeBy->photo) }}"
                alt=""
                style="width:100%;height:90px;object-fit:cover;object-position: 50% 50%;image-rendering:smooth;filter:blur(0.4px)">
        @endif
        <div class="badge-bottom"></div><a href="user-profile.html">
            <h6 class="mt-3 f-14 f-w-600">{{ Auth::user()->name }}</h6>
        </a>
        <p class="mb-0 font-roboto text-capitalize">
            {{ Auth::user()->roleBy->name }} <br> {{ Auth::user()->jobBy->job_name }} at
            {{ Auth::user()->warehouseBy->warehouses }}
        </p>

    </div>
    <nav>
        <div class="main-navbar">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="mainnav">
                <ul class="nav-menu custom-scrollbar">
                    <li class="back-btn">
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                                aria-hidden="true"></i>
                        </div>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6>Starter </h6>
                        </div>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav {{ request()->is('home') ? 'active' : '' }}"
                            href="{{ url('/home') }}"><i data-feather="home"></i><span>Dashboard</span></a>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6>Transaction Features </h6>
                        </div>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav {{ request()->is('purchase_orders/create') ? 'active' : '' }}"
                            href="{{ url('/purchase_orders/create') }}"><i data-feather="shopping-bag"></i><span>Create
                                Purchase Order
                            </span></a>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav {{ request()->is('purchase_orders/receiving') ? 'active' : '' }}"
                            href="{{ url('/purchase_orders/receiving') }}"><i
                                data-feather="folder-plus"></i><span>Receiving PO
                            </span></a>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav {{ request()->is('all_purchase_orders') ? 'active' : '' }}"
                            href="{{ url('/all_purchase_orders') }}"><i data-feather="folder"></i></i><span>All
                                Purchase Order
                            </span></a>
                    </li>

                    <li class="sidebar-main-title">
                        <div>
                            <h6>Stock Mutations</h6>
                        </div>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav {{ request()->is('stock_mutation/create') ? 'active' : '' }}"
                            href="{{ url('/stock_mutation/create') }}"><i data-feather="edit"></i><span>Create Stock
                                Mutation
                            </span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav {{ request()->is('stock_mutation/approval') ? 'active' : '' }}"
                            href="{{ url('/stock_mutation/approval') }}"><i data-feather="edit"></i><span>Approve
                                Stock
                                Mutation
                            </span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav {{ request()->is('stock_mutation') ? 'active' : '' }}"
                            href="{{ url('/stock_mutation') }}"><i data-feather="clipboard"></i><span>Stock
                                Mutations List
                            </span>
                        </a>
                    </li>

                    <li class="sidebar-main-title">
                        <div>
                            <h6>Information </h6>
                        </div>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav {{ request()->is('check_stock') ? 'active' : '' }}"
                            href="{{ url('/check_stock') }}"><i data-feather="inbox"></i><span>Check
                                Stock
                            </span></a>
                    </li>

                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </div>
    </nav>
</header>
