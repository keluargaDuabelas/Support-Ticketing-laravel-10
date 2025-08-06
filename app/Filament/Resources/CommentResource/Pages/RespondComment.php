<?php

namespace App\Filament\Resources\CommentResource\Pages;

use App\Filament\Resources\CommentResource;
use Filament\Resources\Pages\Page;
use App\Models\Comment;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Illuminate\Contracts\View\View;
class RespondComment extends Page
{

    protected static string $resource = CommentResource::class;

    use HasPageShield;

    protected static string $view = 'filament.resources.comment-resource.pages.respond-comment';

    public Comment $comment;
    public string $message = '';
    public $upload;





    public function mount($record)
    {

        $this->comment = Comment::findOrFail($record);

    }




    public function sendResponse()
    {
        $this->validate([
            'message' => 'required|string|max:255',
            'upload' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
        ]);

        $uploadPath = null;
        if ($this->upload) {
            $uploadPath = $this->upload->store('uploads/responses', 'public');
        }

        $this->comment->responses()->create([


            'username' => auth()->user()->name,

            'message' => $this->message,
            'upload' => $uploadPath,
        ]);



        $this->message = '';
        $this->upload = null;

        session()->flash('success', 'Balasan berhasil dikirim!');
    }
}
