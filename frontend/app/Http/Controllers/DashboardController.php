<?php

namespace App\Http\Controllers;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);
        $activeUser = User::where('id', '!=' , auth()->user()->id)->get();
        $activeUserCount = count($activeUser);
        return view('pages.dashboards.index',compact('activeUserCount'));
    }
}