@extends('layouts.app')

@section('title')
Professors
@endsection

@section('content')
<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 page-container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 page-title">
            <h1><i class="fa fa-calendar" aria-hidden="true"></i> View Professor Schedules</h1>
        </div>
    </div>

    {{-- <div class="form-group menubar">
        <form action="{{ route('web.find') }}" method="get">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="input-group">
                            <input type="text" class="form-control input-custom-height" placeholder="Enter a Professor to search" name="query"
                                value="{{ request()->input('query') }}">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary input-custom-height" id="search-button"><i class="fa fa-search" title="Search"></i></button>
                            </span>
                            <span class="text-danger">
                                @error('query')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                </div>
        </form>
    </div> --}}
    <form action="{{ route('web.findProfSched') }}" method="GET">
        <div class="form-group">
            <label for=""></label>
            <input type="text" class="form-control" name="query" placeholder="Enter a Professor to search"
                value="{{ request()->input('query') }}">
            <span class="text-danger">
                @error('query')
                    {{ $message }}
                @enderror
            </span>
        </div>
        <div class="form-group"> 
            <button type="submit" class="btn btn-primary">Search</button>
        </div>

        @if(isset($professor_scheds))
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Professor Name</th>
                        {{-- <th>Room</th> --}}
                        <th style="width: 10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($professor_scheds) > 0)
                        @foreach($professor_scheds as $professor_sched)
                            <tr>
                                <td>{{ $professor_sched->name }}</td>
                                <td>
                                    @if($professor_sched->file_url)
                                        <a class="btn-view btn btn-sm btn-primary" data-id="{{ $professor_sched->id }}">
                                            <i class="fa fa-eye" aria-hidden="true"></i> View
                                        </a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                {{-- <td>
                                    @if (isset($professor->timeslots))
                                        <ul>
                                            <li>{{ $timeslot->time }}</li>
                                        </ul>
                                    @else
                                        <p>No unavailable Time</p>
                                    @endif
                                </td> --}}
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>No result found!</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        @endif
    </form>

    <div id="profSchedDisplay"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var viewButtons = document.querySelectorAll('.btn-view');

            viewButtons.forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault();

                    var id = this.dataset.id;

                    fetch('/timetables/renderProfSched/' + id)
                        .then(response => response.text())
                        .then(data => {
                            document.getElementById('profSchedDisplay').innerHTML = data;
                        });
                });
            });
        });
    </script>  

</div>

@endsection

@section('scripts')
<script src="{{URL::asset('/js/professors/index.js')}}"></script>
@endsection