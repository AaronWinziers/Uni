<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Project;
use App\Task;
use App\Log;
use Illuminate\Http\Request;

class taskController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('admin');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create($pid)
	{
		//
		$project = Project::find($pid);
		return view('tasks.create')->with('project', $project);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store($pid, Request $request)
	{
		//
		$this->validate($request, [
			'name' => 'required',
			'shouldTime' => 'required',
			'number' => 'required',
            'project' => 'required|unique_with:tasks,number'
		]);

		$task = new Task;
		$task->name = $request->input('name');
        $task->number = $request->input('number');
        $task->shouldTime = $request->input('shouldTime');
        $task->project = $pid;
        $task->isTime = 0;

		$task->save();

		return redirect('/project/'.$pid)->with('success', 'Tätigkeit erfolgreich hinzugefügt');
	}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($pid, $tid)
    {
        //
        $project = Project::find($pid);
        $task = $project->tasks()->where('number', '=', $tid)->first();
        $logs = $task->logs()->where('timeEnd','!=',null)->get();
        $employees = Employee::nameList();
        //Log::where('projectID', $pid)->where('taskNum', $tid)->get();

        return view('tasks.show', compact('project', 'task', 'logs','employees'));
    }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($pid, $tid)
	{
		//

		$project = Project::find($pid);
		$task = Task::all()->where('project', '=', $pid)->firstWhere('number', '=', $tid);
		return view('tasks.edit', compact('project', 'task'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update($pid, $tid, Request $request)
	{
		//
        $this->validate($request, [
            'name' => 'required',
            'shouldTime' => 'required',
            'number' => 'required',
        ]);

		$task = Task::where('project', '=', $request->input('project'))->where('number', '=', $request->input('number'))->first();
		$task->name = $request->input('name');
		$task->shouldTime = $request->input('shouldTime');
		$task->number = $request->input('number');

		$task->save();

		return redirect('/project/'.$pid)->with('success', 'Tätigkeit erfolgreich hinzugefügt');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($pid, $tid)
	{
		//
        $task = Task::where('project', '=', $pid)->where('number', '=', $tid)->first();
        $logs = $task->logs()->get();
        foreach ($logs as $log){
            if ($log->employeeID == null){
                $log->delete();
            } else {
                $log->taskNum = null;
                $log->projectID = null;
                $log->save();
            }
        }
        $task->delete();
        return redirect('/project/'.$pid);
    }
}
