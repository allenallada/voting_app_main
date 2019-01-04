
@extends('layout')


@push('styles')
    <!-- <link rel="stylesheet" type="text/css" href="/css/login.css"> -->

@endpush

@section('content')


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