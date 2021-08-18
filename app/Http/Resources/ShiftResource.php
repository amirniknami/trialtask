<?php

namespace App\Http\Resources;

use App\Http\Requests\DepartmentResource;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ShiftResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [
           'type'         => $this[Shift::TYPE],
            'start'       => $this[Shift::START],
            'end'         => $this[Shift::END],
            'user_name'   => $this->user[User::NAME_FIELD],
            'user_email'  => $this->user[User::EMAIL_FIELD],
            'location'    => $this->location->name,
            'event'       => $this->event,
            'rate'        => $this[Shift::RATE],
            'charge'      => $this[Shift::CHARGE],
            'area'        => $this[Shift::AREA],
            'departments' => $this->departments->pluck('title')

        ];
    }

}
