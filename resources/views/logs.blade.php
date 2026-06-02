<!DOCTYPE html>
<html>
<head>
    <title>Edit Logs</title>
</head>
<body>

<h1>Conflict Resolution - Edit Logs</h1>

<a href="/document/1">Kembali ke Editor</a>

<hr>

@foreach($logs as $log)

<div style="border:1px solid #ccc;padding:10px;margin-bottom:10px">

    <strong>User:</strong>
    {{ $log->editor_name }}

    <br>

    <strong>Waktu:</strong>
    {{ $log->created_at }}

    <hr>

    {!! $log->content !!}

</div>

@endforeach

</body>
</html>