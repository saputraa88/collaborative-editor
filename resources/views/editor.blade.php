<!DOCTYPE html>
<html>
<head>
    <title>Collaborative Editor</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
</head>
<body>

<h1>Collaborative Editor</h1>

<div id="editor" style="height:300px;">
    {!! $document->content ?? '' !!}
</div>

<br>

<button id="saveBtn">Save</button>

<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script>
    var quill = new Quill('#editor', {
        theme: 'snow'
    });

    document.getElementById('saveBtn').addEventListener('click', function () {

        fetch('/save', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute('content')
            },
            body: JSON.stringify({
                content: quill.root.innerHTML
            })
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
        });

    });
</script>

</body>
</html>