@extends('admin.layouts.master')

@section('title')
    All Educations
@endsection

@section('styles')
@endsection

@section('content')
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">All Educations</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Major (English)</th>
                                    <th>University Name (English)</th>
                                    <th>Major (Arabic)</th>
                                    <th>University Name (Arabic)</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th style="width: 10%">Action</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($educations as $education)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$education->en_major}}</td>
                                        <td>{{$education->en_university}}</td>
                                        <td>{{$education->ar_major}}</td>
                                        <td>{{$education->ar_university}}</td>
                                        <td>{{$education->start_date}}</td>
                                        <td>{{$education->end_date}}</td>

                                        <td>
                                            <div class="form-button-action">
                                                <a href="{{route('educations.edit',$education->id)}}">
                                                    <button type="button" data-toggle="tooltip" title=""
                                                            class="btn btn-link btn-primary btn-lg"
                                                            data-original-title="Edit Task">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                </a>

                                                <a href="{{route('educations.destroy',$education->id)}}" class="delete-confirm">
                                                    <button type="button" data-toggle="tooltip" title="Delete education"
                                                            class="btn btn-link btn-danger btn-lg"
                                                            data-original-title="Delete education">
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
