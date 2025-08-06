<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Gate;



class CommentController extends Controller
{
    //

    public function respond($record)
    {
        $comment = Comment::where('id', $record)->firstOrFail();

        if (Gate::denies('respond', $comment)) {
            abort(403, 'You are not authorized to perform this action.');
        }

        return view('filament.resources.comment-resource.pages.respond-comment', compact('comment'));
    }
public function sendResponse(Request $request, $id)
{
    $request->validate([
        'message' => 'required|string|max:255',
    ]);

    $comment = Comment::findOrFail($id);

    // Simpan balasan baru
    $comment->responses()->create([
        'user_id' => auth()->id(),
        'message' => $request->message,
    ]);

    return redirect()->route('comments.respond', $id)->with('success', 'Balasan berhasil dikirim.');
}
}
