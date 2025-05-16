<div class="container my-5">
    <h2 class="text-center text-uppercase mb-4">Weekly Prayer Points</h2>

    <!-- Filters and Search -->
    <div class="row mb-4 align-items-center">
        <div class="col-md-2">
            <input type="date" name="start_date" id="start_date" class="form-control" wire:model="start_date">
        </div>
        <div class="col-md-2">
            <input type="date" name="end_date" id="end_date" class="form-control" wire:model="end_date">
        </div>
        <div class="col-md-2">
            <button wire:click="search()" class="btn btn-primary w-100">Filter</button>
        </div>
        <div class="col-md-4 offset-md-2">
            <input type="text" id="prayerSearch" class="form-control" placeholder="Search prayer points...">
        </div>
    </div>

    <!-- Stats -->
    <div class="mb-4">
        <span class="badge bg-info text-dark">Total Prayer Points: <strong id="totalCounter">{{ count($dataset) }}</strong></span>
    </div>

    <!-- Prayer Points & Image -->
    <div class="row">
        <div class="col-md-8">
            <div class="accordion" id="prayerAccordion">
                @foreach($dataset as $key => $item)
                    <div class="accordion-item prayer-item">
                        <h2 class="accordion-header" id="heading{{$key}}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{$key}}" aria-expanded="false"
                                    aria-controls="collapse{{$key}}">
                                {{ $item->title }}
                            </button>
                        </h2>
                        <div id="collapse{{$key}}" class="accordion-collapse collapse"
                             aria-labelledby="heading{{$key}}" data-bs-parent="#prayerAccordion">
                            <div class="accordion-body">
                                <p>{{ $item->details }}</p>
                                @if($item->scriptures)
                                    <strong>Scriptures:</strong> <em>{{ $item->scriptures }}</em>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="col-md-4 text-center">
            <div id="prayerImageCarousel" class="carousel slide rounded shadow-sm" data-bs-ride="carousel" data-bs-interval="3000">
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=600&q=80" class="d-block w-100 rounded" alt=" Prayer 1">
                </div>
                <div class="carousel-item">
                  <img src="https://images.unsplash.com/photo-1534972195535-4972dbb6b330?auto=format&fit=crop&w=600&q=80" class="d-block w-100 rounded" alt=" Prayer 2">
                </div>
                <div class="carousel-item">
                  <img src="https://images.unsplash.com/photo-1470770841072-f978cf4d019e?auto=format&fit=crop&w=600&q=80" class="d-block w-100 rounded" alt=" Prayer 3">
                </div>
                <div class="carousel-item">
                  <img src="https://images.unsplash.com/photo-1508193638399-82c52a32d81b?auto=format&fit=crop&w=600&q=80" class="d-block w-100 rounded" alt=" Prayer 4">
                </div>
              </div>
            </div>
          </div>
          

    </div>
</div>
