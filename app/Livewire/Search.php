<?php

namespace App\Livewire;

use Livewire\Component;

class Search extends Component
{
    public $search = '';
    public $searchResults = [];

    public function render()
    {
        if (strlen($this->search) > 2) {
            $this->searchResults = \App\Models\Post::where('title', 'like', '%' . $this->search . '%')
                ->orWhere('content', 'like', '%' . $this->search . '%')
                ->orWhereHas('tags', function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('category', function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('user', function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                })
                ->with(['user', 'category', 'tags'])
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $this->searchResults = [];
        }

        // Limpa os resultados de pesquisa se a pesquisa estiver vazia
        if (empty($this->search)) {
            $this->searchResults = [];
        }

        return view('livewire.search', [
            'search' => $this->search,
            'searchResults' => $this->searchResults,
        ]);
    }
}
