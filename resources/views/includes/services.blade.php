<div class="block-content">
    <h3 class="block-title">Services</h3>
    <div class="row">
        @foreach($services as $service)
        <div class="col-md-4 col-sm-6 service">
            <div class="service-icon">
                <i class="{{$service->icon}}"></i>
{{--                <i class="ion-laptop"></i>--}}
            </div>
            <h4>{{$service->en_title}}</h4>
            <p>{{$service->en_details}}</p>
        </div>
        @endforeach
{{--        <div class="col-md-4 col-sm-6 service">--}}
{{--            <div class="service-icon">--}}
{{--                <i class="ion-pie-graph"></i>--}}
{{--            </div>--}}
{{--            <h4>App Development</h4>--}}
{{--            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet.</p>--}}
{{--        </div>--}}
{{--        <div class="col-md-4 col-sm-6 service">--}}
{{--            <div class="service-icon">--}}
{{--                <i class="ion-paintbucket"></i>--}}
{{--            </div>--}}
{{--            <h4>Graphic Design</h4>--}}
{{--            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet.</p>--}}
{{--        </div>--}}
{{--        <div class="col-md-4 col-sm-6 service">--}}
{{--            <div class="service-icon">--}}
{{--                <i class="ion-printer"></i>--}}
{{--            </div>--}}
{{--            <h4>Print Design</h4>--}}
{{--            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet.</p>--}}
{{--        </div>--}}
{{--        <div class="col-md-4 col-sm-6 service">--}}
{{--            <div class="service-icon">--}}
{{--                <i class="ion-qr-scanner"></i>--}}
{{--            </div>--}}
{{--            <h4>Graphic Design</h4>--}}
{{--            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet.</p>--}}
{{--        </div>--}}
{{--        <div class="col-md-4 col-sm-6 service">--}}
{{--            <div class="service-icon">--}}
{{--                <i class="ion-social-buffer"></i>--}}
{{--            </div>--}}
{{--            <h4>Print Design</h4>--}}
{{--            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet.</p>--}}
{{--        </div>--}}
    </div>
</div>
