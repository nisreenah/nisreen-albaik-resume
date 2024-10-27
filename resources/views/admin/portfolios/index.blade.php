@extends('admin.layouts.master')

@section('title')
    All Portfolio
@endsection

@section('styles')
@endsection

@section('content')
    <div class="page-inner">

        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">All Portfolio</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Project Name</th>
                                    <th>Project Image</th>
                                    <th>Client Name (English)</th>
                                    <th>Completion Date</th>
                                    <th>Details (English)</th>
                                    <th>Category Name</th>
                                    <th>Gallery</th>
                                    <th style="width: 10%">Action</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($portfolios as $portfolio)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$portfolio->en_name}}</td>
                                        <td><img width="100px" src="{{asset('images/portfolios/'.$portfolio->image)}}"></td>
                                        <td>{{$portfolio->en_client}}</td>
                                        <td>{{$portfolio->completion}}</td>
                                        <td>{{str_limit($portfolio->en_details, 30)}}</td>
                                        <td>{{$portfolio->category->name}}</td>
                                        <td><a href="{{route('portfolio.gallery',$portfolio->id)}}">Go to the Gallery</a></td>
                                        <td>
                                            <div class="form-button-action">
                                                <a href="{{route('portfolio.edit',$portfolio->id)}}">
                                                    <button type="button" data-toggle="tooltip" title=""
                                                            class="btn btn-link btn-primary btn-lg"
                                                            data-original-title="Edit Task">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                </a>
                                                <a href="{{route('portfolio.destroy',$portfolio->id)}}" class="delete-confirm">
                                                    <button type="button" data-toggle="tooltip" title="Delete portfolio"
                                                            class="btn btn-link btn-danger btn-lg"
                                                            data-original-title="Delete portfolio">
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
