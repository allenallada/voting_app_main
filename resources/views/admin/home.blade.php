
@extends('layout')


@push('styles')
    <!-- <link rel="stylesheet" type="text/css" href="/css/login.css"> -->

@endpush

@section('navbar')
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="/admin">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/candidates">Candidates</a></li>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/voters">Voters</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0" action="/admin/logout" method="GET">
                <button class="btn btn-outline-danger my-2 my-sm-0" type="submit">Log Out</button>
            </form>
        </div>
    </nav>
@endsection

@section('content')
   
    <div class="container">
        <div class="jumbotron">
            <h3>Welcome Back {{ session('user')->name}}!</h3>
        </div>    
    </div>
    <!-- <div class="container">
        <h1>Voting App</h1>
        <br>
        <br>
        <h2>Login</h2>
        <br>

        @if (Session::get('success'))

        <div class="alert alert-success" role="alert">

          {{Session::get('success')}}

        </div>
        
        @endif

        <form>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="name" class="form-control" id="name" name="name" aria-describedby="emailHelp" placeholder="Enter Name" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a type="submit" class="btn btn-success" href="/admin/register">Register</a>
        </form>
    </div> -->

@endsection

@push('scripts')

    <!-- <script type="text/javascript" src="/js/login.js"></script> -->
    
@endpush