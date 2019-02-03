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
    <br>
    <div class="container-fluid d-flex">
        <div  style="width: 50%; padding: 20px; background-color: white; border-radius: 20px; margin: 5px;">
            <div class="d-flex justify-content-between">
                <h3>Candidates : Total ({{ $candidates->count()}})</h3>
                <div style="display: flex; ">
                    <button class="btn btn-primary" id="add_candidate" type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCandidateModal">Add Candidate</button>
                    <form style="margin: 0; margin-left: 10px;" action="/admin/candidates/deleteAll" method="POST" onsubmit="return validateMyForm('Delete all Candidates? This cannot be undone.');" >
                    {{method_field('DELETE')}}
                    <button class="btn btn-danger" type="submit">Delete All Candidates</button>
                </form>
                </div>

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
                        <th scope="col">Photo</th>
                        <th scope="col">Student No.</th>
                        <th scope="col">Name</th>
                        <th scope="col">Party List</th>
                        <th scope="col">Section</th>
                        <th scope="col">Position</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody >
                        @if($candidates->count() === 0)
                            <tr>
                                <td colspan="8">
                                    <div style="text-align: center;">No Record Found</div>
                                </td>
                            </tr>
                        @endif
                        @foreach ($candidates as $key => $candidate)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <th scope="row">
                                    <div class="mx-auto">
                                        <img style="width: 80px; height: auto; margin:auto; text-align: center;" src="/images/{{ $candidate->image_name }}">
                                    </div>
                                    
                                </th>
                                <td>
                                    {{ $candidate->student_id }}

                                </td>
                                <td>{{ $candidate->name }}</td>
                                <td>
                                    @if($candidate->partylist_id === 0)
                                        {{ 'Independent '}}
                                    @else
                                        {{ $candidate->partylist->name }}
                                    @endif
                                </td>
                                <td>{{ $candidate->section }}</td>
                                <td>{{ $candidate->position }}</td>
                                <td>
                                    <form onsubmit="return validateMyForm('Are you sure you want to delete this candidate?');" action="/admin/candidates/{{ $candidate->id }}" method="POST">
                                        {{method_field('DELETE')}}
                                        <button class="btn btn-danger" type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        
        </div>

        <div  style="width: 50%; padding: 20px; background-color: white; border-radius: 20px; margin: 5px;">
            <div class="d-flex justify-content-between" >
                <h3>Party List : Total ({{ $partylists->count()}})</h3>
                <div style="display: flex; ">
                    
                <button class="btn btn-primary" id="add_partylist" type="button" class="btn btn-primary" data-toggle="modal" data-target="#addPartyList">Add Party List</button>
                <form style="margin: 0; margin-left: 10px;" action="/admin/partylist/deleteAll" method="POST" onsubmit="return validateMyForm('Delete all Partylists? This cannot be undone.');" >
                    {{method_field('DELETE')}}
                    <button class="btn btn-danger" type="submit">Delete All Partylist</button>
                </form>
                </div>
                <!-- <button class="btn btn-primary">Add Party List</button> -->
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
                        <th scope="col">Party Name</th>
                        <th scope="col">Members</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody >
                        @if($partylists->count() === 0)
                            <tr>
                                <td colspan="6">
                                    <div style="text-align: center;">No Record Found</div>
                                </td>
                            </tr>
                        @endif
                        @foreach ($partylists as $key => $partylist)
                            <tr>
                            <th scope="row">{{ $key + 1}}</th>
                            <td>{{ $partylist->name }}</td>
                            <td>{{ $partylist->members()->count() }}</td>
                            <td>
                                <form action="/admin/partylist/{{ $partylist->id }}" method="POST">
                                    {{method_field('DELETE')}}
                                    <button  onclick="return validateMyForm('Deleting this partylist will make every member\'s partylist to Independent, continue?')" class="btn btn-danger" type="submit">Delete</button>
                                </form>
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
    <script type="text/javascript"  src="/js/candidate.js"></script>
    <script type="text/javascript" src=" /js/bootstrap/js/bootstrap.min.js"></script>
    
@endpush

<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCandidateModal">
  Launch demo modal
</button>
 -->
<!-- Modal -->
<div class="modal fade" id="addCandidateModal" tabindex="-1" role="dialog" aria-labelledby="addCandidateModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="/admin/candidates/store" method="POST" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCandidateModalLabel">Add Candidate</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <span>
                            <span class="btn btn-dark">
                                <label for="photo">Photo: </label>
                                <input type="file" name="photo" required>
                            </span>
                        </span>
                    </div>
                        <!-- <label for="student_id">Student No.</label> -->
                        <!-- <input type="text" class="form-control" id="student_id" placeholder="Enter Student No."> -->
                    
                    <div class="form-group">
                        <label for="student_id">Student No.</label>
                        <input type="text" class="form-control" id="student_id" placeholder="Enter Student No." name="student_id" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="partylist">PartyList</label>
                        <select class="form-control" id="partylist_id" required name="partylist_id">
                            <option value="0">Independent</option>
                            @foreach ($partylists as $partylist)
                                <option value="{{ $partylist->id }}">{{ $partylist->name }}</option>
                            @endforeach
                        </select>
                        <!-- <input type="text" class="form-control" id="partylist" placeholder="Enter PartyList"> -->
                    </div>
                    <div class="form-group">
                        <label for="section">Section</label>
                        <input type="text" class="form-control" id="section" placeholder="Enter Section" name="section" required>
                    </div>
                    <div class="form-group">
                        <label for="position">Position</label>
                        <select class="form-control" id="position" name="position"  required>
                            <option value="">-- Select Position--</option>
                            <option value="President">President</option>
                            <option value="Vice President">Vice President</option>
                            <option value="Secretary">Secretary</option>
                            <option value="Senator">Senator</option>
                            <option value="Governor">Governor</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Candidate</button>
                </div>
            </div>
        </form>
        
    </div>
</div>

<div class="modal fade" id="addPartyList" tabindex="-1" role="dialog" aria-labelledby="addPartyList" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="/admin/partylist/store" method="POST">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPartyListLabel">Add Partylist</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="partylist_name">PartyList Name</label>
                            <input type="text" class="form-control" id="partylist_name" placeholder="Enter PartyList Name" name="name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add PartyList</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
