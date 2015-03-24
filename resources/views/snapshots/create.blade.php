@extends('layouts.master')

@section('content')
<form method="post" action="/snapshots">

<input type="hidden" name="_token" value="{{csrf_token()}}" /><br />
<label>Volume Name</lable><input type="text" name="volume_name" /><br />
<label>Snapshot Name</label><input type="text" name="snapshot_name" /><br />
<input type="submit">
</form>

@stop

