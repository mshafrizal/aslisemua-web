<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
  public function __invoke(Request $request)
  {
    return view('layouts.default');
  }
}
