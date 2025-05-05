<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Post;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Comments extends Component
{
    public $post;

    public $content;

    public function mount($postId)
    {
        $this->post = Post::find($postId);
    }

    public function render()
    {
        return view('livewire.comments', [
            'comments' => $this->post->comments()->with('user')->latest()->get(),
            'commentsCount' => $this->post->comments()->count(),
        ]);
    }

    public function addComment()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login.form');
        }

        $this->validate([
            'content' => 'required|string|max:255',
        ], [
            'content.required' => 'O campo comentário é obrigatório.',
            'content.string' => 'O campo comentário deve ser uma string.',
            'content.max' => 'O campo comentário não pode ter mais de 255 caracteres.',
        ]);

        Comment::create([
            'user_id' => $user->id,
            'post_id' => $this->post->id,
            'content' => $this->content,
        ]);

        $this->comments = $this->post->comments()->with('user')->latest()->get();

        $this->reset('content');
        session()->flash('message', 'Comentário adicionado com sucesso!');
    }

    public function deleteComment($commentId)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login.form');
        }

        $comment = Comment::find($commentId);

        if ($comment && $comment->user_id === $user->id) {
            $comment->delete();
            session()->flash('message', 'Comentário removido com sucesso!');
        } else {
            session()->flash('error', 'Você não pode excluir este comentário.');
        }
    }
}
