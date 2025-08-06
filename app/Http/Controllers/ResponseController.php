<?php

namespace App\Http\Controllers;

use App\Http\Requests\RespondComment;
use Illuminate\Http\Request;
use App\Models\Response;
use App\Models\Comment;
class ResponseController extends Controller
{
    public function store(RespondComment $request)
{
    // Simpan file jika ada
    // $uploadPath = $request->handleUpload();
// untuk nulll
    $uploadPath = $request->hasFile('upload')
        ? $request->handleUpload()
        : null;

    // Simpan ke database
    Response::create([
        'message' => $request->validated()['message'],
        'upload' => $uploadPath,

        'comment_id' => $request->validated()['comment_id'],
        'user_id' => auth()->id(),
    ]);
    $comment = Comment::findOrFail($request->validated()['comment_id']);

    // Pastikan bahwa comment tersebut memiliki relasi tiket yang valid
    if ($comment->tiket) {
        $comment->tiket->update([
            'status' => 'resolved' // Update status tiket menjadi 'resolved'
        ]);
    }


    // untuk mengupdate status tiket

    return back()->with('success', 'Respon berhasil dikirim.');
}

public function destroy($id)
{
    $response = Response::findOrFail($id);
    $response->delete();
    return redirect()->back()->with('success', 'Response has been deleted successfully!');
}

}
