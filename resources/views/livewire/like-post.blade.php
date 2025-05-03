<div>
    <a href="#" class="text-sm hover:text-emerald-600 {{ $isLiked ? 'text-emerald-600' : 'text-gray-500' }}" wire:click.prevent="like"><i class="fas fa-heart mr-1"></i>
        <span class="font-semibold">{{ $likes }}</span></a>
</div>
