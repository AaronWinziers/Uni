<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Project;
use App\Log;
use Carbon\Carbon;

class PageController extends Controller
{
	public function index(){
		if (Auth::check()){
			$user = auth()->user();
            $projects = Project::whereDate('endDate', '>=', Carbon::today()->toDateString())->where('done','=',false)->get();
            switch ($user->getUserType()) {
                case 'admin':
                    return view('indexes.admin', compact('projects'));
                    break;
                case 'employee':
                    $running = Log::where('employeeID','=',$user->getEmployee()->id)->where('timeEnd','=',null)->first();
                    return view('projects.employee.index', compact('projects','running'));
                    break;
                case 'scanner':
                    return view('projects.scanner.index', compact('projects'));
                    break;
                default:
                    return view('indexes.index')->with('error','Invalid user type');

            }
		} else {
			return view('indexes.index');
		}
	}
}
