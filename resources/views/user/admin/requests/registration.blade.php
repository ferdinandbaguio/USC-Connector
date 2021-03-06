@extends('_layouts.admin')

@section('styles')

<link rel="stylesheet" href="{{ asset('css/extra/vendors/DataTables/datatables.min.css') }}" />

@endsection

@section('title')

User Registration

@endsection

@section('content')

<div class="ibox">
    <div class="ibox-head">
        @if($currentStatus == 'Denied')
            <div class="ibox-title text-muted">
                Denied Requests
            </div>
        @else
            <div class="ibox-title text-warning">
                Pending Requests
            </div>
        @endif
        {!! Form::open(['route' => ['registration.index','Filtering'], 'method' => 'GET', 'class' => 'form-inline']) !!} 
            {{ Form::select('currentStatus', ['Pending' => 'Pending', 'Denied' => 'Denied'], $currentStatus, 
            ['class' => 'form-control', 'style' => 'height: 30px;padding-top: 2px;']) }}
            &nbsp;
            {{ Form::submit('Change', ['class' => 'btn btn-primary', 'style' => 'display:inline-block;']) }}
        {!! Form::close() !!}
    </div>
    <div class="ibox-body">
    <table class="table table-striped table-bordered table-hover" id="example-table" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>ID Number</th>
                <th>Name</th>
                <th>Type</th>
                <th>Sex</th>
                <th>Email Address</th>
                <th>Option</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>ID Number</th>
                <th>Name</th>
                <th>Type</th>
                <th>Sex</th>
                <th>Email Address</th>
                <th>Option</th>
            </tr>
        </tfoot>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->idnumber }}</td>
                <td>{{ $user->full_name }}</td>
                <td>{{ $user->userType }}</td>
                <td>{{ $user->sex }}</td>
                <td>{{ $user->email }}</td>
                {{-- OPTIONS --}}
                <td>
                    @if($users[0]->userStatus == 'Denied')
                        {{-- Pending --}}
                        <span data-toggle="modal" data-target="#pend" data-id="{{ $user->id }}">
                            <button class="btn btn-warning btn-xs" data-toggle="tooltip" data-original-title="Approve">   
                                <i class="ti-minus"></i>                              
                            </button>
                        </span>
                    @else
                        {{-- Approve --}}
                        <span data-toggle="modal" data-target="#approve" data-id="{{ $user->id }}">
                            <button class="btn btn-success btn-xs" data-toggle="tooltip" data-original-title="Approve">   
                                <i class="ti-check"></i>                              
                            </button>
                        </span>

                        {{-- Deny --}}
                        <span data-toggle="modal" data-target="#deny" data-id="{{ $user->id }}">
                            <button class="btn btn-muted btn-xs" data-toggle="tooltip" data-original-title="Deny">   
                                <i class="ti-close"></i>                              
                            </button>
                        </span>
                    @endif

                    {{-- Edit Request --}}
                    <span   data-toggle="modal"                 data-target="#edit-request"           
                            data-id="{{ $user->id }}"           data-status="{{ $user->userStatus}}"
                            data-fn="{{ $user->firstName }}"    data-mn="{{ $user->middleName }}"   
                            data-ln="{{ $user->lastName }}"     data-type="{{ $user->userType }}"   
                            data-idnum="{{ $user->idnumber }}"  data-sex="{{ $user->sex }}"         
                            data-email="{{ $user->email }}">
                        <button class="btn btn-info btn-xs" data-toggle="tooltip" data-original-title="Edit">
                            <i class="ti-pencil"></i>                                
                        </button>
                    </span>

                    {{-- Delete --}}
                    <span data-toggle="modal" data-target="#delete" data-id="{{ $user->id }}">
                        <button class="btn btn-danger btn-xs" data-toggle="tooltip" data-original-title="Delete">   
                            <i class="ti-trash"></i>                              
                        </button>
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="edit-request" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog" role="document">
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">Editing User Request</span></h4>
    </div>
    {!! Form::open(['route' => ['registration.update','Updating'], 'method' => 'PATCH', 
                    'style' => 'display:inline-block;']) !!}
    @csrf
    <div class="modal-body">
            @include('_inc.admin.userEditRequestModal')
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        {{Form::submit('Save Changes', ['class' => 'btn btn-primary'])}}
    </div>
    {!! Form::close() !!}
</div>
</div>
</div>
  
<!-- Delete Modal -->
<div class="modal modal-danger fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog" role="document">
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title text-center" id="myModalLabel">Delete Confirmation</span></h4>
    </div>
    {!! Form::open(['route' => ['registration.destroy','Destroying'], 'method' => 'DELETE', 
                    'style' => 'display:inline-block;']) !!}
    @csrf
    <div class="modal-body">
        <p class="text-center">
            Are you sure you want to delete this?
        </p>
        {{ Form::hidden('id', '', array('id' => 'id')) }}
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-mute" data-dismiss="modal">No, Cancel</button>
        {{Form::submit('Yes, Delete', ['class' => 'btn btn-danger'])}}
    </div>
    {!! Form::close() !!}
</div>
</div>
</div>

<!-- Approve Modal -->
<div class="modal modal-danger fade" id="approve" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog" role="document">
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title text-center" id="myModalLabel">Approve Confirmation</span></h4>
    </div>
    {!! Form::open(['route' => ['registration.update','updating'], 'method' => 'PATCH', 
                    'style' => 'display:inline-block;']) !!}
    @csrf
    <div class="modal-body">
        <p class="text-center">
            Are you sure you want to approve this?
        </p>
        {{ Form::hidden('id', '', array('id' => 'id')) }}
        {{ Form::hidden('action', 'Approved') }}
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-mute" data-dismiss="modal">No, Cancel</button>
        {{Form::submit('Yes, Approve', ['class' => 'btn btn-success'])}}
    </div>
    {!! Form::close() !!}
</div>
</div>
</div>

<!-- Pend Modal -->
<div class="modal modal-danger fade" id="pend" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog" role="document">
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title text-center" id="myModalLabel">Pend Confirmation</span></h4>
    </div>
    {!! Form::open(['route' => ['registration.update','updating'], 'method' => 'PATCH', 
                    'style' => 'display:inline-block;']) !!}
    @csrf
    <div class="modal-body">
        <p class="text-center">
            Are you sure you want to pend this?
        </p>
        {{ Form::hidden('id', '', array('id' => 'id')) }}
        {{ Form::hidden('action', 'Pending') }}
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-mute" data-dismiss="modal">No, Cancel</button>
        {{Form::submit('Yes, Pend it', ['class' => 'btn btn-warning'])}}
    </div>
    {!! Form::close() !!}
</div>
</div>
</div>

<!-- Deny Modal -->
<div class="modal modal-danger fade" id="deny" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog" role="document">
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title text-center" id="myModalLabel">Deny Confirmation</span></h4>
    </div>
    {!! Form::open(['route' => ['registration.update','updating'], 'method' => 'PATCH', 
                    'style' => 'display:inline-block;']) !!}
    @csrf
    <div class="modal-body">
        <p class="text-center">
            Are you sure you want to deny this?
        </p>
        {{ Form::hidden('id', '', array('id' => 'id')) }}
        {{ Form::hidden('action', 'Denied') }}
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-mute" data-dismiss="modal">No, Cancel</button>
        {{Form::submit('Yes, Deny', ['class' => 'btn btn-danger'])}}
    </div>
    {!! Form::close() !!}
</div>
</div>
</div>


@endsection

@section('scripts')

<script type="text/javascript" src="{{ asset('js/unique/crud_user.js') }}"></script>
<script type="text/javascript" src="{{ asset('css/extra/vendors/DataTables/datatables.min.js') }}"></script>

@endsection