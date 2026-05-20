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
<h3 id="onlineUsers">
    Online Users: 0
</h3>

<p id="typingStatus"></p>

<div id="editor" style="height:300px;"></div>

<br>

<button id="saveBtn">Save</button>

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

    // cegah loop realtime
    let isUpdating = false;
    let typingTimer;

    // =========================
    // UPDATE DOCUMENT
    // =========================
    quill.on('text-change', function (delta, oldDelta, source) {

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
                    content: quill.root.innerHTML
                })
            });

        }, 500);

    });

    // =========================
    // REALTIME LISTENER
    // =========================
    setTimeout(() => {

        console.log(window.Echo);

        if (window.Echo) {

            console.log('Echo aktif');

           window.Echo.join('document.{{ $document->id }}')

    .here((users) => {

        document.getElementById('onlineUsers')
            .innerHTML =
            'Online Users: ' + users.length;

    })

    .joining((user) => {

        let current = parseInt(
            document.getElementById('onlineUsers')
                .innerHTML.replace(/\D/g, '')
        );

        document.getElementById('onlineUsers')
            .innerHTML =
            'Online Users: ' + (current + 1);

    })

    .leaving((user) => {

        let current = parseInt(
            document.getElementById('onlineUsers')
                .innerHTML.replace(/\D/g, '')
        );

        document.getElementById('onlineUsers')
            .innerHTML =
            'Online Users: ' + (current - 1);

    })

    .listen('.DocumentUpdated', (e) => {

        console.log('Realtime masuk:', e);

        if (quill.root.innerHTML === e.content) {
            return;
        }

        isUpdating = true;

        const range = quill.getSelection();

        quill.clipboard.dangerouslyPasteHTML(e.content);

        if (range) {
            quill.setSelection(range.index, range.length);
        }

        setTimeout(() => {
            isUpdating = false;
        }, 100);

    })

    .listen('.DocumentTyping', () => {

        const status =
            document.getElementById('typingStatus');

        status.innerHTML =
            'User sedang mengetik...';

        clearTimeout(window.typingHide);

        window.typingHide = setTimeout(() => {

            status.innerHTML = '';

        }, 1000);

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