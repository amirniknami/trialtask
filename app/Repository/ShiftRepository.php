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

    /**
     * @param ShiftIndexRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(ShiftIndexRequest $request): AnonymousResourceCollection
    {

        return ShiftResource::collection(
            Location::query()
                ->where('name', request()->query('location'))
                ->first()
                ->shifts()
                ->whereDate('start', '>=', Carbon::parse($request->query('start')))
                ->whereDate('end', '<=', Carbon::parse($request->query('end')))
                ->with(['user', 'location', 'event', 'departments'])
                ->paginate(15)
        );
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
