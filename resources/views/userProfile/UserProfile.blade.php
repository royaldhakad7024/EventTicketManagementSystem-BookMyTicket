<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/css/intlTelInput.css'>

        <style>
            .edit-icon {
                position: absolute;
                top: 100%;
                right: 0%;
                transform: translate(50%, -50%);
                border-radius: 100%;
                padding: 5px;
                visibility: hidden;
            }

            .avatar:hover .edit-icon {
                visibility: visible;
            }

            .edit-icon i {
                color: #000;
            }
        </style>
        <div class="container-fluid ">
            {{-- Start of User's Info Update Form  --}}
            <form action={{ route('user.update') }} method="POST" role="form">
                @csrf
                @method('PUT')
                <div class="mt-5 mb-5 mt-lg-7 row justify-content-center">
                    <div class=" col-10">
                        {{-- Start of User's Profile Card  --}}
                        <div class="card card-body"
                            style="background-image: radial-gradient( circle farthest-corner at 12.3% 19.3%,  rgba(85,88,218,1) 0%, rgba(95,209,249,1) 100.2% );"
                            id="zoomin">
                            <div class="row z-index-2 justify-content-start align-items-center">
                                <div class="col-sm-auto col-4">
                                    <div class="avatar avatar-2xl position-relative">
                                        <a href="{{ route('user.PhotoUpdate') }}"
                                            onclick="return confirm('Do you want to update the Profile photo?')">
                                            <div class="position-relative">
                                                @if (auth()->user()->pfp)
                                                    <img src="{{ url('storage/' . auth()->user()->pfp) }}"
                                                        alt="Profile Photo"
                                                        class="w-100 h-100 object-fit-cover border-radius-2xl shadow-sm"
                                                        id="preview">
                                                @else
                                                    <img src="{{ asset('profileimg.png') }}" alt="Default Profile Photo"
                                                        class="w-100 h-100 object-fit-cover border-radius-2xl shadow-sm"
                                                        id="preview">
                                                @endif
                                                <div class="edit-icon">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-sm-auto col-8 my-auto">
                                    <div class="h-100">
                                        <h2 class="  font-weight-bolder">
                                            {{ auth()->user()->name }}
                                        </h2>
                                        <p>{{ auth()->user()->email }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- End of User's Profile Card  --}}

                {{-- Start of Error/Success Message  --}}
                <div class="row justify-content-center">
                    <div class="col-lg-9 col-12">
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
                    <div class="col-10 ">
                        <div class="card " id="basic-info">
                            <div class="card-header">
                                <h5>Update Profile</h5>
                            </div>
                            <div class="pt-0 card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="name">Name *</label>
                                        <input type="text" name="name" id="name"
                                            value="{{ old('name', auth()->user()->name) }}" class="form-control">
                                        @error('name')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <label for="email">Email *</label>
                                        <input type="email" name="email" id="email"
                                            value="{{ old('email', auth()->user()->email) }}" class="form-control">
                                        @error('email')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="location">Location *</label>
                                        <input type="text" name="location" id="location"
                                            placeholder="Gujarat, India"
                                            value="{{ old('location', auth()->user()->location) }}"
                                            class="form-control">
                                        @error('location')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <label for="phone">Phone Number *</label>
                                        <br>
                                        <input type="text" id="mobile_code" class="form-control"
                                            value="{{ old('location', auth()->user()->phone) }}"
                                            placeholder="Phone Number" name="phone">

                                        @error('phone')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row ps-4 pe-4">
                                <div class="col-12">
                                    <label for="about">About me</label>
                                    <textarea name="aboutyou" id="aboutyou" rows="3" class="form-control">{{ old('about', auth()->user()->about) }}</textarea>
                                    @error('aboutyou')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-10">
                                    <button type="submit"
                                        class="btn btn-outline-success btn-sm float-end">Submit</button>
                                </div>
                                <div class="col-2">
                                    <button type="button" class="btn btn-outline-danger btn-sm float-start"
                                        onclick="window.location.href='{{ route('user.profile') }}'">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        </form>
        {{-- End of User's Info Update Form  --}}
        </div>
        <x-app.footer />
        </div>
        <script src='https://code.jquery.com/jquery-3.4.1.min.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js'></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js'></script>

        <script src='https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput-jquery.min.js'></script>
        <script src="https://cdn.jsdelivr.net/gh/linuxguist/countries@main/script.js"></script>

    </main>
</x-app-layout>