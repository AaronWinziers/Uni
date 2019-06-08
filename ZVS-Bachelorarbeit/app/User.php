<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	use Notifiable;

	protected $primaryKey = 'username';
    public $incrementing = false;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'username', 'password','userType','employee'
	];

    public static function employeeUsers(){
        return User::select('username','employee')->where('employee','!=',null)->get()->keyBy('employee')->toArray();
    }

    /**
     * Sets relationship to Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee(){
        return $this->belongsTo('App\Employee', 'employee', 'id');
    }

    /**public static function nameList(){
        return Employee::select('id','firstName','lastName')->get()->keyBy('id')->toArray();
    }
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	public function getEmployee(){
	    return $this->employee()->get()->first();
    }

    /**
     * Checks if user has employee assigned
     *
     * @return bool
     */
	public function hasEmployee(){

        if (!empty($this->getEmployee())){
            return true;
        } else {
            return false;
        }

    }


    public function getEmployeeName(){
	    if ($this->hasEmployee()){
            $emp = $this->getEmployee();
            return $emp->firstName.' '.$emp->lastName;
        } else {
	        return 'Kein Mitarbeiter zugeordnet';

        }
    }

    public function getUserType(){
	    return $this->userType;
    }

	public function isAdmin(){
		if ($this->userType == 'admin'){
			return 1;
		} else {
			return 0;
		}
	}

	public function isEmployee(){
		if ($this->userType == 'employee'){
			return 1;
		} else {
			return 0;
		}
	}

	public function isScanner(){
		if ($this->userType == 'scanner'){
			return 1;
		} else {
			return 0;
		}
	}
}
