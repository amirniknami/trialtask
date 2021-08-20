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
    protected $shifts, $repository;
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
        // Here we import the shifts to database using the Shiftrepository
        // we check if 5 required properties are set due to fault tolerance
        try {
            $this->shifts->map(function ($shift) {
                if (
                    isset($shift['type'])  &&
                    isset($shift['start']) &&
                    isset($shift['end'])   &&
                    isset($shift['user_email']) &&
                    isset($shift['location'])
                ) {
                    $this->repository->create($shift);
                }
            });
        } catch (\Exception $e) {
            Log::error("There was an error processing importing of shifts. The Message Is:
                  {$e->getMessage()}
            ");
        }
    }
}
