<?php

namespace App\Http\Livewire\Site;

use App\Models\Bilta\Gallery;
use Livewire\Component;
use Livewire\WithPagination;

class ShowGallery extends Component
{
    use WithPagination;

    public function render()
    {
        $gallery_items = Gallery::with('category')->get();
        $categories = $gallery_items
            ->pluck('category')
            ->filter()
            ->unique('id')
            ->values();

        return view('livewire.site.show-gallery')->with(compact('gallery_items', 'categories'));
    }
}
