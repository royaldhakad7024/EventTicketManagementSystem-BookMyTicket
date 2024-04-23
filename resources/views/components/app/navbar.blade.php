<nav class="navbar navbar-main navbar-expand-lg mx-5 px-0 shadow-none rounded" id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid py-1 px-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-1 pb-0 pt-1 px-0 me-sm-6 me-5">

                <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard</li>
            </ol>
            <h6 class="font-weight-bold mb-0"> {{ auth()->user()->name }}</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                {{-- <div class="input-group">
                    <span class="input-group-text text-body bg-white  border-end-0 ">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </span>
                    <input type="text" class="form-control ps-0" placeholder="Search">
                </div> --}}
            </div>

            {{-- Logout Button --}}
            <div class="mb-0 font-weight-bold breadcrumb-text text-white">
                <form method="GET" action="{{ route('logout') }}">


                    <a href="login" onclick="event.preventDefault();
                this.closest('form').submit();">
                        <button class="btn btn-sm  btn-white  mb-0 me-1" type="submit">Log out</button>
                    </a>
                </form>
            </div>
            <ul class="navbar-nav  justify-content-end">
                {{-- User Profile --}}
                <li class="nav-item ps-2 d-flex align-items-center">
                    <a href="{{ route('user.profile') }}" class="nav-link text-body p-0">
                        @if (auth()->user()->pfp)
                            <img src="{{ url('storage/' . auth()->user()->pfp) }}" class="avatar avatar-sm"
                                alt="avatar" />
                        @else
                            <img src="{{ asset('storage/profileimg.png') }}" class="avatar avatar-sm" alt="avatar" />
                        @endif

                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->
