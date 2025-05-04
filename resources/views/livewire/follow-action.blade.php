<div>
    <div class="mt-4">
        @if ($isFollowing)
            <a href="#" class="text-sm text-gray-500 hover:text-emerald-600 mr-3" wire:click.prevent="toggleFollow"><i class="fas fa-user-minus mr-1"></i>Deixar de seguir</a>
        @else
            <a href="#" class="text-sm text-gray-500 hover:text-emerald-600 mr-3" wire:click.prevent="toggleFollow"><i class="fas fa-user-plus mr-1"></i>Seguir</a>
        @endif
    </div>
</div>