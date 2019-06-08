<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use function PMA\Util\get;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    use Notifiable;
	//
	protected $primaryKey = 'id';
	public $timestamps = true;

	use SoftDeletes;

    /** The attributes that should be hidden for arrays.
    *
    * @var array
    */
    protected $hidden = [
        'password', 'remember_token', 'transponder',
    ];

	/** Sets the relationship to logs belonging to the employee
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
    public function logs(){
        return $this->hasMany('App\Log', 'employee');
    }

    /** Sets the relationship to the normally worked hours
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function standard_hours(){
        return $this->hasMany('App\Standard_Hours', 'employee');
    }

    /** Sets the relationship to periods worked at different time schemes
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function exceptional_hours(){
        return $this->hasMany('App\Exceptional_Hours', 'employee');
    }

    /** Sets the relationship to the projects an employee leads
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     * TODO: test this, second local key may be incorrect
     */
    public function project_leaders(){
        return $this->hasManyThrough('App\Projects', 'App\Project_Leaders', 'employee','id','id','project');
    }

	/**Returns array containing all ids, first, and last names of all employees
	 *
	 * @return mixed
	 */

    public static function nameList(){
        return Employee::select('id','first_name','last_name')->get()->keyBy('id')->toArray();
    }


    /** Compares a transponder number to that of the employee
     *
     * @param int $transponder
     * @return bool
     */
    public function checkTransponder(int $transponder){
        return ($this->transponder == $transponder);
    }

    /**
     * @param bool $val
     */
    public function setAdmin(bool $val){
        $this->admin = $val;
        $this->save();
        return;
    }

    /**
     * @param bool $val
     */
    public function setEmployee(bool $val){
        $this->employee = $val;
        $this->save();
        return;
    }

    /**
     * @param bool $val
     */
    public function setManager(bool $val)
    {
        $this->manager = $val;
        $this->save();
        return;
    }

    /**
     * @param bool $val
     */
    public function setActive(bool $val){
        $this->active = $val;
        $this->save();
        return;
    }

    /** Returns true if the account is designated for the scanner
     *
     * @param bool $val
     */
    public function setScanner(bool $val){
        $this->scanner = $val;
        $this->save();
        return;
    }

}
