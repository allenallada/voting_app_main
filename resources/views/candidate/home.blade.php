
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
                <li class="nav-item  active">
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
    <br>
    <div class="container-fluid d-flex">
        <div  style="width: 50%; padding: 20px;">
            <div class="d-flex justify-content-between">
                <h3>Candidates</h3>
                <button class="btn btn-primary">Add Candidate</button>
            </div>
            <br>
            <div class="table-wrapper-scroll-y" style="
                                                display: block;
                                                max-height: 500px;
                                                overflow-y: auto;
                                                -ms-overflow-style: -ms-autohiding-scrollbar;
            ">
                <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                        <th scope="col">Handle</th>
                      </tr>
                    </thead>
                    <tbody >
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        
        </div>

        <div  style="width: 50%; padding: 20px;">
            <div class="d-flex justify-content-between" >
                <h3>Party List</h3>
                <button class="btn btn-primary">Add Party List</button>
            </div>
            <br>
            <div class="table-wrapper-scroll-y" style="
                                                display: block;
                                                max-height: 500px;
                                                overflow-y: auto;
                                                -ms-overflow-style: -ms-autohiding-scrollbar;
            ">
                <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th scope="col">no</th>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                        <th scope="col">Handle</th>
                      </tr>
                    </thead>
                    <tbody >
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
        </div>
        
    </div>    

@endsection

@push('scripts')

    <!-- <script type="text/javascript" src="/js/login.js"></script> -->
    
@endpush