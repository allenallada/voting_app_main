
@extends('layout')


@push('styles')
    <!-- <link rel="stylesheet" type="text/css" href="/css/register.css"> -->
    <!-- <script type="text/javascript" src="/js/register.js"></script> -->

@endpush

@section('content')


    <div class="container">
        <h1>Voting App</h1>
        <br>
        <br>
        <h2>Register Admin Account</h2>
        <br>

        <form id="form" method="POST" action="/admin/create" class="was-validated">

            <div class="form-group">
                <label for="student_id">Student Number</label>
                <input type="text" class="form-control {{ $errors->has('student_id') ? 'is-invalid' : '' }}" id="student_id" name="student_id" placeholder="Enter Student Number" value="{{ old('student_id') }}" required>
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name" name="name" placeholder="Enter Name" value="{{ old('name') }}" required>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="name" class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" id="username" name="username" value="{{ old('username') }}" placeholder="Enter Username" required>
            </div>
            <div class="form-group">
                <label for="username">Position</label>
                <select class="form-control {{ $errors->has('position') ? 'is-invalid' : '' }}" id="position" name="position" required>
                    <option value="" disabled selected>---Choose Position---</option>
                    <option value="President">President</option>
                    <option value="Vice President">Vice President</option>
                    <option value="Secretary">Secretary</option>
                </select> 
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" id="password" name="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="/" class="btn btn-primary">Cancel</a>

            @if ($errors->any())
            <br>
            <br>

            <div class="alert alert-danger" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>

            @endif
        </form>

        
    </div>

@endsection

@push('scripts')
    <!-- <link rel="stylesheet" type="text/css" href="/css/register.css"> -->
    <script type="text/javascript" src="/js/register.js"></script>

@endpush