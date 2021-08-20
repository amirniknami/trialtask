<?php

namespace App\Http\Controllers;

use App\Contracts\ShiftRepositoryContract;
use App\Http\Requests\ShiftIndexRequest;
use App\Http\Requests\StoreShiftRequest;
use App\Http\Resources\ShiftResource;
use App\Jobs\ImportShiftsJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;

/**
 *
 */
class ShiftController extends Controller
{

    public function index(ShiftRepositoryContract $repository,ShiftIndexRequest $request){

          return ShiftResource::collection($repository->index($request));
    }

    /**
     *
     */
    protected const CHUNKED_VALUE = 1000;

    /**
     * @param StoreShiftRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function store(StoreShiftRequest $request){


            $array = $request->shifts ?? json_decode($request->file('file')->getContent(),true)['shifts'];

        // As it could be Millions of records we have to dispatch a queued job
        // so user will not be bother by the importing process

          //if there would be  millions of records the best thing is that chunking it into multiple array
           foreach(collect($array)->chunk(static::CHUNKED_VALUE) as $items) {
               ImportShiftsJob::dispatch($items);
           }
          // as this is just a queue job and the process is continuing
          // we should return the 202 response status
          return response()
                 ->json(true,202);
    }

}
