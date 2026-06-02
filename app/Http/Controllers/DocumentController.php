<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\DocumentVersion;
use App\Models\EditLog;
use App\Events\DocumentUpdated;
use App\Events\CursorMoved;

class DocumentController extends Controller
{
    public function index($id)
    {
        $document = Document::find($id);

        if (!$document) {
            $document = Document::create([
                'title'   => 'Document ' . $id,
                'content' => ''
            ]);
        }

        return view('editor', compact('document'));
    }

    public function save(Request $request, $id)
    {
        $document = Document::find($id);

        if (!$document) {
            $document = Document::create([
                'title'   => 'Document ' . $id,
                'content' => ''
            ]);
        }

        // Simpan isi lama ke version history
        if (!empty($document->content)) {
            DocumentVersion::create([
                'document_id' => $document->id,
                'content'     => $document->content
            ]);
        }

        // Simpan isi terbaru
        $document->content = $request->content;
        $document->save();

        return response()->json([
            'message' => 'Document saved'
        ]);
    }

    public function updateDocument(Request $request, $id)
    {
        try {

            $document = Document::find($id);

            if (!$document) {
                $document = Document::create([
                    'title'   => 'Document ' . $id,
                    'content' => ''
                ]);
            }

            $document->content = $request->content;
            $document->save();

            EditLog::create([
                'document_id' => $id,
                'editor_name' => $request->editor_name,
                'content'     => $request->content
            ]);

            broadcast(new DocumentUpdated(
                $request->content,
                $id
            ))->toOthers();

            return response()->json([
                'status' => 'ok'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 500);

        }
    }

    // =========================
    // CURSOR TRACKING
    // =========================
    public function cursorUpdate(Request $request)
    {
        try {

            broadcast(new CursorMoved(
                $request->position,
                $request->document_id
            ))->toOthers();

            return response()->json([
                'status' => 'ok'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 500);

        }
    }

    // =========================
    // VERSION HISTORY
    // =========================
    public function history($id)
    {
        $versions = DocumentVersion::where(
            'document_id',
            $id
        )
        ->latest()
        ->get();

        return view(
            'history',
            compact('versions')
        );
    }

    // =========================
    // EDIT LOGS
    // =========================
    public function logs($id)
    {
        $logs = EditLog::where(
            'document_id',
            $id
        )
        ->latest()
        ->get();

        return view(
            'logs',
            compact('logs')
        );
    }
}