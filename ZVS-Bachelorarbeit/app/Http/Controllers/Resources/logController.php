<?php

namespace App\Http\Controllers;

use App\Log;
use App\Project;
use App\Employee;
use App\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class logController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin', ['except' => ['store','end','confirm']]);
    }

    public function index(Request $request)
    {
        //
        $logs = Log::where('timeEnd','=',null)->get();
        $employees = Employee::nameList();
        //return var_dump(Log::where('timeEnd','=',null)->where('employeeID','=',1)->toSql());
        return view('employee.running', compact('logs','employees'));
    }


	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		//
        $this->validate($request, [
            'employeeID' => 'required',
			//|unique_with:log,timeStart
			'timeStart' => 'required',
            'projectID' => 'required',
            'taskNum' => 'required'
		]);

        $running = Log::where('employeeID','=',$request->input('employeeID'))->where('timeEnd','=',null)->get();
        if (!empty($running)){
            $time = Carbon::now();
            DB::update('UPDATE log SET timeEnd = ? WHERE employeeID = ? AND timeEnd IS NULL;', [$time,$request->input('employeeID')]);
        }

		$log = new Log;
		$log->employeeID = $request->input('employeeID');
        $log->projectID = $request->input('projectID');
        $log->taskNum = $request->input('taskNum');
        $log->timeEnd = $request->input('timeEnd');
        $log->timeStart = $request->input('timeStart');

		$log->save();

        $user = auth()->user();
        switch ($user->getUserType()) {
            case 'admin':
                return redirect('/project/'.$request->projectID.'/task/'.$request->taskNum)->with('success', 'Stunden erfolgreich hinzugefügt');
                break;
            case 'employee':
                $projects = Project::all();
                return redirect('/project/')->with('success', 'Erfolgreich umgemeldet');
                break;
            case 'scanner':
                $projects = Project::all();
                return view('projects.scanner.index', compact('projects'));
                break;
            default:
                return view('indexes.index')->with('error','Invalid user type');

        }

		return redirect('/project/'.$request->projectID.'/task/'.$request->taskNum)->with('success', 'Stunden erfolgreich hinzugefügt');
	}

	public function end($id)
    {
        $user = auth()->user();
        $time = Carbon::now();

        if ($user->isScanner()){
            $employee = Employee::where('transponder','=',$id)->first();
            $useThisID = $employee->id;
        } else {
            $useThisID = $id;
        }

        DB::update('UPDATE log SET timeEnd = ? WHERE employeeID = ? AND timeEnd IS NULL;', [$time, $useThisID]);

        if ($user->isAdmin()){
            return redirect('/running/')->with('success', 'Tätigkeit erfolgreich beendet');
        } else {
            return redirect('/project/')->with('success', 'Tätigkeit erfolgreich beendet');
        }
    }

    public function confirm($project, $task, $id){
	    $task = Task::where('project','=',$project)->where('number','=',$task)->first();
        $employee = Employee::where('transponder','=',$id)->first();
        return view('projects.scanner.confirm', compact('task','employee'));
            //,compact('task'));
    }



	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Request $request)
	{
		//
        $log = Log::where('employeeID','=',$request->eid)->where('projectID','=',$request->pid)->where('taskNum','=',$request->tid)->where('timeStart','=',$request->ts)->first();
        return view('tasks.logedit', compact('log'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request)
	{
		//

        DB::delete('DELETE FROM log WHERE employeeID=? AND projectID=? AND taskNum=? AND timeStart=? LIMIT 1;',[$request->eid,$request->pid,$request->tid,$request->ts]);

        return redirect('/project/'.$request->pid.'/task/'.$request->tid);
	}
}
