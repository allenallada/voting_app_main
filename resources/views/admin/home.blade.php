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
            <br>
            <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#editInfo">Edit My Info</button>
            <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#manage_admin">Manage Admin Accounts</button>
            <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#manage_polling">Manage Polling Hours</button>
            <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#sen_no">Set Maximum number of Candidates</button>
        </div>    
        <div class="d-flex">
            <form action="/admin/export/summary" method="GET" class="m-1">
                <button class="btn btn-success" type="submit">Export Summary</button>
            </form>
            <form action="/admin/export/voter" method="GET" class="m-1">
                <button class="btn btn-success" id="add_candidate" type="submit">Export Voters</button>
            </form>
        </div>
        <br>
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

        @if (Session::get('error'))
            <div class="alert alert-danger" role="alert">
              {{Session::get('error')}}
            </div>
        @endif

        @if (Session::get('success'))
            <div class="alert alert-success" role="alert">
                {{Session::get('success')}}
            </div>
        @endif

        <div>
            <h3>President Candidate Vote Count</h3>
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
                        <th scope="col">Id</th>
                        <th scope="col">Student No.</th>
                        <th scope="col">Name</th>
                        <th scope="col">Party List</th>
                        <th scope="col">Section</th>
                        <th scope="col">Vote Count</th>
                      </tr>
                    </thead>
                    <tbody >
                        @if($PCandidates->count() === 0)
                            <tr>
                                <td colspan="6">
                                    <div style="text-align: center;">No Record Found</div>
                                </td>
                            </tr>
                        @endif
                        @foreach ($PCandidates as $key => $candidate)

                            <tr class="{{  $key === 0 ? 'bg-success' : '' }}">
                                <th scope="row"> {{ $candidate->id }}</th>
                                <td>{{ $candidate->student_id }}</td>
                                <td>{{ $candidate->name }}</td>
                                <td>
                                    @if($candidate->partylist_id === 0)
                                        {{ 'Independent '}}
                                    @else
                                        {{ $candidate->partylist->name }}
                                    @endif
                                </td>
                                <td>{{ $candidate->section }}</td>
                                <td>
                                    {{ $candidate->vote->count() }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <br>
        <br>
        <div>
            <h3>Vice President Candidate Vote Count</h3>
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
                        <th scope="col">Id</th>
                        <th scope="col">Student No.</th>
                        <th scope="col">Name</th>
                        <th scope="col">Party List</th>
                        <th scope="col">Section</th>
                        <th scope="col">Vote Count</th>
                      </tr>
                    </thead>
                    <tbody >
                        @if($VCandidates->count() === 0)
                            <tr>
                                <td colspan="6">
                                    <div style="text-align: center;">No Record Found</div>
                                </td>
                            </tr>
                        @endif
                        @foreach ($VCandidates as $key => $candidate)
                            <tr class="{{ $key === 0 ? 'bg-success' : '' }}">
                                <th scope="row">{{ $candidate->id }}</th>
                                <td>{{ $candidate->student_id }}</td>
                                <td>{{ $candidate->name }}</td>
                                <td>
                                    @if($candidate->partylist_id === 0)
                                        {{ 'Independent '}}
                                    @else
                                        {{ $candidate->partylist->name }}
                                    @endif
                                </td>
                                <td>{{ $candidate->section }}</td>
                                <td>
                                    {{ $candidate->vote->count() }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <br>
        <br>
        <div>
            <h3>Secretary Candidate Vote Count</h3>
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
                        <th scope="col">Id</th>
                        <th scope="col">Student No.</th>
                        <th scope="col">Name</th>
                        <th scope="col">Party List</th>
                        <th scope="col">Section</th>
                        <th scope="col">Vote Count</th>
                      </tr>
                    </thead>
                    <tbody >
                        @if($SCandidates->count() === 0)
                            <tr>
                                <td colspan="6">
                                    <div style="text-align: center;">No Record Found</div>
                                </td>
                            </tr>
                        @endif
                        @foreach ($SCandidates as $key => $candidate)
                            <tr class="{{  $key === 0 ? 'bg-success' : '' }}">
                                <th scope="row">{{ $candidate->id }}</th>
                                <td>{{ $candidate->student_id }}</td>
                                <td>{{ $candidate->name }}</td>
                                <td>
                                    @if($candidate->partylist_id === 0)
                                        {{ 'Independent '}}
                                    @else
                                        {{ $candidate->partylist->name }}
                                    @endif
                                </td>
                                <td>{{ $candidate->section }}</td>
                                <td>
                                    {{ $candidate->vote->count() }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <br>
        <div>
            <h3>Senator Candidate Vote Count (Max : {{ $setting->max_sen}})</h3>
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
                        <th scope="col">Id</th>
                        <th scope="col">Student No.</th>
                        <th scope="col">Name</th>
                        <th scope="col">Party List</th>
                        <th scope="col">Section</th>
                        <th scope="col">Vote Count</th>
                      </tr>
                    </thead>
                    <tbody >
                        @if($SenCandidates->count() <= $setting->max_sen)
                            <tr>
                                <td colspan="6">
                                    <div style="text-align: center;">No Record Found</div>
                                </td>
                            </tr>
                        @endif
                        @foreach ($SenCandidates as $key => $candidate)
                            <tr class="{{  $key === 0 ? 'bg-success' : '' }}">
                                <th scope="row">{{ $candidate->id }}</th>
                                <td>{{ $candidate->student_id }}</td>
                                <td>{{ $candidate->name }}</td>
                                <td>
                                    @if($candidate->partylist_id === 0)
                                        {{ 'Independent '}}
                                    @else
                                        {{ $candidate->partylist->name }}
                                    @endif
                                </td>
                                <td>{{ $candidate->section }}</td>
                                <td>
                                    {{ $candidate->vote->count() }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <br>
        <div>
            <h3>Governor Candidate Vote Count (Max : {{ $setting->max_gov}})</h3>
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
                        <th scope="col">Id</th>
                        <th scope="col">Student No.</th>
                        <th scope="col">Name</th>
                        <th scope="col">Party List</th>
                        <th scope="col">Section</th>
                        <th scope="col">Vote Count</th>
                      </tr>
                    </thead>
                    <tbody >
                        @if($SenCandidates->count() <= $setting->max_sen)
                            <tr>
                                <td colspan="6">
                                    <div style="text-align: center;">No Record Found</div>
                                </td>
                            </tr>
                        @endif
                        @foreach ($SenCandidates as $key => $candidate)
                            <tr class="{{  $key === 0 ? 'bg-success' : '' }}">
                                <th scope="row">{{ $candidate->id }}</th>
                                <td>{{ $candidate->student_id }}</td>
                                <td>{{ $candidate->name }}</td>
                                <td>
                                    @if($candidate->partylist_id === 0)
                                        {{ 'Independent '}}
                                    @else
                                        {{ $candidate->partylist->name }}
                                    @endif
                                </td>
                                <td>{{ $candidate->section }}</td>
                                <td>
                                    {{ $candidate->vote->count() }}
                                </td>
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
    <script type="text/javascript" src="/js/admin.js"></script>
    <script type="text/javascript" src=" /js/bootstrap/js/bootstrap.min.js"></script>
    
@endpush

<div class="modal fade" id="editInfo" tabindex="-1" role="dialog" aria-labelledby="editInfo" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="/admin/{{ session('user')->id}}/update" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editInfoLabel">Edit Your Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="student_id">Student Id</label>
                        <input type="text" class="form-control" id="student_id"  name="student_id" value="{{ session('user')->student_id}}" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name"  name="name" value="{{ session('user')->name}}"required>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username"  name="username" value="{{ session('user')->username}}" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Current Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Enter Current Password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" class="form-control" id="new_password" placeholder="Enter New Password" name="new_password">
                    </div>
                    <div class="form-group">
                        <label for="new_password_confirmation">Confirm Password</label>
                        <input type="password" class="form-control" id="new_password_confirmation" placeholder="Confirm New Password" name="new_password_confirmation">
                    </div>
                   
                </div>
                <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="manage_admin" tabindex="-1" role="dialog" aria-labelledby="manage_admin" aria-hidden="true">
        <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="manage_adminLabel">Manage Admin Accounts</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-group">
                            @foreach ($admins as $admin)
                                <li class="list-group-item d-flex justify-content-between">
                                    <p>{{$admin->name}} - {{$admin->position}}</p>
                                    <button onclick="deleteAdmin({{$admin->id}})" class="btn btn-danger"  data-toggle="modal" data-target="#delete_admin{{$admin->id}}" data-dismiss="modal" >Delete</button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
        </div>
    </div>

<div class="modal fade" id="manage_polling" tabindex="-1" role="dialog" aria-labelledby="manage_admin" aria-hidden="true">
    <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="manage_adminLabel">Manage Polling Hours</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <table class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th scope="col">Start Time</th>
                            <th scope="col">End Time</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @if($polls->count() === 0)
                            <tr>
                                <td colspan="3">
                                    <div style="text-align: center;">No Record Found</div>
                                </td>
                            </tr>
                            @endif
                            @foreach ($polls as $key => $poll)
                                <tr>
                                    <td>{{ date('M/d/Y h:i A', strtotime( $poll->start )) }}</td>
                                    <td>{{ date('M/d/Y h:i A', strtotime( $poll->end )) }}</td>
                                    <td>
                                        <form action="/admin/polls/{{$poll->id}}/delete" method="POST">
                                            <input type="" name="id" value="{{ $poll->id }}" hidden>
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>

                            @endforeach
                        </tbody>
                    </table>
                    <br>
                <form action="/admin/polls/store" method="POST">  
                    <div class="modal-body">
                         <h5>Add New Poll Hours</h5>
                            <div class="form-group">
                                <label for="student_id">Start-time and Date</label>
                                <input type="datetime-local" class="form-control" name="start_time" required>
                            </div>
                            <div class="form-group">
                                <label for="student_id">End-time and Date</label>
                                <input type="datetime-local" class="form-control" name="end_time" required>
                            </div>
                            <ul class="list-group">
                    </div>
                    <div class="modal-footer">
                         <button type="submit" class="btn btn-primary">Add</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        
    </div>
</div>

<div class="modal fade" id="sen_no" tabindex="-1" role="dialog" aria-labelledby="manage_admin" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="/admin/maximum" method="POST">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="manage_adminLabel">Maximum Candidates</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-group">
                            <label for="no_sen">Edit Maximum Senators</label>
                            <input type="number" class="form-control" id="no_sen" name="max_sen" value="{{ $setting->max_sen }}" min="1" required>
                        </ul>
                        <ul class="list-group">
                            <label for="no_sen">Edit Maximum Governors</label>
                            <input type="number" class="form-control" id="no_sen" name="max_gov" value="{{ $setting->max_gov }}" min="1" required>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@foreach ($admins as $admin)
    <div class="modal fade" id="delete_admin{{$admin->id}}" tabindex="-1" role="dialog" aria-labelledby="delete_admin{{$admin->id}}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="/admin/{{$admin->id}}/delete" class="confirmPassword" method="POST">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="delete_adminLabel">Enter Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="new_password_confirmation">Confirm Password</label>
                            <input type="password" class="form-control" id="new_password_confirmation" placeholder="Confirm Specific Admin Password" name="password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Confirm</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endforeach


