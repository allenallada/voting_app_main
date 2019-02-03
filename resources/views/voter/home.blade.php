
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
   <br>

    <div class="container-fluid">
        <div  style="padding: 20px; background-color: white; border-radius: 20px;">
            <div class="d-flex justify-content-left">
                <h3>Registered Voters : Total ({{$voters->count()}})</h3>
                <form action="/admin/voters/deleteAll" method="POST" style="margin-left: 20px;" onsubmit="return validateMyForm('Delete all voters and their votes? This cannot be undone.');">
                    {{method_field('DELETE')}}
                    <button class="btn btn-danger" type="submit">Delete All Voters</button>
                </form>
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
                        <th scope="col">Student Id</th>
                        <th scope="col">Vote Status</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody >
                        @if($voters->count() === 0)
                            <tr>
                                <td colspan="6">
                                    <div style="text-align: center;">No Record Found</div>
                                </td>
                            </tr>
                        @endif
                        @foreach ($voters as $key => $voter)
                            <tr>
                                <th scope="row"> {{ $key + 1 }}</th>
                                <td>{{ $voter->qr_code }}</td>
                                <td>{{ $voter->name }}</td>
                                <td>{{ $voter->qr_code_student_id }}</td>
                                <td style="{{ $voter->has_voted ?  "background-color: #66ff66;": null }}">{{ $voter->has_voted ? 'Done' : 'Not Voted' }}</td>
                                <td style="display: flex; justify-content: center;">
                                    <!-- {{ $voter->mac_address }} -->
                                    <form onsubmit="return validateMyForm('Reset this Voter\'s votes? This includes the Mac Address.');" action="/admin/voter/reset/{{$voter->id}}" method="POST">
                                        {{method_field('PATCH')}}
                                        <button {{ $voter->has_voted === 0 ? "disabled" : "" }} style="margin-left: 2px; margin-right: 2px;" class="btn btn-warning btn-sm" type="submit">Reset</button>
                                    </form>
                                    <form onsubmit="return validateMyForm('Delete this Voter and all it\'s votes?');" action="/admin/voter/delete/{{$voter->id}}" method="POST">
                                        {{method_field('DELETE')}}
                                        <button style="margin-left: 2px; margin-right: 2px;" class="btn btn-danger btn-sm"  type="submit">Delete</button>
                                    </form>
                                </td>
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
    <script type="text/javascript"  src="/js/candidate.js"></script>
    <!-- <script type="text/javascript" src="/js/login.js"></script> -->
    
@endpush