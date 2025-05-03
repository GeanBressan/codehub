<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use App\Models\User;
use App\Models\PostLike;
use Illuminate\Support\Facades\Auth;

class LikePost extends Component
{
    public $likes = 0;
    public $postId;

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount($postId)
    {
        $this->postId = $postId;
    }

    public function render()
    {
        $this->likes = PostLike::where('post_id', $this->postId)->count();

        $user = Auth::user();

        if (!$user) {
            return view('livewire.like-post', [
                'likes' => $this->likes,
                'isLiked' => false,
            ]);
        }
        
        $isLiked = $user->likedPosts()->where('post_id', $this->postId)->exists();

        return view('livewire.like-post', [
            'likes' => $this->likes,
            'isLiked' => $isLiked,
        ]);
    }

    public function like()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->likedPosts()->where('post_id', $this->postId)->exists()) {
            $user->likedPosts()->detach($this->postId);
        } else {
            $user->likedPosts()->attach($this->postId);
        }

        $this->dispatch('postLiked', $this->postId);
    }
}
