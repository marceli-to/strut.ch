<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ClearImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all generated images';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $directories = Storage::allDirectories('public');
        $deletable   = [
            'public/media/large',
            'public/media/medium',
            'public/media/small',
            'public/media/xsmall',
            'public/media/thumbs',
            'public/media/grid',
        ];

        foreach($directories as $directory)
        {
            if (in_array($directory, $deletable))
            {
                Storage::deleteDirectory($directory);
            }
        }
    }
}
