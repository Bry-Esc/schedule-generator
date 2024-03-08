@extends('layouts.app')

@section('title')
Section
@endsection

@section('content')
<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 page-container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 page-title">
            <h1><span class="fa fa-home"></span> Section</h1>
        </div>
    </div>

    <div class="menubar">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="input-group">
                    <input type="text" class="form-control input-custom-height" placeholder="Enter a keyword to search" name="search_term">
        
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary input-custom-height" id="search-button"><i class="fa fa-search" title="Search"></i></button>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body" id="resource-container">
        @include('section.table')
    </div>
</div>

@include('section.modals')
@endsection

@section('scripts')
<script src="{{URL::asset('/js/section/index.js')}}"></script>
@endsection