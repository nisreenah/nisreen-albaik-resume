@extends('admin.layouts.master')

@section('title')
    Profile
@endsection

@section('styles')
@endsection

@section('content')
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Profile</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Status</th>
                                    <th>Name (English)</th>
                                    <th>Title (English)</th>
                                    <th>Major (English)</th>
                                    <th>Address (English)</th>
                                    <th>Interest (English)</th>
                                    <th>Summary (English)</th>
                                    <th style="width: 10%">Action</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($profiles as $profile)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>
                                            @if($profile->status == '1')
                                                <div class="badge badge-success">Active</div>
                                            @else
                                                <div class="badge badge-danger">Not Active</div>
                                            @endif
                                        </td>
                                        <td>{{$profile->en_name}}</td>
                                        <td>{{$profile->en_title}}</td>
                                        <td>{{$profile->en_major}}</td>
                                        <td>{{str_limit($profile->en_address,30)}}</td>
                                        <td>{{$profile->en_interest}}</td>
                                        <td>{{str_limit($profile->en_summary,30)}}</td>

                                        <td>
                                            <div class="form-button-action">
                                                <a href="{{route('profile.edit',$profile->id)}}">
                                                    <button type="button" data-toggle="tooltip" title=""
                                                            class="btn btn-link btn-primary btn-lg"
                                                            data-original-title="Edit Task">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                </a>
                                                <a href="{{route('profile.destroy',$profile->id)}}" class="delete-confirm">
                                                    <button type="button" data-toggle="tooltip" title="Delete profile"
                                                            class="btn btn-link btn-danger btn-lg"
                                                            data-original-title="Delete profile">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>

                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
{{--    <script>--}}
{{--        $('.submitDestroy').on('lick', function (e) {--}}
{{--            e.preventDefault();--}}
{{--            var form = $(this).parents('form');--}}

{{--            swal({--}}
{{--                title: "Are you sure?",--}}
{{--                text: "You won't be able to revert this!",--}}
{{--                type: "warning",--}}
{{--                showCancelButton: true,--}}
{{--                confirmButtonColor: "#DD6B55",--}}
{{--                confirmButtonText: "Yes, delete it!",--}}
{{--                closeOnConfirm: false--}}
{{--            }, function (isConfirm) {--}}
{{--                if (isConfirm) form.submit();--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}

    <!-- Datatables -->
    <script src="{{asset('assets/js/plugin/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugin/datatables/data-table.js')}}"></script>

@endsection
