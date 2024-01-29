<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="" class="logo logo-dark">
                    <span class="logo-sm">
                       <img src="{{asset('images/logo.png')}}" alt="" height="40">
                    </span>
            <span class="logo-lg">
                       <img src="{{asset('images/logo.png')}}" alt="" height="60">
                    </span>
        </a>
        <!-- Light Logo-->
        <a href="" class="logo logo-light">
                    <span class="logo-sm">
                       <img src="{{asset('images/logo.png')}}" alt="" height="40">
                    </span>
            <span class="logo-lg">
                       <img src="{{asset('images/logo.png')}}" alt="" height="60">
                    </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
                id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <a href="{{route('home')}}" class="nav-link @yield('dash')"><i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboard</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link @yield('banner')" href="#banner" data-bs-toggle="collapse" role="button"
                       aria-expanded="false" aria-controls="banner">
                        <i class="ri-stack-line"></i> <span data-key="t-dashboards">Banner</span>
                    </a>
                    <div class="collapse menu-dropdown @yield('banner-show')" id="banner">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{route('banner.create')}}" class="nav-link  @yield('add-banner-active')" data-key="t-add-banner"> Add Banner
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('banner.index')}}" class="nav-link  @yield('banner-active')" data-key="t-banner"> Banner </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link @yield('category')" href="#categories" data-bs-toggle="collapse" role="button"
                       aria-expanded="false" aria-controls="categories">
                        <i class="ri-stack-line"></i> <span data-key="t-dashboards">Category</span>
                    </a>
                    <div class="collapse menu-dropdown @yield('category-show')" id="categories">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{route('category.create')}}" class="nav-link  @yield('add-category-active')" data-key="t-add-categories"> Add Category
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('category.index')}}" class="nav-link  @yield('category-active')" data-key="t-categories"> Category </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link @yield('genre')" href="#genres" data-bs-toggle="collapse" role="button"
                       aria-expanded="false" aria-controls="genres">
                        <i class="ri-stack-line"></i> <span data-key="t-dashboards">Genre</span>
                    </a>
                    <div class="collapse menu-dropdown @yield('genre-show')" id="genres">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{route('genre.create')}}" class="nav-link  @yield('add-genre-active')" data-key="t-add-genres"> Add Genre
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('genre.index')}}" class="nav-link  @yield('genre-active')" data-key="t-genres"> Genres </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link @yield('book')" href="#books" data-bs-toggle="collapse" role="button"
                       aria-expanded="false" aria-controls="books">
                        <i class="ri-book-open-line"></i> <span data-key="t-dashboards">Book</span>
                    </a>
                    <div class="collapse menu-dropdown @yield('book-show')" id="books">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{route('book.create')}}" class="nav-link  @yield('add-book-active')" data-key="t-add-books"> Add Book
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('book.index')}}" class="nav-link  @yield('book-active')" data-key="t-books"> Book </a>
                            </li>

                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link @yield('event')" href="#event" data-bs-toggle="collapse" role="button"
                       aria-expanded="false" aria-controls="event">
                        <i class="ri-stack-line"></i> <span data-key="t-dashboards">Events</span>
                    </a>
                    <div class="collapse menu-dropdown @yield('event-show')" id="event">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{route('events.create')}}" class="nav-link  @yield('add-event-active')" data-key="t-add-event"> Add Event
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('events.index')}}" class="nav-link  @yield('event-active')" data-key="t-event"> Events </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link @yield('promotion')" href="#promotion" data-bs-toggle="collapse" role="button"
                       aria-expanded="false" aria-controls="promotion">
                        <i class="ri-stack-line"></i> <span data-key="t-dashboards">Promotion</span>
                    </a>
                    <div class="collapse menu-dropdown @yield('promotion-show')" id="promotion">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{route('promotions.create')}}" class="nav-link  @yield('add-promotion-active')" data-key="t-add-promotion"> Add Promotion
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('promotions.index')}}" class="nav-link  @yield('promotion-active')" data-key="t-promotion"> Promotion </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="{{route('user.index')}}" class="nav-link @yield('user')"><i class="ri-group-line"></i> <span data-key="t-dashboards">Users</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link @yield('member')" href="#members" data-bs-toggle="collapse" role="button"
                       aria-expanded="false" aria-controls="members">
                        <i class="ri-user-heart-line"></i> <span data-key="t-dashboards">Members</span>
                    </a>
                    <div class="collapse menu-dropdown @yield('member-show')" id="members">
                        <ul class="nav nav-sm flex-column">
                            {{-- <li class="nav-item">
                                <a href="{{route('member.request')}}" class="nav-link  @yield('request-member-active')" data-key="t-add-members"> Member Request
                                </a>
                            </li> --}}
                            <li class="nav-item">
                                <a href="{{route('members.index')}}" class="nav-link  @yield('member-active')" data-key="t-members"> Members </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('subscribe.index')}}" class="nav-link  @yield('subscribe-member-active')" data-key="t-members"> Member Subscription </a>
                            </li>
                        </ul>
                    </div>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{route('opportunity.create')}}" class="nav-link @yield('opportunity')"><i class="ri-gift-line"></i> <span data-key="t-dashboards">Member Opportunity</span>
                    </a>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link menu-link @yield('package')" href="#package" data-bs-toggle="collapse" role="button"
                       aria-expanded="false" aria-controls="package">
                        <i class="ri-gift-line"></i> <span data-key="t-dashboards"> Subscription Packages </span>
                    </a>
                    <div class="collapse menu-dropdown @yield('package-show')" id="package">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{route('packages.create')}}" class="nav-link  @yield('add-package-active')" data-key="t-add-package"> Add Subscription Package
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('packages.index')}}" class="nav-link  @yield('package-active')" data-key="t-package"> Subscription Package List </a>
                            </li>

                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link @yield('payment')" href="#payment" data-bs-toggle="collapse" role="button"
                       aria-expanded="false" aria-controls="payment">
                       <i class="ri-money-dollar-circle-line"></i> <span data-key="t-dashboards"> Payments </span>
                    </a>
                    <div class="collapse menu-dropdown @yield('payment-show')" id="payment">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{route('payments.create')}}" class="nav-link  @yield('add-payment-active')" data-key="t-add-payment"> Add Payment
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('payments.index')}}" class="nav-link  @yield('payment-active')" data-key="t-payment"> Payment List </a>
                            </li>

                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link @yield('region')" href="#region" data-bs-toggle="collapse" role="button"
                       aria-expanded="false" aria-controls="region">
                       <i class="ri-building-line"></i> <span data-key="t-dashboards"> Regions </span>
                    </a>
                    <div class="collapse menu-dropdown @yield('region-show')" id="region">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{route('regions.create')}}" class="nav-link  @yield('add-region-active')" data-key="t-add-region"> Add Region
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('regions.index')}}" class="nav-link  @yield('region-active')" data-key="t-region"> Region List </a>
                            </li>

                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link @yield('delivery-fee')" href="#delivery-fee" data-bs-toggle="collapse" role="button"
                       aria-expanded="false" aria-controls="delivery-fee">
                       <i class="ri-truck-line"></i> <span data-key="t-dashboards"> Delivery Fees </span>
                    </a>
                    <div class="collapse menu-dropdown @yield('delivery-fee-show')" id="delivery-fee">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{route('delivery-fees.create')}}" class="nav-link  @yield('add-delivery-fee-active')" data-key="t-add-delivery-fee"> Add Delivery Fee
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('delivery-fees.index')}}" class="nav-link  @yield('delivery-fee-active')" data-key="t-delivery-fee"> Delivery Fees List </a>
                            </li>

                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link @yield('point')" href="#point" data-bs-toggle="collapse" role="button"
                       aria-expanded="false" aria-controls="point">
                       <i class="ri-star-s-line"></i> <span data-key="t-dashboards"> Credit Points </span>
                    </a>
                    <div class="collapse menu-dropdown @yield('point-show')" id="point">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{route('credit-points.create')}}" class="nav-link  @yield('add-point-active')" data-key="t-add-point"> Add Credit Point
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('credit-points.index')}}" class="nav-link  @yield('point-active')" data-key="t-point"> Credit Point List </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('order-points.index')}}" class="nav-link  @yield('order-point-active')" data-key="t-point"> Credit Point Orders </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link @yield('order')" href="#order" data-bs-toggle="collapse" role="button"
                       aria-expanded="false" aria-controls="order">
                       <i class="ri-list-check"></i> <span data-key="t-dashboards"> Orders </span>
                    </a>
                    <div class="collapse menu-dropdown @yield('order-show')" id="order">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{route('rent.index')}}" class="nav-link @yield('order-history')">
                                    Rent History
                                </a>
                                <a href="{{route('rent.pending')}}" class="nav-link @yield('pending-order')">
                                    Pending Orders
                                </a>
                                <a href="{{route('rent.reserved')}}" class="nav-link @yield('pre-order')">
                                    Reserved Books
                                </a>
                                <a href="{{route('rent.confirmed')}}" class="nav-link @yield('confirm-order')">
                                    Comfirmed Orders
                                </a>

                            </li>
                            {{-- <li class="nav-item">
                                <a href="{{route('credit-.create')}}" class="nav-link  @yield('add-point-active')" data-key="t-add-point">
                                    Add Credit Point
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('credit-points.index')}}" class="nav-link  @yield('point-active')" data-key="t-point">
                                    Credit Point List </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('order-points.index')}}" class="nav-link  @yield('order-point-active')" data-key="t-point">
                                    Credit Point Orders </a>
                            </li> --}}
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="{{route('settings')}}" class="nav-link @yield('setting')"><i class="ri-settings-5-line"></i> <span data-key="t-settings">Settings</span></a>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
