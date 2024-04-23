<x-app-layout>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        {{-- <x-app.navbar /> --}}
        <div class="container-fluid pb-4 pb-0 px-4">
            <div class="row">
                <div class="col-12">
                    <div class="card card-background card-background-after-none align-items-start mt-4 mb-5"
                        id="zoomin">
                        <div class="full-background"
                            style="background-image: radial-gradient( circle farthest-corner at 12.3% 19.3%,  rgba(85,88,218,1) 0%, rgba(95,209,249,1) 100.2% );">
                        </div>
                        <div class="card-body text-start p-4 w-100">
                            <h3 class="text-white mb-2">Book. Click. Enjoy 🔥</h3>
                            <p class="mb-4 font-weight-semibold">
                                Create your own Evnets
                            </p>
                            <img src="{{ asset('eventmanage.png') }}" alt="Event"
                                class="position-absolute top-0 end-1 w-30 mb-0 max-width-250 mt-0 d-sm-block d-none" />
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sale & Revenue Start -->
            <div class="container-fluid pt-0 px-4">
                <div class="row g-4">
                    <div class="col-sm-6 col-xl-3">
                        <a href="{{ route('TodaySale') }}" style="text-decoration: none;">
                            <div id="zoomin"
                                class="bg-gray-500 text-dark border-radius-2xl d-flex align-items-center justify-content-between p-4">
                                <i class="fa fa-chart-line fa-beat-fade fa-3x text-primary"></i>
                                <div class="ms-3">
                                    <p class="mb-2">Today Sale</p>
                                    <h6 class="mb-0">{{ $Todaysale }}</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <a href="{{ route('OrganizerOrderDetails') }}" style="text-decoration: none;">
                            <div id="zoomin"
                                class="bg-gray-500 text-dark border-radius-2xl d-flex align-items-center justify-content-between p-4">
                                <i class="fa fa-chart-bar fa-beat-fade fa-3x text-primary"></i>
                                <div class="ms-3">
                                    <p class="mb-2">Total Sale</p>
                                    <h6 class="mb-0">{{ $Totalsale }}</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <a href="{{ route('TodaySale') }}" style="text-decoration: none;">
                            <div id="zoomin"
                                class="bg-gray-500 text-dark border-radius-2xl d-flex align-items-center justify-content-between p-4">
                                <i class="fa-solid fa-hand-holding-dollar fa-beat-fade fa-3x text-primary"></i>
                                <div class="ms-3">
                                    <p class="mb-2">Today Revenue</p>
                                    <h6 class="mb-0">₹{{ number_format($Todayprice, 2) }}</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <a href="{{ route('OrganizerOrderDetails') }}" style="text-decoration: none;">
                            <div id="zoomin"
                                class="bg-gray-500 text-dark border-radius-2xl d-flex align-items-center justify-content-between p-4">
                                <i class="fa-solid fa-file-invoice-dollar fa-beat-fade fa-3x text-primary"></i>
                                <div class="ms-3">
                                    <p class="mb-2">Total Revenue</p>
                                    <h6 class="mb-0">₹{{ number_format($Totalprice, 2) }}</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Sale & Revenue End -->

            <!-- Recent Sales Start -->
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card border shadow-xs mb-4">
                        <div class="card-header bg-gray-200 border-bottom pb-0">
                            <div class="d-sm-flex align-items-center">
                                <div>
                                    <h6 class="font-weight-semibold text-lg mb-0">Today's Sales list</h6>
                                    <p class="text-sm">See information about Today Sales list</p>
                                </div>

                            </div>
                        </div>
                        <div class="card-body px-0 py-0">

                            <div class="table p-0">
                                @if ($orders->isEmpty())
                                    <p class="text-center p-5">No Sales Available</p>
                                @else
                                    <table class="table align-items-center mb-0 w-100">
                                        <thead class="bg-gray-100">
                                            <tr>
                                                <th class="align-middle ps-4">Customer Name</th>
                                                <th class="align-middle ps-4">Event Name</th>
                                                <th class="align-middle text-center">Price</th>
                                                <th class="align-middle text-center">Quantity</th>
                                                <th class="align-middle text-center">Purchase Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $order)
                                                <tr class="justify-content-center" id="zoomin">
                                                    <td class="align-middle">
                                                        <p class="text-sm text-dark ms-5 mb-0">{{ $order->user->name }}
                                                        </p>
                                                    </td>
                                                    <td class="align-middle text-center p-3">
                                                        <p class="text-sm text-dark max-width-100  mb-0"
                                                            style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis">
                                                            {{ $order->event->name }}
                                                        </p>
                                                    </td>
                                                    <td class="align-middle text-center p-3 ">
                                                        <p class="text-sm text-dark  mb-0">
                                                            ₹{{ number_format($order->price, 2) }}
                                                        </p>
                                                    </td>
                                                    <td class="align-middle text-center p-3 ">
                                                        <p class="text-sm text-dark  mb-0">
                                                            {{ $order->quantity }}
                                                        </p>
                                                    </td>
                                                    <td class="align-middle text-center p-3 ">
                                                        <p class="text-sm text-dark  mb-0">
                                                            {{ date('d-m-Y h:i:s A', strtotime($order->created_at)) }}
                                                        </p>
                                                    </td>

                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                    <div class="d-flex ms-3 mt-4">
                                        {{ $orders->links('pagination::bootstrap-5') }}
                                    </div>
                                @endif
                            </div>

                        </div>

                    </div>
                </div>
                <!-- Recent Sales End -->


                {{-- <x-app.footer /> --}}
            </div>
    </main>

</x-app-layout>
