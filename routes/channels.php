<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('document.{id}', function ($user = null, $id = null) {

    return [
        'id' => session()->getId(),
        'name' => 'Guest-' . substr(session()->getId(), 0, 5),
    ];

});