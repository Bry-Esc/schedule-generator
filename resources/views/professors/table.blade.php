<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @if (count($professors))
            <table class="table table-bordered">
                <thead>
                    <tr class="table-head">
                        <th style="width: 12%">Name</th>
                        <th style="width: 10%">Department</th>
                        <th style="width: 26%">Courses Taught</th>
                        <th style="width: 20%">Employee Status</th>
                        <th style="width: 20%">Available Periods</th>
                        {{-- <th style="width: 20%">Unavailable Periods</th> --}}
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($professors as $professor)
                    <tr>
                        <td>{{ $professor->name }}</td>
                        <td>{{$professor->department}}</td>
                        <td>
                            @if (count($professor->courses))
                                <ul>
                                    @foreach ($professor->courses as $course)
                                    <li>{{ $course->course_code . " " . $course->name }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p>No courses added yet</p>
                            @endif
                        </td>
                        <td>{{$professor->employment_status}}</td>
                        <td>
                            @php
                                // Get all days
                                $allDays = \App\Models\Day::all()->pluck('name')->toArray();

                                // Remove 'Sunday' from the array
                                $allDays = array_filter($allDays, function($day) {
                                    return $day !== 'Sunday';
                                });

                                // Get unavailable days
                                $unavailableDays = $professor->unavailable_timeslots->pluck('day.name')->toArray();

                                // Get available days
                                $availableDays = array_diff($allDays, $unavailableDays);
                            @endphp

                            @if (count($availableDays))
                                <ul>
                                    @foreach ($availableDays as $day)
                                        <li>{{ $day }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p>All days are unavailable</p>
                            @endif
                            
                            {{-- @if (count($professor->unavailable_timeslots))
                                <ul>
                                    @foreach ($professor->unavailable_timeslots as $period)
                                        <li>{{ $period->day->name}}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p>No unavailable periods</p>
                            @endif --}}
                        </td>
                        {{-- <td>
                            @if (count($professor->unavailable_timeslots))
                                <ul>
                                    @foreach ($professor->unavailable_timeslots as $period)
                                        <li>{{ $period->day->name}}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p>No unavailable periods</p>
                            @endif
                        </td> --}}
                        <td>
                            <button class="btn btn-primary btn-sm resource-update-btn" data-id="{{ $professor->id }}"><i class="fa fa-pencil"></i></button>
                            <button class="btn btn-danger btn-sm resource-delete-btn" data-id="{{ $professor->id }}"><i class="fa fa-trash-o"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div id="pagination">
                {!!
                    $professors->render()
                !!}
            </div>
        @else
            <div class="no-data text-center">
                <p>No matching data was found</p>
            </div>
        @endif
    </div>
</div>