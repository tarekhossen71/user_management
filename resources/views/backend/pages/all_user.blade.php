@extends('layouts.backend')
@push('page_header')
    <x-page_header href="{{ route('list.create') }}" name="User List" type="Create User"></x-page_header>
@endpush

@push('content')
    <x-content>
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow">
                @include('backend.inlcude.alert')
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <th>Serial</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Country</th>
                                <th>State</th>
                                <th>Postal Code</th>
                                <th>Phone</th>
                                <th>Date of Birth</th>
                                <th>Avater</th>
                                <th>Status</th>
                                <th>Action</th>
                            </thead>
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->address->country->name }}</td>
                                    <td>{{ $user->address->state }}</td>
                                    <td>{{ $user->address->postal_code }}</td>
                                    <td>{{ $user->address->phone }}</td>
                                    <td>{{ $user->address->birthday ? date('d-m-Y', strtotime($user->address->birthday)) : '---' }}</td>
                                    <td>
                                        <img style="width:50px;height: 50px;border-radius:50%" src="{{ $user->avater != null ? asset('profile/'.$user->avater) : 'https://via.placeholder.com/50' }}" alt="">
                                    </td>
                                    <td>
                                        @if ($user->status == 0)
                                                <span class="badge bg-warning">Panding</span>
                                            @else
                                                <span class="badge bg-success">Success</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('list.edit', $user->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                            <form id="form-delete-{{ $user->id }}" method="POST" action="{{ route('list.destroy', $user->id) }}">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <button onclick="alertMessage({{ $user->id }})" type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                
                            @endforelse
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </x-content>
@endpush