@extends('layouts.app')

@section('title')
Rooms
@endsection

@section('content')
<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 page-container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 page-title">
            <h1><span class="fa fa-home"></span> Rooms</h1>
        </div>
    </div>

    <div class="menubar">
        {{-- @include('partials.menu_bar', ['buttonTitle' => 'Add New Room']) --}}
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="input-group">
                    <input type="text" class="form-control input-custom-height" placeholder="Enter Room to search" name="search_term">
        
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary input-custom-height" id="search-button"><i class="fa fa-search" title="Search"></i></button>
                    </span>
                </div>
            </div>
        
            <div class="col-md-2 col-sm-6 col-xs-12 col-md-offset-4">
                <button class="btn btn-md btn-primary btn-block" id="resource-add-button">
                    <span class="fa fa-plus"></span>
                    Add New Room
                </button>
            </div>
        </div>
    </div>

    <div class="page-body" id="resource-container">
        @include('rooms.table')
    </div>
</div>

@include('rooms.modals')
@endsection

@section('scripts')
<script src="{{URL::asset('/js/rooms/index.js')}}"></script>
@endsection