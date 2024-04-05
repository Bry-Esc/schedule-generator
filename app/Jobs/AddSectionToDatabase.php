<?php

namespace App\Jobs;

use App\Models\Section;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AddSectionToDatabase implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $fileName;
    protected $fileUrl;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($fileName, $fileUrl)
    {
        $this->fileName = $fileName;
        $this->fileUrl = $fileUrl;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Section::create([
            'name' => $this->fileName,
            'file_url' => $this->fileUrl,
        ]);
    }
}