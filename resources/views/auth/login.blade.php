<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Students Schedule</title>
    <style>  
        @font-face {
            font-family: myFirstFont;
            src: url("../../fonts/OLD.ttf");
        }
    
        img {
            display: block;
            max-height: 85px;
            width: auto;
            height: auto;
            padding-left: 8px;
            
        }
    
        .header {
            /* background-color: #022B61; */
            background-color: #002e97;
            padding: 10px;
        }
    
        .schoolname2 {
            font-family: "Times New Roman";
            font-size: 25pt;
            color: #003147;
        }
    
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 30px;
            background: #002e97;
            padding-top: 5px;
            z-index: 9999;
        }
    
        .sis {
            text-align: right;
        }
    
        .sis #sisname {
            font-weight: bold;
            color: white;
        }
    
        .S1 {
            font-family: "Times New Roman";
            /* border: 1px solid black; */
            font-size:18pt;   
            margin-top: 30px;
            margin-bottom: 100px;
            margin-right: 150px;
            margin-left: 400px;
            
        }

        @media (max-width: 768px) {
            .S1 {
                margin-right: 20px;
                margin-left: 20px;
            }
        }
    </style>
    <!-- Styles -->
    @include('partials.styles')
    @yield('styles')

</head>
<body class="login-page ">
    <div class="container">
        <div class="row">
            <div class="container-fluid header" style >
                <div class="col-md-1 pull-left">
                    <img class="logo" src="{{ asset('images/pcuLogo.png') }}" alt="pcuLogo" />
                </div>
                <div class="col-md-8"><span class="schoolname">Philippine Christian University Dasma Campus </span>
                    <span class="address"><br>Sampaloc 1, City of Dasmariñas</span>
                    <span class="address"><br>Cavite, Philippines</span>
                </div>  
                {{-- <div class="col-md-3 sis"><span id="sisname">Scheduling System</span></div>
            </div> --}}
            <div class = "btn1 pull-right">
                <a href="loginMain" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">
                    <i class="fa fa-sign-in" aria-hidden="true"></i>
                    Sign In
                </a>
            </div>
        </div>
    </div>

    <div class="S1">
        <div class="position-relative">
            <div class="container">
                <div class="row">
                    <div class="col-md-8" style="margin-top:50px" >
                        <center>
                            <h4><p class="fw-semibold">Search for Students Schedule</p></h4>
                            <hr>
                        </center>
                        {{-- <form action="{{ route('web.find') }}" method="GET"> --}}
                        <form action="{{ route('web.find') }}" method="GET">
                            <div class="form-group">
                                <label for="">Enter keyword</label>
                                <input type="text" class="form-control" name="query" placeholder="Search here....."
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

                            @if(isset($timetables))
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Section Name</th>
                                            {{-- <th>Room</th> --}}
                                            <th style="width: 10%">Print</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($timetables) > 0)
                                            @foreach($timetables as $timetable)
                                                <tr>
                                                    <td>{{ $timetable->name }}</td>
                                                    <td>
                                                        @if($timetable->file_url)
                                                        <a href="{{ URL::to('/timetables/view/' . $timetable->id) }}"
                                                           class="btn btn-sm btn-primary"
                                                        data-id="{{ $timetable->id }}"><span class="fa fa-print"></span> View</a>
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
                    </div>

                </div>
            </div>
        </div>
    </div>
        
    {{-- @include('partials.scripts')
    @yield('scripts') --}}
</body>

</html>
