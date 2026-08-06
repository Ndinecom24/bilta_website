<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h4 mb-1 text-dark">Front-end Requests</h1>
            <p class="text-muted mb-0">Newsletter subscriptions, partner inquiries, and donation tracking summary.</p>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted text-uppercase small font-weight-bold mb-1">Newsletter Subscriptions</div>
                    <div class="h3 mb-0">{{ $newsletterCount }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted text-uppercase small font-weight-bold mb-1">Partner Inquiries</div>
                    <div class="h3 mb-0">{{ $sponsorInquiryCount }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted text-uppercase small font-weight-bold mb-1">Donations</div>
                    @if ($donationTracked)
                        <div class="h4 mb-0">Total: ${{ number_format($donationAmount, 2) }}</div>
                        <small class="text-muted">Tracked from donation records table.</small>
                    @else
                        <div class="h5 mb-1">Amount tracking unavailable</div>
                        <small class="text-muted">Donation amount table not found. Donation-intent clicks: {{ $donationClicks }}</small>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-5 mb-3">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Newsletter Subscribers</h5>
                    <span class="badge badge-light">{{ $newsletterCount }}</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Email</th>
                                    <th style="width: 140px;">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($newsletterSubscribers as $subscriber)
                                    <tr>
                                        <td>{{ $subscriber->email }}</td>
                                        <td>{{ optional($subscriber->created_at)->format('d M Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">No newsletter subscriptions yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $newsletterSubscribers->links() }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7 mb-3">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Partner Inquiries</h5>
                    <span class="badge badge-light">{{ $sponsorInquiryCount }}</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 150px;">Name</th>
                                    <th style="width: 190px;">Email</th>
                                    <th>Message</th>
                                    <th style="width: 140px;">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($sponsorInquiries as $inquiry)
                                    <tr>
                                        <td>{{ $inquiry->name }}</td>
                                        <td>{{ $inquiry->email }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($inquiry->message, 140) }}</td>
                                        <td>{{ optional($inquiry->created_at)->format('d M Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No partner inquiries yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $sponsorInquiries->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
