<?php

namespace App\Jobs;

use App\Contracts\ShiftRepositoryContract;
use App\Http\Requests\StoreShiftRequest;
use App\Models\Shift;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 *
 */
class ImportShiftsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var mixed
     */
    protected $shifts,$repository;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Collection  $items)
    {
        $this->shifts = $items;
        $this->repository = app(ShiftRepositoryContract::class);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $this->shifts->map(function($shift){
                $this->repository->create($shift);
            });
        }
        catch(\Exception $e) {
            Log::error("There was an error proccessing importing of shifts. The Messahe Is:
                  {$e->getMessage()}
            ");
        }


    }
}
