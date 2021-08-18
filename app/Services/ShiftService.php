<?php

namespace App\Services;

use App\Models\Department;
use App\Models\Event;
use App\Models\Location;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class ShiftService
{
     public static function BatchCreate(array $data):Shift{

         // for the reason that there are user which have more than one shift
         // we cache the returned data . So we could use it later and we can
         // reduced the the amount of database query and we do this for other models as well
         $user = Cache::remember($data['user_email'],3600,function () use ($data) {
             return User::firstOrCreate([
                 User::NAME_FIELD   => $data['user_name'],
                 User::EMAIL_FIELD  => $data['user_email']
             ]);

         });

         $location = Cache::remember($data['location'],3600,function() use ($data){

             return Location::firstOrCreate([
                 Location::NAME_FIELD => $data['location']
             ]);

         });

             $shift = Shift::create([
                 Shift::START   => $data['start'],
                 Shift::END     => $data['end'],
                 Shift::TYPE    => $data['type'],
                 Shift::CHARGE  => $data['charge'] ?? NULL,
                 Shift::AREA    => $data['area'] ?? NULL,
                 Shift::RATE    => $data['rate'] ?? NULL,
                 'user_id'      => $user->id,
                 'location_id'  => $location->id
             ]);

               // As in pdf was mentioned there are times
              // that maye there is no event and other relations. So we could check
             // for that situations
         if(isset($data['event']) && !empty($data['event'])){

             $event = Cache::remember(json_encode($data['event']),3600,function() use ($data){

                 return Event::firstOrCreate([
                     Event::NAME_FIELD   => $data['event']['name'],
                     Event::START_FIELD  => $data['event']['start'],
                     Event::END_FIELD    => $data['event']['end']
                 ]);

             });
             // saving the relation of shifts
             $event->shifts()->save($shift);

         }

         if(isset($data['departments']) && !empty($data['departments'])){
              //Adding created ids So we could sync the departments with  shift
             $departments_ids = collect([]);
             foreach($data['departments'] as $department){

                 $department = Cache::remember($department,3600,function() use ($department){

                     return Department::firstOrCreate([
                         Department::NAME_FILED => $department
                     ]);

                 });
                 $departments_ids->push($department->id);
             }

             // syncing many to many relation between department and shift
             $shift->departments()
                 ->syncWithoutDetaching($departments_ids);

         }
         return $shift;
     }
}
