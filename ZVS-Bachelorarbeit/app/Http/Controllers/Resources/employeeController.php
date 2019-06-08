<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Employee;
use App\Log;
use Carbon\Carbon;

class employeeController extends Controller
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
		$user = auth()->user();
        switch ($user->getUserType()) {
            case 'admin':
                $employees = Employee::all();
                $users = User::employeeUsers();
                return view('employee.index',compact('employees','users'));
                break;
            case 'employee':
                $employee = $user->getEmployee();
                $logs = Log::where('employeeID','=',$employee->id)->where('timeEnd','!=',null)->get();
                //$logs = $employee->logs()->whereDate('timeStart', Carbon::today())->get();
                $running = Log::where('employeeID','=',$user->getEmployee()->id)->where('timeEnd','=',null)->first();
                return view('employee.showEmployee', compact('employee','logs','running'));
                break;
            case 'scanner':
                $employee = Employee::all()->first();
                $logs = Log::all();
                return view('employee.showScanner', compact('logs','employee'));
                break;

        }
		if ($user->isAdmin()){
			$employees = Employee::all();
			return view('employee.index')->with('employees', $employees);
		} else if ($user->isEmployee() and $user->hasEmployee()){
		    return $user->employee()->get();
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
		return view('employee.create');

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
			'lastName' => 'required',
			'firstName' => 'required',
			'department' => 'required',
			'hours' => 'required',
			'id' => 'required|unique:employees',
            'transponder' => 'unique:employees'
		]);

		//Create employee
		$employee = new Employee;
		$employee->firstName = $request->input('firstName');
		$employee->lastName = $request->input('lastName');
		$employee->id = $request->input('id');
		$employee->transponder = $request->input('transponder');
		$employee->department = $request->input('department');
		$employee->hours = $request->input('hours');
		$employee->save();

		return redirect('/employee')->with('success','Neuer Mitarbeiter erzeugt');

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

        $user = auth()->user();
        switch ($user->getUserType()) {
            case 'admin':
                $employee = Employee::withTrashed()->find($id);
                $logs = $employee->logs()->get();
                return view('employee.showAdmin', compact('employee','logs'));
            case 'scanner':
                $employee = Employee::where('transponder','=',$id)->first();
                $logs = $employee->logs()->whereDate('timeStart', Carbon::today())->get();
                $running = Log::where('employeeID','=',$user->getEmployee()->id)->where('timeEnd','=',null)->first();
                return view('employee.showScanner', compact('logs','employee','running'));
                break;

        }
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
		$employee = Employee::find($id);
		return view('employee.edit')->with('employee', $employee);
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
			'lastName' => 'required',
			'firstName' => 'required',
			'department' => 'required',
			'hours' => 'required',
		]);

		$employee = Employee::find($id);
		$employee->firstName = $request->input('firstName');
		$employee->lastName = $request->input('lastName');
		$employee->department = $request->input('department');
		$employee->hours = $request->input('hours');
		$employee->save();

		return redirect('/employee/'.$employee->id)->with('success','Mitarbeiter erfolgreich bearbeitet');
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
        $employee = Employee::withTrashed()->find($id);
        $logs = $employee->logs();
        foreach ($logs as $log){
            if ($log->taskNum == null && $log->projectID == null){
                $log->delete();
            } else {
                $log->employeeID = null;
                $log->save();
            }
        }
        $employee->forceDelete();

		return redirect('/employee')->with('success','Mitarbeiter erfolgreich entfernt');
	}


	public function deactivate($id)
    {
        //
        $employee = Employee::withTrashed()->find($id);
        if ($employee->deleted_at == null){
            $employee->delete();
            return redirect('/employee/deactivated')->with('success','Mitarbeiter erfolgreich deaktiviert');
        }else{
            return back()->with('error','Mitarbeiter ist bereits deaktiviert');
        }
    }

    public function showDeactivated()
    {
        $employees = Employee::onlyTrashed()->get();
        return view('employee.deleted', compact('employees'));
    }

    public function activate($id)
    {
        //
        $employee = Employee::withTrashed()->find($id);
        if ($employee->deleted_at != null){
            $employee->restore();
            return redirect('/employee')->with('success','Mitarbeiter erfolgreich aktiviert');
        }else{
            return back()->with('error','Mitarbeiter ist bereits aktiviert');
        }
    }


}
