<!doctype html>
<html lang="en">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" href="/css/style.css">
<link rel="stylesheet" href="/css/responsive.css">
<title>Hide Panel</title>
</head>
<body>
<section id="loginSection">
<div class="container">
<div class="row align-items-center text-center">
	
 <div class="col-md-6">
 	<h2 class="formTitle smdw">Log In</h2>
 <div class="login-img"><img src="/img/signIn.png" class="img-fluid" alt=""></div>
</div>
 <div class="col-md-6">
  <h2 class="formTitle smup">Log In</h2>
   @if(isset(Auth::user()->email))
    <script>window.location="/dashboard";</script>
   @endif

   @if ($message = Session::get('error'))
   <div class="alert alert-danger alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
   </div>
   @endif

  <form method="post" class="log-InUpForm" action="{{ url('/checklogin') }}">
    {{ csrf_field() }}
   <div class="form-group <?php if($errors->has('email')){ echo "errors"; } ?>" >
    <input type="text" class="form-control" aria-describedby="emailHelp" name="email" id="email" placeholder="your@email.com">
	@if($errors->has('email')) 
    <small class="emailHelp" class="form-error-text"> {{ $errors->first('email') }} </small>
    @endif
   </div>
   <div class="form-group <?php if($errors->has('password')){ echo "errors"; } ?>">
    <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="password">
	@if($errors->has('password')) 
    <small class="emailHelp" class="form-error-text"> {{ $errors->first('password') }} </small>
    @endif
   </div>
   <div class="form-btn-group">
   <!-- <button type="Submit" class="validate btn btn-secondary btn-block">Log In</button> -->
   <input type="submit" name="login" class="validate btn btn-secondary btn-block" value="Log In" />
   </div>
  </form>
 </div>
</div>
</section>
</body>
</html>
<span></span>
