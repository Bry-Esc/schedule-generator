<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @if (count($classes))
        <table class="table table-bordered">
            <thead>
                <tr class="table-head">
                    {{-- <th style="width: 20%">School Year</th> --}}
                    <th style="width: 20%">Section</th>
                    <th style="width: 20%">Academic Periods</th>
                    <th style="width: 30%">Subject Title</th>
                    <th style="width: 10%">Units</th>
                    <th style="width: 10%">Available Rooms</th> {{-- !! Rooms Still Unavailable !! --}}
                    <th style="width: 30%">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($classes as $class)
                    @foreach ($academicPeriods as $period)
                        <tr>
                            {{-- Section --}}
                            <td>{{ $class->name }}</td>

                            {{-- Academic Periods --}}
                            <td>
                                {{ $period->name }}
                                <?php $courses = $class->courses()->wherePivot('academic_period_id', $period->id)->get(); ?>
                            </td>

                            {{-- Subject Title --}}
                            <td>
                                {{-- {{ $period->name }} --}}
                                <?php $courses = $class->courses()->wherePivot('academic_period_id', $period->id)->get(); ?>
                                
                                @if (count($courses))
                                <ul>
                                    @foreach ($courses as $course)
                                        <li>{{ $course->course_code . " " . $course->name }}</li>
                                    @endforeach
                                </ul>
                                @else
                                    <p>No courses added for this period</p>
                                @endif
                            </td>

                            {{-- Units --}}
                            <td>
                                <?php $courses = $class->courses()->wherePivot('academic_period_id', $period->id)->get(); ?>
                                                                
                                @if (count($courses))
                                    @php
                                        $totalUnits = $courses->sum('units');
                                    @endphp

                                    <p>{{ $totalUnits }}</p>
                                @endif
                            </td>

                            <td>
                                @if (count($class->unavailable_rooms))
                                <ul>
                                    @foreach ($class->unavailable_rooms as $room)
                                        <li>{{ $room->name }}</li>
                                    @endforeach
                                </ul>
                                @else
                                None specified
                                @endif
                            </td>
                            
                            <td>
                            <button class="btn btn-primary btn-sm resource-update-btn" data-id="{{ $class->id }}"><i class="fa fa-pencil"></i></button>
                            <button class="btn btn-danger btn-sm resource-delete-btn" data-id="{{ $class->id }}"><i class="fa fa-trash-o"></i></button></td>
                        </tr>
                    @endforeach

                @endforeach
            </tbody>
        </table>
         <div id="pagination">
            {!!
                $classes->render()
            !!}
        </div>
        @else
        <div class="no-data text-center">
            <p>No matching data was found</p>
        </div>
        @endif
    </div>
</div>