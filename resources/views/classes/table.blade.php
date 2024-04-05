<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @if (count($classes))
        <table class="table table-bordered">
            <thead>
                <tr class="table-head">
                    <th style="width: 20%">Section</th>
                    <th style="width: 10%">Size</th>
                    <th style="width: 30%">Courses</th>
                    <th style="width: 10%">Units</th>
                    <th style="width: 20%">Available Rooms</th>
                    <th style="width: 10%">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($classes as $class)
                <tr>
                    <td>{{ $class->name }}</td>
                    <td>{{ $class->size }}</td>
                    <td>
                        @foreach ($academicPeriods as $period)
                            {{ $period->name }}
                            <?php $courses = $class->courses()->wherePivot('academic_period_id', $period->id)->get(); ?>
                            @if (count($courses))
                            <ul>
                            @foreach ($courses as $course)
                                <li>{{ $course->name }}</li>
                            @endforeach
                            </ul>
                            @else
                            <p>No courses added for this period</p>
                            @endif
                        @endforeach
                    </td>
                    <td>
                        <?php $courses = $class->courses()->wherePivot('academic_period_id', $period->id)->get(); ?>
                                                                
                        @if (count($courses))
                            @php
                                $totalUnits = $courses->sum('units');
                            @endphp

                            <p>{{ $totalUnits }}</p>
                        @endif
                    </td>
                    {{-- Available Rooms --}}
                    @php
                    // Get all rooms
                    $allRooms = \App\Models\Room::all()->pluck('name')->toArray();

                    // Get unavailable rooms
                    $unavailableRooms = $class->unavailable_rooms->pluck('name')->toArray();

                    // Get available rooms
                    $availableRooms = array_diff($allRooms, $unavailableRooms);
                    @endphp
                    <td>
                        @if (count($availableRooms))
                            <ul>
                                @foreach ($availableRooms as $room)
                                    <li>{{ $room }}</li>
                                @endforeach
                            </ul>
                        @else
                            None available
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-primary btn-sm resource-update-btn" data-id="{{ $class->id }}"><i class="fa fa-pencil"></i></button>
                        <button class="btn btn-danger btn-sm resource-delete-btn" data-id="{{ $class->id }}"><i class="fa fa-trash-o"></i></button>
                    </td>
                </tr>
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