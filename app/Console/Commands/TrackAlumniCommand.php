<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Alumni;
use App\Services\AlumniTrackingService;

class TrackAlumniCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alumni:track-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Secara otomatis melacak alumni yang belum teridentifikasi (System Actor / Timer)';

    /**
     * Execute the console command.
     */
    public function handle(AlumniTrackingService $trackingService)
    {
        $this->info('Memulai proses pelacakan otomatis...');
        
        $untrackedAlumnis = Alumni::where('status', 'Belum Dilacak')->get();
        
        if ($untrackedAlumnis->isEmpty()) {
            $this->info('Tidak ada alumni dalam antrian pelacakan.');
            return;
        }

        $bar = $this->output->createProgressBar($untrackedAlumnis->count());
        $bar->start();

        foreach ($untrackedAlumnis as $alumni) {
            $trackingService->track($alumni);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Pelacakan selesai!');
    }
}
