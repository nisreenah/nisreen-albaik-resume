@extends('admin.layouts.master')

@section('title')
    All Testimonials
@endsection

@section('styles')
@endsection

@section('content')
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">All Testimonials</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Client Image</th>
                                    <th>Clinet Name (English)</th>
                                    <th>Clinet Comment (English)</th>
                                    <th>Clinet Position (English)</th>
                                    <th>Clinet Name (Arabic)</th>
                                    <th>Clinet Comment (Arabic)</th>
                                    <th>Clinet Position (Arabic)</th>
                                    <th style="width: 10%">Action</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($testimonials as $testimonial)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td><img width="100px" src="{{ asset('images/testimonials/'.$testimonial->image) }}"></td>
                                        <td>{{$testimonial->en_name}}</td>
                                        <td>{{$testimonial->en_comment}}</td>
                                        <td>{{$testimonial->en_position}}</td>
                                        <td>{{$testimonial->ar_name}}</td>
                                        <td>{{$testimonial->ar_comment}}</td>
                                        <td>{{$testimonial->ar_position}}</td>


                                        <td>
                                            <div class="form-button-action">
                                                <a href="{{route('testimonials.edit',$testimonial->id)}}">
                                                    <button type="button" data-toggle="tooltip" title=""
                                                            class="btn btn-link btn-primary btn-lg"
                                                            data-original-title="Edit Task">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                </a>
                                                <a href="{{route('testimonials.destroy',$testimonial->id)}}" class="delete-confirm">
                                                    <button type="button" data-toggle="tooltip" title="Delete testimonial"
                                                            class="btn btn-link btn-danger btn-lg"
                                                            data-original-title="Delete testimonial">
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
