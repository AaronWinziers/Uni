<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Task;

class Project extends Model
{
	//
	protected $primaryKey = 'id';

	public $incrementing = false;

	public $timestamps = true;

	public function tasks(){
	    return $this->hasMany('App\Task', 'project');
    }

	public function getIsTime(){

	    $tasks = Task::where('project',$this->id)->get();

	    $time = 0;

	    foreach ($tasks as $task){
	        $time += $task->updateIsTime();
        }

		return $time;
	}

	public function getShouldTime(){

	    $tasks = Task::where('project',$this->id)->get();

	    $time = 0;

	    foreach ($tasks as $task){
	        $time += $task->getShouldTime();
        }

        $this->shouldTime = $time;
        $this->save();

		return $time;
	}


    public function restTime(){
	    return round(($this->shouldTime - $this->isTime)/60, 2);
    }

    public function restTimePercent(){
	    return round(($this->restTime()/$this->shouldTime));
    }

}
