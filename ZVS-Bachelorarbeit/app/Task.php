<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use CoenJacobs\EloquentCompositePrimaryKeys\HasCompositePrimaryKey;
use App\Log;
use Carbon\Carbon;


class Task extends Model
{
    //
    use HasCompositePrimaryKey;

    protected $primaryKey = array('number','project');

    public $timestamps = true;

    public function project(){
        return $this->belongsTo('App\Project','project','id');
    }

    public function logs(){
        return $this->hasMany('App\Log', 'projectID', 'project')->where('taskNum','=', $this->number);
    }

	public function updateIsTime(){

        $logs = Log::where('projectID', $this->project)->where('taskNum', $this->number)->where('timeEnd','!=',null)->get();
        $time = 0;

        foreach ($logs as $log) {
            $time += $log->duration();
        }

        $this->isTime = $time;
        $this->save();

        return $time;
    }

    public function isTimeHours(){
        return round(($this->isTime/60), 2);
    }

    public function getShouldTime()
    {
        return $this->shouldTime;
    }

    public static function storeMultiple($names, $times, $project)
    {
        for($index = 0; $index < sizeof($names); $index++){
            $task = new Task;
            $task->name = $names[$index];
            $task->number = $index+1;
            $task->shouldTime = $times[$index];
            $task->project = $project;
            $task->isTime = 0;

            $task->save();
        }
        return false;
    }

}
