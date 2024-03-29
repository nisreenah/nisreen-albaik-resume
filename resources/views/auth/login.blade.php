<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Login</title>

    <link rel="shortcut icon" href=""/>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

    <style>
        body,html {
            background-image: url('https://i.imgur.com/xhiRfL6.jpg');
            height: 100%;
        }

        #profile-img {
            height:180px;
        }
        .h-80 {
            height: 80% !important;
        }
    </style>
</head>

<body>
<div class="container h-80">
    <div class="row align-items-center h-100">
        <div class="col-3 mx-auto">
            <div class="text-center">
                <img id="profile-img" class="rounded-circle profile-img-card" src="https://i.imgur.com/6b6psnA.png" />
                <p id="profile-name" class="profile-name-card"></p>
                <form action="{{route('login')}}" method="POST" class="form-signin">
                    @csrf
                    <input type="text" name="email" id="email" class="form-control form-group" placeholder="Email" required autofocus>
                    <input type="password" name="password" id="inputPassword" class="form-control form-group" placeholder="Password" required autofocus>
                    <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Login</button>
                </form><!-- /form -->
            </div>
        </div>
    </div>
</div>

<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>

</html>
