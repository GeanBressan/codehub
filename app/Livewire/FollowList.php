<?php

namespace App\Livewire;

use Livewire\Component;

class FollowList extends Component
{
    public $user;
    public $followers;

    protected $listeners = ['followed' => 'updateFollowersList', 'unfollowed' => 'updateFollowersList'];

    public function mount($user)
    {
        $this->user = $user;
        $this->followers = $user->followers()->get();
    }

    public function render()
    {
        return view('livewire.follow-list', [
            'followers' => $this->followers,
        ]);
    }

    public function updateFollowersList()
    {
        $this->followers = $this->user->followers()->get();
        $this->dispatch('updateFollowersList');
    }
}
