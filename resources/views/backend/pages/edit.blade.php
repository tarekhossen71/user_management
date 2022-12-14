@extends('layouts.backend')
@push('page_header')
    <x-page_header href="{{ route('list.index') }}" name="Edit User Data" type="View User Data"></x-page_header>
@endpush

@push('content')
    <x-content>
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow">
                @include('backend.inlcude.alert')
                <div class="card-body">
                    <form method="POST" action="{{ route('list.update', $users->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="name" class=" col-form-label text-md-end">{{ __('Name') }}</label>
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $users->name }}" required autocomplete="name" autofocus>
        
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
        
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="email" class="col-form-label text-md-end">{{ __('Email Address') }}</label>
        
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $users->email }}" required autocomplete="email">
        
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
        
                                {{-- Country DB table --}}
                                @php
                                    $countries = DB::table('countries')->get();
                                @endphp
        
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="country" class="col-form-label text-md-end">{{ __('Country') }}</label>
                                        <select name="country" id="country" class="form-control @error('country') is-invalid @enderror">
                                            <option value="">selct country</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}" {{ $users->address->country_id == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                            @endforeach
                                        </select>
        
                                        @error('country')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="state" class="col-form-label text-md-end">{{ __('State') }}</label>
                                        <input id="state" type="text" class="form-control @error('state') is-invalid @enderror" name="state" value="{{ $users->address->state }}" required autocomplete="state">
        
                                        @error('state')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="postal_code" class="col-form-label text-md-end">{{ __('Postal Code') }}</label>
                                        <input id="postal_code" type="text" class="form-control @error('postal_code') is-invalid @enderror" name="postal_code" value="{{ $users->address->postal_code }}" required autocomplete="postal_code">
        
                                        @error('postal_code')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="phone" class="col-form-label text-md-end">{{ __('Phone Number') }}</label>
                                        <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $users->address->phone }}" required autocomplete="phone">
        
                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="birthday" class="col-form-label text-md-end">{{ __('Date Of Birth') }}</label>
                                        <input id="birthday" type="date" class="form-control @error('phone') is-invalid @enderror" name="birthday" value="{{ $users->address->birthday ? date('Y-m-d', strtotime($users->address->birthday)) : '---' }}" required autocomplete="birthday">
        
                                        @error('birthday')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
        
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="avater" class="col-form-label text-md-end">{{ __('Avater') }}</label>
                                        <input id="avater" type="file" class="form-control @error('phone') is-invalid @enderror" name="avater" autocomplete="avater">
                                        <input type="hidden" name="avater_hidden" value="{{ $users->avater }}">
                                        <img style="width: 50px;height:50px" class="mt-2" src="{{ $users->avater != null ? asset('profile/'.$users->avater) : 'https://via.placeholder.com/50' }}" alt="">
        
                                        @error('avater')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
        
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="country" class="col-form-label text-md-end">{{ __('Status') }}</label>
                                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                            <option value="">selct status</option>
                                            <option value="0" {{ $users->status == 0 ? 'selected' : '' }}>Panding</option>
                                            <option value="1" {{ $users->status == 1 ? 'selected' : '' }}>Active</option>
                                        </select>
        
                                        @error('status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-0">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-success">
                                            {{ __('Update') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                        
                    </form>
                </div>
            </div>
        </div>
    </x-content>
@endpush