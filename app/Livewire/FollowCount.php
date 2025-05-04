<?php

namespace App\Livewire;

use Livewire\Component;

class FollowCount extends Component
{
    public $user;

    protected $listeners = ['followed' => 'updateFollowersCount', 'unfollowed' => 'updateFollowersCount'];

    public function mount($user)
    {
        $this->user = $user;
    }

    public function render()
    {
        $followersCount = $this->user->followers()->count();

        return view('livewire.follow-count', [
            'followersCount' => $followersCount,
            'username' => $this->user->username,
        ]);
    }

    public function updateFollowersCount()
    {
        $this->dispatch('updateFollowersCount');
    }
}
