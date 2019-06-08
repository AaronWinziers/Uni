<?php

namespace App\Http\Controllers;

use App\Client;
use App\Employee;
use App\Task;
use App\Log;
use Illuminate\Http\Request;
use App\Project;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class projectController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('admin', ['except' => ['index', 'show']]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//
		$user = Auth::user();
		$projects = Project::whereDate('endDate', '>=', Carbon::today()->toDateString())->where('done','=',false)->get();

		switch ($user->getUserType()) {
            case 'admin':
                $clients = Client::all()->sortBy('name')->pluck('name')->toArray();
                return view('projects.index', compact('projects', 'clients'));
                break;
            case 'employee':
                $running = Log::where('employeeID','=',$user->getEmployee()->id)->where('timeEnd','=',null)->first();
                return view('projects.employee.index', compact('projects','running'));
                break;
            case 'scanner':
                return view('projects.scanner.index', compact('projects'));
                break;

        }
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//

		return view('projects.create');
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
			'id' => 'required|unique:projects',
			'name' => 'required',
			'client' => 'required',
			'startDate' => 'required',
			'endDate' => 'required'
		]);

        //Create project
        $project = new Project;
        $project->id = $request->input('id');
        $project->name = $request->input('name');
        $project->client = $request->input('client');
        $project->description = $request->input('description');
        $project->shouldTime = 0;
        $project->isTime = 0;
        $project->startDate = $request->input('startDate');
        $project->endDate = $request->input('endDate');
        foreach ($request->input('shouldTimes') as $time){
            $project->shouldTime += $time;
        }

        $project->save();

        Task::storeMultiple($request->names, $request->shouldTimes, $project->id);

        return redirect('/project')->with('success','Neues Projekt erzeugt');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
        $user = Auth::user();
		$project = Project::find($id);
        $project->updateIsTime();
        $project->updateShouldTime();
        $tasks = $project->tasks()->get();
        switch ($user->getUserType()) {
            case 'admin':
                return view('projects.show', compact('tasks','project'));
                break;
            case 'employee':
                return view('projects.employee.show', compact('tasks','project'));
                break;
            case 'scanner':
                return view('projects.scanner.show', compact('tasks','project'));
                break;

        }
        return view('projects.show', compact('tasks','project'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		//
		$project = Project::find($id);
		return view('projects.edit')->with('project', $project);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
		$this->validate($request, [
			'name' => 'required',
			'client' => 'required',
			'startDate' => 'required',
			'endDate' => 'required'
		]);

		//Create project
		$project = Project::find($id);
		$project->name = $request->input('name');
		$project->client = $request->input('client');
		$project->description = $request->input('description');
		$project->updateShouldTime();
		$project->startDate = $request->input('startDate');
		$project->endDate = $request->input('endDate');

		$project->save();

		return redirect('/project/'.$project->id)->with('success','Projekt erfolgreich bearbeitet');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
        $project = Project::find($id);
        $tasks = $project->tasks()->get();
        foreach ($tasks as $task) {
            $logs = $task->logs()->get();
            foreach ($logs as $log) {
                if ($log->employeeID == null) {
                    $log->delete();
                } else {
                    $log->taskNum = null;
                    $log->projectID = null;
                    $log->save();
                }
            }
            $task->delete();
        }
        $project->delete();
        return redirect('/project');
	}

    public function all()
	{
		//
        $projects = Project::all();
        return view('projects.all', compact('projects'));

	}

	public function past()
    {
        $projects = Project::whereDate('endDate', '<', Carbon::today()->toDateString())->get();
        return view('projects.past', compact('projects'));
    }

    public function deactivate($id)
    {
        //
        $project = Project::find($id);
        $project->endDate = Carbon::yesterday();

        $project->save();

        return redirect('/project/past')->with('success','Projekt erfolgreich beendet');
    }
}
