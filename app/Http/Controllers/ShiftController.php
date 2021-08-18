<?php

namespace App\Http\Controllers;

use App\Contracts\ShiftRepositoryContract;
use App\Http\Requests\ShiftIndexRequest;
use App\Http\Requests\StoreShiftRequest;
use App\Jobs\ImportShiftsJob;
use Illuminate\Http\Request;

/**
 *
 */
class ShiftController extends Controller
{

    public function index(ShiftRepositoryContract $repository,ShiftIndexRequest $request){
          return $repository->index($request);
    }

    /**
     *
     */
    protected const CHUNKED_VALUE = 1000;

    /**
     * @param StoreShiftRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreShiftRequest $request){

        // As it could be Millions of records we have to dispatch a queued job
        // so user will not be bother by the importing process

          //if there would be  millions of records the best thing is that chunking it into multiple array
           foreach(collect($request->shifts)->chunk(static::CHUNKED_VALUE) as $items) {
               ImportShiftsJob::dispatch($items);
           }
          // as this is just a queue job and the process is continuing
          // we should return the 202 response status
          return response()
                 ->json(true,202);
    }

}
