<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;


class ThreadController extends Controller
{
    public function index()
    {
        return Thread::orderBy('id', 'desc')->get();
    }
}
