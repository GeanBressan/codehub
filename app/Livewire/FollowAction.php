<?php

namespace App\Livewire;

use Livewire\Component;

class FollowAction extends Component
{
    public $user;
    public $isFollowing = false;
    public function render()
    {
        return view('livewire.follow-action', [
            'isFollowing' => $this->isFollowing,
        ]);
    }

    public function mount($user)
    {
        $this->user = $user;
        $this->isFollowing = auth()->user()->isFollowing($this->user->id);
    }

    public function toggleFollow()
    {
        $loggedInUser = auth()->user();

        if ($loggedInUser->id === $this->user->id) {
            return;
        }

        if ($this->isFollowing) {
            $loggedInUser->following()->detach($this->user);

            $this->isFollowing = false;

            $this->dispatch('unfollowed', [
                'user' => $this->user,
            ]);
        } else {
            $loggedInUser->following()->attach($this->user);

            $this->isFollowing = true;

            $this->dispatch('followed', [
                'user' => $this->user,
            ]);
        }
    }
}
