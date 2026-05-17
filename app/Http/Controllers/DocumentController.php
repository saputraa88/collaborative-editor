<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;

class DocumentController extends Controller
{
    public function index()
    {
        $document = Document::first();

        return view('editor', compact('document'));
    }

    public function save(Request $request)
    {
        $document = Document::first();

        if (!$document) {
            $document = new Document();
        }

        $document->content = $request->content;
        $document->save();

        return response()->json([
            'message' => 'Document Saved'
        ]);
    }
}