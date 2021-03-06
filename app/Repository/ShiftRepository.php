<?php

namespace App\Repository;

use App\Contracts\ShiftRepositoryContract;
use App\Http\Requests\ShiftIndexRequest;
use App\Http\Resources\ShiftResource;
use App\Models\Department;
use App\Models\Event;
use App\Models\Location;
use App\Models\Shift;
use App\Models\User;
use App\Services\ShiftService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

/**
 *
 */
class ShiftRepository implements ShiftRepositoryContract
{

    public const PAGINATION_NUMBER = 15;
    /**
     * @param ShiftIndexRequest $request
     * @return mixed
     */
    public function index(ShiftIndexRequest $request)
    {

           return  Location::query()
                ->where('name', $request->query('location'))
                ->first()
                ->shifts()
                ->whereDate('start', '>=', Carbon::parse($request->query('start')))
                ->whereDate('end', '<=', Carbon::parse($request->query('end')))
                ->with(['user', 'location', 'event', 'departments'])
                ->paginate(static::PAGINATION_NUMBER);

    }

    /**
     * @param array $data
     * @return Shift
     */
    public function create(array $data): Shift
    {
        return ShiftService::BatchCreate($data);
    }


}
