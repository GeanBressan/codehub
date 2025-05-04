<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SavePost extends Component
{
    public $postId;

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount($postId)
    {
        $this->postId = $postId;
    }
    public function render()
    {
        $user = Auth::user();

        if (!$user) {
            return view('livewire.save-post', [
                'isSaved' => false,
            ]);
        }

        $isSaved = $user->savedPosts()->where('post_id', $this->postId)->exists();

        return view('livewire.save-post', [
            'isSaved' => $isSaved,
        ]);
    }

    public function save()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->savedPosts()->where('post_id', $this->postId)->exists()) {
            $user->savedPosts()->detach($this->postId);
        } else {
            $user->savedPosts()->attach($this->postId);
        }

        $this->dispatch('postSaved', $this->postId);
    }
}
