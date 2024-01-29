<div class="dropdown topbar-head-dropdown ms-1 header-item">
    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="bx bx-bell fs-22"></i>
        {{-- @if (count($unreadNoti))
            <span class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">{{ $unreadNoti->count()}}<span class="visually-hidden">unread messages</span></span>
        @endif --}}
        <span class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">1<span class="visually-hidden">unread messages</span></span>
    </button>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0 overflow-hidden" aria-labelledby="page-header-notifications-dropdown" style="border-color:transparent;border-radius: 15px">

        <div class="dropdown-head bg-pattern rounded-top" style="background: #1F2C3E;">
            <div class="p-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="m-0 fs-16 fw-semibold text-white"> Notifications </h6>
                    </div>
                    <div class="col-auto dropdown-tabs">
                        <span class="badge badge-soft-light fs-13">1 New</span>
                    </div>
                </div>
            </div>

            <div class="px-2 pt-2">
                <ul class="nav nav-tabs dropdown-tabs nav-tabs-custom" data-dropdown-tabs="true" id="notificationItemsTab" role="tablist">
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link active" data-bs-toggle="tab" href="#alerts-tab" role="tab" aria-selected="false">
                            New
                        </a>
                    </li>
                </ul>
            </div>

        </div>

        <div class="tab-content" id="notificationItemsTabContent" style="max-height: 300px; overflow-y: scroll;overflow-x: hidden;">
            <div class="tab-pane fade p-1 active show" id="alerts-tab" role="tabpanel" aria-labelledby="alerts-tab">
                {{-- @if (count($unreadNoti) != 0)
                    @foreach ($unreadNoti as $noti)
                    <div class="text-reset notification-item d-block dropdown-item position-relative">
                        <div class="d-flex">
                            <div class="avatar-xs me-3">
                                <span class="avatar-title bg-soft-danger text-danger rounded-circle fs-16">
                                    <i class="bx bx-message-square-dots"></i>
                                </span>
                            </div>
                            <div class="flex-1">
                                <a href="{{ route('order.detail',['order'=>$noti->data['orderId'],'notiId'=>$noti->id]) }}" class="stretched-link">
                                    <h6 class="mt-0 mb-2 fs-13 lh-base"><b class="text-success">{{ $noti->data['name'] }}</b> {{$noti->data['message']}}
                                    </h6>
                                </a>
                                <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                    <span><i class="mdi mdi-clock-outline me-2"></i>{{$noti->created_at->diffForHumans()}}</span>

                                </p>
                            </div>
                            <div class="">
                                <a href="{{ route('noti.delete',$noti->id) }}" class="btn noti_close_btn shadow-sm  p-1 py-1 d-flex justify-content-center align-items-center" style="width: 30px;height:30px;z-index:2000;"><i class=" ri-close-fill"></i></a>
                            </div>
                        </div>
                    </div>

                    @endforeach
                @else
                    <div class="w-25 w-sm-50 pt-3 mx-auto">
                        <img src="{{ asset('assets/images/svg/bell.svg') }}" class="img-fluid" alt="user-pic">
                    </div>
                    <div class="text-center pb-5 mt-2">
                        <h6 class="fs-18 fw-semibold lh-base">You have no any notifications </h6>
                    </div>
                @endif --}}
                <div class="text-reset notification-item d-block dropdown-item position-relative">
                    <div class="d-flex">
                        <div class="avatar-xs me-3">
                            <span class="avatar-title bg-soft-danger text-danger rounded-circle fs-16">
                                <i class="bx bx-message-square-dots"></i>
                            </span>
                        </div>
                        <div class="flex-1">
                            <a href="{{-- route('order.detail',['order'=>$noti->data['orderId'],'notiId'=>$noti->id]) --}}" class="stretched-link">
                                <h6 class="mt-0 mb-2 fs-13 lh-base"><b class="text-success">noti name</b> noti message
                                </h6>
                            </a>
                            <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                <span><i class="mdi mdi-clock-outline me-2"></i>1 second ago</span>
                            </p>
                        </div>
                        <div class="">
                            <a href="{{-- route('noti.delete',$noti->id) --}}" class="btn noti_close_btn shadow-sm  p-1 py-1 d-flex justify-content-center align-items-center" style="width: 30px;height:30px;z-index:2000;"><i class=" ri-close-fill"></i></a>
                        </div>
                    </div>
                </div>

                <div class="w-25 w-sm-50 pt-3 mx-auto">
                    <img src="{{ asset('assets/images/svg/bell.svg') }}" class="img-fluid" alt="user-pic">
                </div>
                <div class="text-center pb-5 mt-2">
                    <h6 class="fs-18 fw-semibold lh-base">You have no any notifications </h6>
                </div>
            </div>
        </div>
    </div>
</div>
