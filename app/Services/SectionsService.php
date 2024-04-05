<?php

namespace App\Services;

use App\Models\Section;

class SectionsService
{
    /**
     * Get all sections.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllSections()
    {
        return Section::all();
    }

    /**
     * Get a specific section by ID.
     *
     * @param  int $id
     * @return \App\Models\Section|null
     */
    public function getSectionById($id)
    {
        return Section::find($id);
    }

    /**
     * Create a new section.
     *
     * @param  array $data
     * @return \App\Models\Section
     */
    public function createSection(array $data)
    {
        return Section::create($data);
    }

    /**
     * Update a section.
     *
     * @param  \App\Models\Section $section
     * @param  array $data
     * @return bool 
     */
    public function updateSection(Section $section, array $data)
    {
        return $section->update($data);
    }

    /**
     * Delete a section.
     *
     * @param  \App\Models\Section $section
     * @return bool 
     */
    public function deleteSection(Section $section)
    {
        return $section->delete();
    }
}