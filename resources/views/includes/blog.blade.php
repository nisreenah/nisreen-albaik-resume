<div class="content-blocks blog">
    <section class="content">
        <div class="block-content">
            <h3 class="block-title">My Blog</h3>
            <div class="row">
                <div class="col-md-10 mx-auto">
                    @foreach($blogs as $blog)
                        <div class="post">
                        <div class="post-thumbnail">
                            <a class="open-post" href="{{route('post-single',$blog->id)}}">
                                <img src="{{asset('/images/blogs/'.$blog->image)}}" alt="">
                            </a>
                        </div>
                        <div class="post-title">
                            <a class="open-post" href="{{route('post-single',$blog->id)}}"><h2>{{$blog->en_title}}</h2></a>
                            <p class="post-info">
                                <span class="post-author">Posted by {{$blog->user->name}}</span>
                                <span class="slash"></span>
                                <span class="post-date">{{$blog->created_at}}</span>
                                <span class="slash"></span>
{{--                                <span class="post-catetory">Food</span>--}}
                            </p>
                        </div>
                        <div class="post-body">
                            <p>{{$blog->en_details}}</p>
                            <a class="btn open-post" href="{{route('post-single',$blog->id)}}">Read More</a>
                        </div>
                    </div>
                    @endforeach
                    <div class="text-center">
                        <ul class="pagination">
                            <li class="page-item disabled">
                              <a class="page-link" href="#" tabindex="-1">Previous</a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item active">
                              <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">4</a></li>
                            <li class="page-item">
                              <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
