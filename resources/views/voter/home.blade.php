
@extends('layout')


@push('styles')
    <!-- <link rel="stylesheet" type="text/css" href="/css/login.css"> -->

@endpush

@section('navbar')
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/admin">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/candidates">Candidates</a></li>
                </li>
                <li class="nav-item  active">
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
        <br>
        <h3>Voters Section</h3>
    </div>
    <div class="container">
        <div  style="padding: 20px;">
            <div class="d-flex justify-content-between">
                <h3>Registered Voters</h3>
            </div>
            <br>
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>

            @endif
            <div class="table-wrapper-scroll-y" style="
                                                display: block;
                                                max-height: 500px;
                                                overflow-y: auto;
                                                -ms-overflow-style: -ms-autohiding-scrollbar;
            ">
                <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th scope="col">Id</th>
                        <th scope="col">QR Code</th>
                        <th scope="col">Name</th>
                        <th scope="col">QR Code Id</th>
                        <th scope="col">QR Code Student Id</th>
                        <th scope="col">Vote Status</th>
                        <th scope="col">Mac Address</th>
                      </tr>
                    </thead>
                    <tbody >
                        @foreach ($voters as $voter)
                            <tr>
                                <th scope="row">{{ $voter->id }}</th>
                                <td>{{ $voter->qr_code }}</td>
                                <td>{{ $voter->name }}</td>
                                <td>{{ $voter->qr_code_id }}</td>
                                <td>{{ $voter->qr_code_student_id }}</td>
                                <td>{{ $voter->has_voted ? 'Done' : 'Not Voted' }}</td>
                                <td>{{ $voter->mac_address }}</td>
                                <!-- <td>
                                    <form action="/admin/voters/{{ $voter->id }}" method="POST">
                                        {{method_field('DELETE')}}
                                        <button class="btn btn-danger" type="submit">Delete</button>
                                    </form>
                                </td> -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        
        </div>
    </div>



@endsection

@push('scripts')

    <!-- <script type="text/javascript" src="/js/login.js"></script> -->
    
@endpush