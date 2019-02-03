
@extends('layout')


@push('styles')
    <link rel="stylesheet" type="text/css" href="/css/login.css">

@endpush

@section('content')
    <br>
    <br>
    <br>
    <br>

    <div class="container">
        <div class="jumbotron">
            <h1>Voting App</h1>
            <br>

            @if (Session::get('success'))

                <div class="alert alert-success" role="alert">

                  {{Session::get('success')}}

                </div>
            
            @endif


            <h2>Login</h2>
            <br>

            

            <form  action="/admin/login" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="username" class="form-control" id="username" name="username" aria-describedby="emailHelp" placeholder="Enter Name" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                <a  class="btn btn-success" type="submit"  href="/admin/register">Register</a>
            </form>
            <br>
            @if (Session::get('error'))
                <div class="alert alert-danger" role="alert">
                  {{Session::get('error')}}
                </div>
            @endif
        </div>
    </div>


@endsection

@push('scripts')

    <script type="text/javascript" src="/js/login.js"></script>
    
@endpush