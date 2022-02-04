@extends('admin.layouts.master')

@section('title')
   Desplay Message : {{$contact_us->name}}
@endsection

@section('styles')
@endsection

@section('content')
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">  Desplay Message : {{$contact_us->name}} </div>
                    </div>
                    
                    <div class="col-md-12">
                        <ul class="timeline">
                            <li>
                                <div class="timeline-panel">
                                    <div class="timeline-heading">
                                        <h4 class="timeline-title">Desplay Message From {{$contact_us->email}}</h4>
                                        <p><small class="text-muted"><i class="flaticon-message"></i> {{$contact_us->created_at->diffForHumans() }} by {{$contact_us->name}}</small></p>
                                    </div>
                                    <div class="timeline-body">
                                        <p>{{$contact_us->message}}</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
