<?php

namespace App\Http\Livewire\Admin\Other;

use App\Models\Bilta\Click;
use App\Models\NewsletterSubscriber;
use App\Models\SponsorInquiry;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;
use Livewire\WithPagination;

class ShowFrontRequests extends Component
{
    use WithPagination;

    public $newsletterCount = 0;
    public $sponsorInquiryCount = 0;
    public $donationClicks = 0;
    public $donationAmount = 0;
    public $donationTracked = false;

    public function render()
    {
        $this->newsletterCount = NewsletterSubscriber::count();
        $this->sponsorInquiryCount = SponsorInquiry::count();

        $this->donationClicks = Click::query()
            ->where(function ($q) {
                $q->where('url', 'like', '%paypal%')
                    ->orWhere('url', 'like', '%donat%')
                    ->orWhere('referrer', 'like', '%paypal%')
                    ->orWhere('referrer', 'like', '%donat%');
            })
            ->count();

        if (Schema::hasTable('donations') && Schema::hasColumn('donations', 'amount')) {
            $this->donationTracked = true;
            $this->donationAmount = (float) DB::table('donations')->sum('amount');
        } else {
            $this->donationTracked = false;
            $this->donationAmount = 0;
        }

        $newsletterSubscribers = NewsletterSubscriber::query()
            ->latest()
            ->paginate(15, ['*'], 'newsletterPage');

        $sponsorInquiries = SponsorInquiry::query()
            ->latest()
            ->paginate(15, ['*'], 'sponsorPage');

        return view('livewire.admin.other.front-requests', compact('newsletterSubscribers', 'sponsorInquiries'));
    }
}
