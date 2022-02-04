@extends('admin.layouts.master')

@section('title')
    All Comments
@endsection

@section('styles')
@endsection

@section('content')
    <div class="page-inner">

        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">All Comments</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User Name</th>
                                    {{--<th>Email</th>--}}
                                    <th>Status</th>
                                    <th>Comment</th>
                                    <th>Posted At</th>
                                    <th style="width: 10%">Action</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($comments as $comment)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$comment->name}}</td>
                                        {{--<td>{{$comment->email}}</td>--}}
                                    <td>
                                        @if($comment->status == 'waiting')
                                            <div class="badge badge-warning">Waiting</div>
                                        @elseif($comment->status == 'accepted')
                                            <div class="badge badge-success">Accepted</div>
                                        @else
                                            <div class="badge badge-danger">Rejected</div>
                                        @endif
                                    </td>
                                    <td>{{str_limit($comment->comment,30)}}</td>
                                    <td>{{$comment->created_at}}</td>
                                    <td>
                                        <div class="form-button-action">

                                            @if($comment->status == 'accepted')
                                                <a href="{{route('comments.deactivate',$comment->id)}}">
                                                    <button type="button" data-toggle="tooltip"
                                                            title="deactivate comment"
                                                            class="btn btn-link btn-warning btn-lg"
                                                            data-original-title="deactivate comment">
                                                        <i class="fa fa-thumbs-down"></i>
                                                    </button>
                                                </a>
                                            @else
                                                <a href="{{route('comments.activate',$comment->id)}}">
                                                    <button type="button" data-toggle="tooltip"
                                                            title="activate comment"
                                                            class="btn btn-link btn-success btn-lg"
                                                            data-original-title="activate comment">
                                                        <i class="fa fa-thumbs-up"></i>
                                                    </button>
                                                </a>
                                            @endif

                                            <a href="{{route('comments.show',$comment->id)}}">
                                                <button type="button" data-toggle="tooltip" title="Show comment"
                                                        class="btn btn-link btn-primary btn-lg"
                                                        data-original-title="Show comment">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            </a>

                                            <a href="{{route('comments.destroy',$comment->id)}}" class="delete-confirm">
                                                <button type="button" data-toggle="tooltip" title="Delete comment"
                                                        class="btn btn-link btn-danger btn-lg"
                                                        data-original-title="Delete comment">
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
