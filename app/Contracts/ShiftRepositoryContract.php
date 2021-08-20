<?php

namespace App\Contracts;

use App\Http\Requests\ShiftIndexRequest;
use App\Http\Resources\ShiftResource;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;


/**
 *
 */
interface ShiftRepositoryContract
{
    /**
     * @param array $data
     * @return Shift
     */
    public function create(array $data):Shift;


    /**
     * @param ShiftIndexRequest $request
     * @return mixed
     */
    public function index(ShiftIndexRequest $request);
}
