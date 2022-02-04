<div class="block-content">
    <h3 class="block-title">Profile</h3>
    <h3 class="subheading">I'm a <strong>{{$profile->en_name}}</strong>
        from {{$profile->en_country}}. {{$profile->en_bio}}
    </h3>
    <p>
        {{$profile->en_summary}}
    </p>
    <div class="info-list row">
        <div class="col-sm-6"><span>Name : </span> {{$profile->en_name}}</div>
        <div class="col-sm-6"><span>Date of birth : </span> {{$profile->date_of_birth}} </div>
        <div class="col-sm-6"><span>Address : </span> {{$profile->en_address}}</div>
        <div class="col-sm-6"><span>Email : </span> {{$profile->email}}</div>
        <div class="col-sm-6"><span>Phone : </span> {{$profile->phone}}</div>
        <div class="col-sm-6"><span>Skype : </span> {{$profile->skype}}</div>
        <div class="col-sm-6"><span>Interest : </span> {{$profile->en_interest}}</div>
    </div>
{{--    <img class="sign" src="images/signature.png" alt="" />--}}
</div>
