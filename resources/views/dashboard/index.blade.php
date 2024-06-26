@extends('layouts.app')

@section('title')
Dashboard
@endsection

@section('content')
<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 page-container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 page-title">
            <h1><span class="fa fa-dashboard"></span> Dashboard</h1>
        </div>
    </div>

    <div class="page-body menubar">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row cards-container">
                    <?php $count = 1; ?>
                    @foreach ($data['cards'] as $card)
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> <!-- Change col-md-3 to col-md-4 -->
                        <div class="card card-{{ $count++ }}">
                            <div class="card-title">
                                <span class="pull-right icon fa fa-{{$card['icon'] }}"></span>
                                <h3>{{ $card['title'] }}</h3>
                            </div>

                            <div class="card-body">
                                <span>{{ $card['value'] }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        @if (Auth::user()->accesslevel == 100 || Auth::user()->accesslevel == 5)
            <div class="row" style="margin-top: 50px">
                <div class="col-lg-4 col-md-6 col-sm-8 col-xs-12 col-lg-offset-4 col-md-offset-3 col-sm-offset-2"> <!-- Change col-md-4 to col-md-6 and col-sm-4 to col-sm-8 -->
                    <button class="btn-primary timetable-btn btn-block" id="resource-add-button"><i class="fa fa-calendar"></i> Generate New Schedules</button>
                </div>
            </div>
        @endif
    </div>

    <div id="resource-container">
        @include('dashboard.timetables')
    </div>
</div>
@include('dashboard.modals')
@endsection

@section('scripts')
<script src="{{URL::asset('/js/dashboard/index.js')}}"></script>
@endsection