<div class="load-data">
    <div class="block-content">
        <div class="project-media row">
            <div id="lionslider" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    @foreach($portfolio->gallery as $key => $gallery)
                        <div class="carousel-item {{$key == 0 ? 'active' : ''}}">
                            <img class="d-block w-100" style="" src="{{asset('/images/portfolios/'.$gallery->image)}}" alt="First slide">
                        </div>
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#lionslider" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#lionslider" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        <div class="project-head">
            <h1 class="block-title">Project : {{$portfolio->en_name}}</h1>
            <div class="tags"><span>Category : </span> {{$portfolio->category->name}}</div>
            <div class="tags"><span>Client : </span> {{$portfolio->en_client}}</div>
            <div class="tags"><span>Completion : </span> {{$portfolio->completion}}</div>
            <div class="tags"><span>Role : </span> {{$portfolio->en_role}}</div>
        </div>
        <p class="project-description">
            {{$portfolio->en_details}}
        </p>
    </div>
{{--    <div class="row text-center">--}}
{{--        <div class="col-md-12 btn-email">--}}
{{--            <a class="btn lowercase">{{$profile->email}}</a>--}}
{{--        </div>--}}
{{--    </div>--}}

    <script>
        $('#close-project').on('click', function() {
            $('.content-blocks.pop').removeClass('showx');
            $('.inline-menu-container').addClass('showx');
            $('.content-blocks.pop section').empty();
        });
    </script>
</div>
