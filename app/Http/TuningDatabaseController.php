<?php

namespace CreatyDev\Http;

use CreatyDev\App\Controllers\Controller;
use Illuminate\Http\Request;

class TuningDatabaseController extends Controller
{
    public function index()
    {
        return view('tuning_database.index');
    }
}
