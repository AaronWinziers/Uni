
{{ Form::open(['method' => 'GET', 'route' => 'log.edit' ]) }}
{{Form::hidden('eid',$log->employeeID)}}
{{Form::hidden('pid',$log->projectID)}}
{{Form::hidden('tid',$log->taskNum)}}
{{Form::hidden('ts',$log->timeStart)}}
<button type="submit" class="btn btn-warning col-sm-9">Bearbeiten</button>
{{ Form::close() }}