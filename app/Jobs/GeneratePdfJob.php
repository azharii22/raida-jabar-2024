<?php

namespace App\Jobs;

use App\Models\Peserta;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class GeneratePdfJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $roleId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($roleId)
    {
        $this->roleId = $roleId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->roleId == 1 || $this->roleId == 4) {
            $peserta = Peserta::where('villages_id', '!=', NULL)
                ->orderBy('nama_lengkap')
                ->get();

            $pdf = Pdf::loadView('test-card', compact('peserta'))->setPaper([0, 0, 566.93, 850.394], 'landscape');
            
            Storage::put('public/pdf/IDCard_Peserta.pdf', $pdf->output());
        }
    }
}
