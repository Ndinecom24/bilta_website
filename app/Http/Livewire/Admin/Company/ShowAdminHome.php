<?php

namespace App\Http\Livewire\Admin\Company;

use App\Models\Bilta\HomeIntro;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ShowAdminHome extends Component
{

    public function render()
    {
       return view('livewire.admin.home-page.show-home');
    }


}
