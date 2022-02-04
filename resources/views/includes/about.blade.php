<div class="content-blocks about">

    <section class="content" id="about">

        @include('includes.profile')

        @include('includes.skills')

        @include('includes.experience')

        @include('includes.education')

        @include('includes.services')

        @include('includes.testimonials')

        <div class="row text-center">
            <div class="col-md-12 btn-email">
                <a href="mailto:{{$profile->email}}" class="btn lowercase">{{$profile->email}}</a>
            </div>
        </div>

    </section>
</div>
