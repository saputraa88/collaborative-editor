<!DOCTYPE html>
<html>
<head>
    <title>Collaborative Editor</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    @vite('resources/js/app.js')
</head>
<body>

<h1>Collaborative Editor</h1>

<input
    type="text"
    id="editorName"
    placeholder="Masukkan Nama Anda"
    value="Agus">

<br><br>

<p id="typingStatus"></p>

<div id="editor" style="height:300px;"></div>

<br><br>

<button id="saveBtn">Save</button>

<button onclick="window.location='/history/{{ $document->id }}'">
    History
</button>

<button onclick="window.location='/logs/{{ $document->id }}'">
    Edit Logs
</button>

<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script>

document.addEventListener('DOMContentLoaded', function () {

    // =========================
    // INIT QUILL
    // =========================
    const quill = new Quill('#editor', {
        theme: 'snow'
    });

    // isi awal editor
    quill.clipboard.dangerouslyPasteHTML(
        `{!! $document->content ?? '' !!}`
    );

    let isUpdating = false;
    let typingTimer;

    // =========================
    // CURSOR TRACKING
    // =========================
    quill.on('selection-change', function(range) {

        if (!range) return;

        fetch('/cursor-update', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute('content')
            },
            body: JSON.stringify({
                document_id: {{ $document->id }},
                position: range.index
            })
        });

    });

    // =========================
    // UPDATE DOCUMENT
    // =========================
    quill.on('text-change', function(delta, oldDelta, source) {

        if (source !== 'user') return;

        if (isUpdating) return;

        clearTimeout(typingTimer);

        typingTimer = setTimeout(() => {

            fetch('/update-document/{{ $document->id }}', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute('content')
    },
    body: JSON.stringify({
        content: quill.root.innerHTML,
        editor_name: document.getElementById('editorName').value
    })
});

        }, 500);

    });

    // =========================
    // REALTIME LISTENER
    // =========================
    setTimeout(() => {

        if (window.Echo) {

            console.log('Echo aktif');

            window.Echo.channel('document.{{ $document->id }}')

            .listen('.DocumentUpdated', (e) => {

                console.log('Realtime masuk:', e);

                if (quill.root.innerHTML === e.content) {
                    return;
                }

                isUpdating = true;

                const range = quill.getSelection();

                quill.clipboard.dangerouslyPasteHTML(
                    e.content
                );

                if (range) {
                    quill.setSelection(
                        range.index,
                        range.length
                    );
                }

                setTimeout(() => {
                    isUpdating = false;
                }, 100);

            })

            .listen('.CursorMoved', (e) => {

                console.log('CursorMoved:', e);

                const status =
                    document.getElementById('typingStatus');

                status.innerHTML =
                    'Cursor user lain di posisi: ' + e.position;

                clearTimeout(window.cursorHide);

                window.cursorHide = setTimeout(() => {

                    status.innerHTML = '';

                }, 1500);

            });

        } else {

            console.log('Echo belum aktif');

        }

    }, 1000);

    // =========================
    // SAVE BUTTON
    // =========================
    document.getElementById('saveBtn')
        .addEventListener('click', function () {

        fetch('/save/{{ $document->id }}', {
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

});

</script>

</body>
</html>