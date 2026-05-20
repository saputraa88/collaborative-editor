<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Events\DocumentUpdated;

class DocumentController extends Controller
{
    public function index($id)
    {
        $document = Document::find($id);

        // kalau document belum ada
        if (!$document) {

            $document = Document::create([
                'title' => 'Document ' . $id,
                'content' => ''
            ]);
        }

        return view('editor', compact('document'));
    }

    public function save(Request $request, $id)
    {
        Document::updateOrCreate(
            ['id' => $id],
            ['content' => $request->content]
        );

        return response()->json([
            'message' => 'Document saved'
        ]);
    }

    public function updateDocument(Request $request, $id)
    {
        Document::updateOrCreate(
            ['id' => $id],
            ['content' => $request->content]
        );

        broadcast(new DocumentUpdated(
            $request->content,
            $id
        ))->toOthers();

        return response()->json([
            'status' => 'ok'
        ]);
    }
}