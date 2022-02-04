@extends('admin.layouts.master')

@section('title')
    Edit user : {{$user->name}}
@endsection

@section('styles')
@endsection

@section('content')
    <div class="page-inner">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title"> Edit User : {{$user->name}}</div>
                    </div>
                    <form action="{{route('users.update',$user->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-6">

                                    <div class="form-group">
                                        <label for="name">User Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"  id="name" name="name" value="{{$user->name}}" placeholder="Name">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"  id="email" name="email" value="{{$user->email}}" placeholder="Email">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <img style="width: 20%" src="{{asset('/images/users/'.$user->image)}}">
                                        <label for="image">Update a new Image</label>
                                        <input type="file" class="form-control" id="image" name="image">
                                    </div>

                                </div>

                                <div class="col-md-6 col-lg-6">

                                    <div class="form-group">
                                        <label for="role">Role</label>
                                        <select name="role" class="form-control @error('role') is-invalid @enderror" >
                                            <option value="admin" {{$user->role == 'admin' ? 'selected' : ''}}>Admin</option>
                                            <option value="user"  {{$user->role == 'user' ? 'selected' : ''}}>User</option>
                                        </select>

                                        @error('role')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>


                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"  id="password" name="password" placeholder="password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="card-action">
                            <button type="submit" class="btn btn-success">Update</button>
                            <a href="{{route('users.index')}}" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
