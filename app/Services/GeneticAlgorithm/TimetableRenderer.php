<?php

namespace App\Services\GeneticAlgorithm;

use App\Models\Day as DayModel;
use App\Models\Room as RoomModel;
use App\Models\Course as CourseModel;
use App\Models\Timeslot as TimeslotModel;
use App\Models\CollegeClass as CollegeClassModel;
use App\Models\Professor as ProfessorModel;
use Illuminate\Support\Facades\Storage;
use App\Models\Professor;

class TimetableRenderer
{
    /**
     * Create a new instance of this class
     *
     * @param App\Models\Timetable Timetable whose data we are rendering
     */

    private $timetable;

    public function __construct($timetable)
    {
        $this->timetable = $timetable;
    }

    /**
     * Generate HTML layout files out of the timetable data
     *
     * Chromosome interpretation is as follows
     * Timeslot, Room, Professor
     *
     */
    
    public function render()
    {
        // Split the chromosome and scheme strings into arrays
        $chromosome = explode(",", $this->timetable->chromosome);
        $scheme = explode(",", $this->timetable->scheme);

        // Generate data based on the chromosome and scheme
        $data = $this->generateData($chromosome, $scheme);

        // Get all days, timeslots, and classes
        $days = $this->timetable->days()->orderBy('id', 'ASC')->get();
        $timeslots = TimeslotModel::orderBy('rank', 'ASC')->get();
        $classes = CollegeClassModel::all();

        // Define the template for the timetable
        $tableTemplate = '<div class="{TITLE}">
    <h3 class="text-center">{TITLE}</h3>
    <div style="page-break-after: always">
        <table class="table table-bordered">
            <thead>
                {HEADING}
            </thead>
            <tbody>
                {BODY}
            </tbody>
        </table>
    </div>
</div>';

        $content = "";
        
        $psContent = "";

        // Loop through each class
        foreach ($classes as $class) {
            // Build the header row
            $header = "<tr class='table-head'>";
            $header .= "<td>Timeslots</td>";

            foreach ($days as $day) {
                $header .= "\t<td>" . strtoupper($day->short_name) . "</td>";
            }

            $header .= "</tr>";

            $body = "";

            // Loop through each timeslot
            foreach ($timeslots as $timeslot) {
                $body .= "<tr><td>" . $timeslot->time . "</td>";
                // Loop through each day
                foreach ($days as $day) {
                    // Check if there is data for this timeslot
                    if (isset($data[$class->id][$day->name][$timeslot->time])) {
                        $body .= "<td class='text-center'>";
                        $slotData = $data[$class->id][$day->name][$timeslot->time];
                        $courseCode = $slotData['course_code'];
                        $courseName = $slotData['course_name'];
                        $professor = $slotData['professor'];
                        $room = $slotData['room'];

                        // Add the course code, room, and professor to the cell
                        $body .= "<span class='course_code'>{$courseCode}</span><br />";
                        $body .= "<span class='course_name'>{$courseName}</span><br />";
                        $body .= "<span class='room pull-left'>{$room}</span>";
                        $body .= "<span class='professor pull-right'>{$professor}</span>";

                        $body .= "</td>";
                    } else {
                        // If there is no data for this timeslot, add an empty cell
                        $body .= "<td></td>";
                    }
                }
                $body .= "</tr>";
            }
            
            // Build the section header row
            $sHeader = "<tr class='table-head'>";
            $sHeader .= "<td>Timeslots</td>";

            foreach ($days as $day) {
                $sHeader .= "\t<td>" . strtoupper($day->short_name) . "</td>";
            }

            $sHeader .= "</tr>";

            $sBody = "";

            // Build the section row
            foreach ($timeslots as $timeslot) {
                $sContent = "";
                $sBody .= "<tr><td>" . $timeslot->time . "</td>";
                // Loop through each day
                foreach ($days as $day) {
                    // Check if there is data for this timeslot
                    if (isset($data[$class->id][$day->name][$timeslot->time])) {
                        $sBody .= "<td class='text-center'>";
                        $slotData = $data[$class->id][$day->name][$timeslot->time];
                        $courseCode = $slotData['course_code'];
                        $courseName = $slotData['course_name'];
                        $professor = $slotData['professor'];
                        $room = $slotData['room'];

                        // Add the course code, room, and professor to the cell
                        $sBody .= "<span class='course_code'>{$courseCode}</span><br />";
                        $sBody .= "<span class='course_name'>{$courseName}</span><br />";
                        $sBody .= "<span class='room pull-left'>{$room}</span>";
                        $sBody .= "<span class='professor pull-right'>{$professor}</span>";

                        $sBody .= "</td>";
                    } else {
                        // If there is no data for this timeslot, add an empty cell
                        $sBody .= "<td></td>";
                    }
                }
                $sBody .= "</tr>";

                $title = $class->name;
                $sContent .= str_replace(['{TITLE}', '{HEADING}', '{BODY}'], [$title, $header, $body], $tableTemplate);
                $sPath = 'public/sections/' . $title . '.html';
                
                Storage::put($sPath, $sContent);
            }

            // Replace the placeholders in the template with the actual data
            $title = $class->name;
            $content .= str_replace(['{TITLE}', '{HEADING}', '{BODY}'], [$title, $header, $body], $tableTemplate);

            // Save the generated timetable to a file
            $path = 'public/timetables/timetable_' . $this->timetable->id . '.html';
            Storage::put($path, $content);

            // Update the timetable's file URL
            $this->timetable->update([
                'file_url' => $path
            ]);
        } 
    }
    /**
     * Get an associative array with data for constructing timetable
     *
     * @param array $chromosome Timetable chromosome
     * @param array $scheme Mapping for reading chromosome
     * @return array Timetable data
     */
    public function generateData($chromosome, $scheme)
    {
        // Initialize empty data array
        $data = [];
        $schemeIndex = 0;
        $chromosomeIndex = 0;
        $groupId = null;

        // Loop through the chromosome array
        while ($chromosomeIndex < count($chromosome)) {
            // Loop through the scheme array until a group ID is found
            while ($scheme[$schemeIndex][0] == 'G') {
                $groupId = substr($scheme[$schemeIndex], 1);
                $schemeIndex += 1;
            }

            // Get the course ID from the scheme array
            $courseId = $scheme[$schemeIndex];

            // Find the class and course models
            $class = CollegeClassModel::find($groupId);
            $course = CourseModel::find($courseId);

            // Get the timeslot, room, and professor genes from the chromosome array
            $timeslotGene = $chromosome[$chromosomeIndex];
            $roomGene = $chromosome[$chromosomeIndex + 1];
            $professorGene = $chromosome[$chromosomeIndex + 2];

            // Extract the day and timeslot IDs from the timeslot gene
            $matches = [];
            preg_match('/D(\d*)T(\d*)/', $timeslotGene, $matches);

            $dayId = $matches[1];
            $timeslotId = $matches[2];

            // Find the day, timeslot, professor, and room models
            $day = DayModel::find($dayId);
            $timeslot = TimeslotModel::find($timeslotId);
            $professor = ProfessorModel::find($professorGene);
            $room = RoomModel::find($roomGene);

            // Initialize the data array for this group, day, and timeslot if necessary
            if (!isset($data[$groupId])) {
                $data[$groupId] = [];
            }

            if (!isset($data[$groupId][$day->name])) {
                $data[$groupId][$day->name] = [];
            }

            if (!isset($data[$groupId][$day->name][$timeslot->time])) {
                $data[$groupId][$day->name][$timeslot->time] = [];
            }

            // Add the course code, course name, room name, and professor name to the data array
            $data[$groupId][$day->name][$timeslot->time]['course_code'] = $course->course_code;
            $data[$groupId][$day->name][$timeslot->time]['course_name'] = $course->name;
            $data[$groupId][$day->name][$timeslot->time]['room'] = $room->name;
            $data[$groupId][$day->name][$timeslot->time]['professor'] = $professor->name;

            // Move to the next scheme and chromosome indices
            $schemeIndex++;
            $chromosomeIndex += 3;
        }

        // Return the generated data
        return $data;
    }
}