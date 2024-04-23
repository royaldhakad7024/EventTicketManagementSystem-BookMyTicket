<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

        <div class="container-fluid mt-4 px-4 pb-0">
            {{-- Start of Header Card  --}}
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
                                Check all the Events and choose the best.
                            </p>
                            <img src="{{ asset('createEvent.png') }}" alt="Event"
                                class="position-absolute top-0 end-1 w-28 mb-0 max-width-250  d-sm-block d-none" />
                        </div>
                    </div>
                </div>
            </div>
            {{-- End of Header Card  --}}

            {{-- Start of Event Update Form  --}}
            <form action='{{ route('events.update', ['id' => $event->id]) }}' method="POST"
                enctype="multipart/form-data">
                @csrf

                {{-- Start of Error/Success Message  --}}
                <div class="row justify-content-center">
                    <div class="col-10">
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert" id="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success" role="alert" id="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>
                </div>
                {{-- End of Error/Success Message  --}}
                <div class="mb-5 row justify-content-center">
                    <div class="col-lg-9 col-12 ">
                        <div class="card " id="basic-info">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-6 ">
                                        <h5>Update Your Event </h5>
                                    </div>
                                    <div class="col-6 text-end">
                                        @if ($event->image)
                                            <img src="{{ asset('storage/' . $event->image) }}"
                                                class="img-fluid rounded-3" alt="Shopping item" style="width: 80px;">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="pt-0 card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="name">Event Name *</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                            value="{{ $event->name }}">
                                        @error('name')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <label for="venue">Event Venue *</label>
                                        <input type="text" name="venue" id="venue" class="form-control"
                                            value="{{ $event->venue }}">
                                        @error('venue')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="date">Event Date *</label>
                                        <input type="text" name="date" id="date" class="form-control"
                                            value="{{ $newDate }}">
                                        @error('date')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <div class="cs-form">
                                            <label for="time">Event Time *</label>
                                            <input type="time" name="time" id="time" class="form-control"
                                                value="{{ $newTime }}" />
                                        </div>
                                        {{-- <input type="text" name="time" id="time" class="form-control"> --}}
                                        @error('time')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="image">Event Photo</label>
                                        <input type="file" name="imageUpadte" id="imageUpadte" class="form-control"
                                            value="{{ $event->image }}" accept="image/">
                                        @error('image')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <label for="price">Event Price *</label>
                                        <input type="number" name="price" id="price" class="form-control"
                                            value="{{ $event->price }}">
                                        @error('price')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-4">
                                        <label for="quantity">Ticket Quantity</label>
                                        <input type="number" name="quantity" id="quantity" class="form-control"
                                            value="{{ $event->quantity }}">
                                        @error('quantity')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row p-2">
                                    <label for="about">Event Description</label>
                                    <textarea name="about" id="about" rows="3" class="form-control">{{ $event->about }}</textarea>
                                    @error('about')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-10">
                                        <button type="submit"
                                            class="btn btn-outline-success btn-sm float-end">Update</button>
                                    </div>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-outline-danger btn-sm float-start"
                                            onclick="window.location.href='{{ route('event') }}'">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            {{-- End of Event Update Form  --}}
        </div>
        <x-app.footer />
        </div>
    </main>
    <script src='https://code.jquery.com/jquery-3.4.1.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js'></script>
    <script>
        // Initialize Flatpickr
        flatpickr("#date", {
            enableTime: false, // Disable time selection
            dateFormat: "Y-m-d", // Date format
            minDate: "today" // Disable previous dates
        });
    </script>
</x-app-layout>