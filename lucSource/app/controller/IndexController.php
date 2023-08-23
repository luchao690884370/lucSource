<?php

namespace plugin\lucSource\app\controller;
use support\Request;
use plugin\lucSource\app\model\SourceCode;
use Carbon\Carbon;

class IndexController extends Base
{
    public function index(Request $request)
    {
		$tongji = array();
		$startTime = strtotime('2023-08-15 00:00:00');
		$currentTime = time();
		$seconds = $currentTime - $startTime;
		$minutes = floor($seconds / 60);
		$hours = floor($minutes / 60);
		$days = floor($hours / 24);

		$tongji['days'] =$days;
		$tongji['total_source'] = SourceCode::where('status',1)->count();

		$startDate = Carbon::now()->startOfWeek(Carbon::MONDAY);
		$endDate = Carbon::now()->endOfWeek(Carbon::SUNDAY);
		$tongji['toweek_source'] = SourceCode::where('status', 1)
			->whereBetween('created_at', [$startDate, $endDate])
			->count();

		$tongji['today_source'] = SourceCode::where('status',1)
			->whereBetween('created_at', [Carbon::today()->startOfDay(),Carbon::today()->endOfDay()])
			->count();

		return view('html/index',['tongji'=>$tongji]);
    }




}
