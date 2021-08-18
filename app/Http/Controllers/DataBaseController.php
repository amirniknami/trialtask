<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class DataBaseController extends Controller
{
    public function __invoke(){
        // we could jus remove data from tables
        // but as we want to empty the whole app data
        // we could just use migrate:fresh for convenient
        Artisan::call('migrate:fresh');
        return response()->json(true);
    }
}
