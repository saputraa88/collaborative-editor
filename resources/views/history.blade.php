<!DOCTYPE html>
<html>
<head>
    <title>Document History</title>
</head>
<body>

<h1>Document Revision History</h1>

<a href="/document/1">
    ← Kembali ke Editor
</a>

<hr>

@forelse($versions as $version)

<div style="border:1px solid #ccc; padding:15px; margin-bottom:15px;">

    <h3>
        Revision:
        {{ $version->created_at }}
    </h3>

    <div>
        {!! $version->content !!}
    </div>

</div>

@empty

<p>Belum ada revision.</p>

@endforelse

</body>
</html>