@extends('layouts.app')

@section('title')
Classes
@endsection

@section('content')
<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 page-container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 page-title">
            <h1><span class="fa fa-users"></span> Curriculum</h1>
        </div>
    </div>

    <div class="menubar">
        {{-- @include('partials.menu_bar', ['buttonTitle' => 'Add New Curriculum']) --}}
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="input-group">
                    <input type="text" class="form-control input-custom-height" placeholder="Enter section to search" name="search_term">
        
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary input-custom-height" id="search-button"><i class="fa fa-search" title="Search"></i></button>
                    </span>
                </div>
            </div>
        
            <div class="col-md-2 col-sm-6 col-xs-12 col-md-offset-4">
                <button class="btn btn-md btn-primary btn-block" id="resource-add-button">
                    <span class="fa fa-plus"></span>
                    Add New Curriculum
                </button>
            </div>
        </div>
    </div>

    <div class="page-body" id="resource-container">
        @include('classes.table')
    </div>
</div>

@include('classes.modals')
@endsection

@section('scripts')
<script src="{{URL::asset('/js/classes/index.js')}}"></script>
@endsection