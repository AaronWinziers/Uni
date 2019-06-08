{{Form::label('client', 'Kunde')}}
<select class="form-control client" value="Kunde" id="client" name="client">
    <option value="">Wählen</option>
    @foreach($clients as $client)
        <option value="{{$client}}">{{$client}}</option>
    @endforeach
</select>