<div class="block-content">
    <h3 class="block-title">Testimonials</h3>
    <div class="row">
        <div id="liontestimonial" class="owl-carousel owl-theme">
            @foreach($testimonials as $testimonial)
            <div class="item testimonials">
                <img class="responsive" style="object-fit: cover; width: 120px; height: 120px" src="{{ asset('images/testimonials/'.$testimonial->image) }}" alt="">
                <blockquote>{{$testimonial->en_comment}}
                    <p class="quote"><span>{{$testimonial->en_name}}</span> - {{$testimonial->en_position}}</p>
                </blockquote>
            </div>
            @endforeach

        </div>
    </div>
</div>
