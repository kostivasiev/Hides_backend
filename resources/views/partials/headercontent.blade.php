<!doctype html>
<html lang="en">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/responsive.css">
<title>Hide Dashboard</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container">
<a class="navbar-brand" href="#">
 Hide
</a>
<div class="dropdown  ml-auto">
 <button class="btn dropdown-toggle" type="button" id="profileBtb" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
 <i class="profileIcon"></i><span class="adminName"> @if(isset(Auth::user()->email)) {{ Auth::user()->name }} @endif</span></button>
 <div class="dropdown-menu" aria-labelledby="profileBtb">
  <a class="dropdown-item" href="{{ url('/logout') }}">
   Logout
  </a>
  <a class="dropdown-item" href="#">
   Another action
  </a>
  <a class="dropdown-item" href="#">
   Something else here
  </a>
 </div>
</div>
</nav>