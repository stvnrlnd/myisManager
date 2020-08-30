<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Jobs\SendEmail;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
class JobController extends Controller
{
   public function enqueue(Request $request)
 {
        $details = ['email' => 'arixxmanager@gmail.com'];
        $emailJob = (new      SendEmail($details))->delay(Carbon::now()->addMinutes(5));
        dispatch($emailJob);
    }
}
