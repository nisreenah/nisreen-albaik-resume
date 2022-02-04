@extends('admin.layouts.master')

@section('title')
    All Portfolio
@endsection

@section('styles')
    <style>
        .gallery-container h1 {
            text-align: center;
            margin-top: 70px;
            font-family: 'Droid Sans', sans-serif;
            font-weight: bold;
            color: #58595a;
        }

        .gallery-container p.page-description {
            text-align: center;
            margin: 30px auto;
            font-size: 18px;
            color: #85878c;
        }

        /* Styles for the gallery */

        .tz-gallery {
            padding: 40px;
        }

        .tz-gallery .thumbnail {
            padding: 0;
            margin-bottom: 30px;
            /* border: none; */
            border: 1px solid #383c40;
        }

        .tz-gallery img {
            border-radius: 2px;
            width: 100%
        }

        .tz-gallery .caption {
            padding: 26px 30px;
            text-align: center;
        }

        .tz-gallery .caption h3 {
            font-size: 14px;
            font-weight: bold;
            margin-top: 0;
        }

        .tz-gallery .caption p {
            font-size: 12px;
            color: #7b7d7d;
            margin: 0;
        }

        .baguetteBox-button {
            background-color: transparent !important;
        }
    </style>

@endsection

@section('content')

    <div class="page-inner">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{$portfolio->en_name}} Gallery</div>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                            Add a new image to the gallery
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add a new image to the gallery</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>


                                <form action="{{route('portfolio.gallery.store')}}" method="POST" class="form-control" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <input type="hidden" name="portfolio_id" value="{{$portfolio->id}}">
                                        <input type="file" name="image">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                                    </div>

                                </form>



                            </div>
                            </div>
                        </div>


                    </div>
                    <div class="card-body">

                        <div class="container gallery-container">

                            <div class="tz-gallery">

                                <div class="row">
                                    @foreach($gallery as $album_image)
                                    <div class="col-sm-6 col-md-4">
                                        <div class="thumbnail">
                                            <a class="lightbox" href="#">
                                                 <img src="{{ asset('/images/portfolios/'.$album_image->image) }}" alt="Park">
{{--                                                <img src="https://picsum.photos/800/600/?random" alt="Park">--}}
                                            </a>
                                            <div class="caption">

                                                <p>Created At : {{$album_image->created_at->format('Y-m-d')}}</p>

                                                <form action="{{route('portfolio.gallery.delete',$album_image->id)}}" method="POST">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="submit" class="btn btn-sm btn-danger" >Delete</button>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                    @endforeach


                                </div>

                            </div>

                        </div>

                    </div>


                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
@endsection
