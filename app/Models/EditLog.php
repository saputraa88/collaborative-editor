<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EditLog extends Model
{
    protected $fillable = [
        'document_id',
        'editor_name',
        'content'
    ];
}