<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use CoenJacobs\EloquentCompositePrimaryKeys\HasCompositePrimaryKey;
use Carbon\Carbon;

class Log extends Model
{
    use HasCompositePrimaryKey;

    protected $table = 'log';

    protected $primaryKey = null;

    public $timestamps = true;

	/**Sets relationship to a task
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
    public function task(){
        return $this->belongsTo('App\Task','task');
    }

	/**Sets relationship to an employee
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
    public function employee(){
        return $this->belongsTo('App\Employee','employee');
    }

	/** Returns the employee object associated with it TODO:Check to make sure this works
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function getEmployee()
	{
		return $this->employee();
	}

	/** Returns the length of time covered in a given log
	 * @return int
	 */
	public function duration(){

        //$start = Carbon::createFromTimeString($this->timeStart, 'CEST')->to;
        //$end = Carbon::createFromTimeString($this->timeEnd, 'CEST')->toDateTimeString();

        $start = Carbon::parse($this->timeStart, 'CEST');
        $end = Carbon::parse($this->timeEnd, 'CEST');

        return $end->diffInMinutes($start);
    }

	/* Returns the number of hours a log was worked
	 *
	 * @return float
	 */
    public function durationHours(){
        return round($this->duration()/60, 2);
    }
}
