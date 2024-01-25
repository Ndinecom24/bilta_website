<!-- Modal -->
<div wire:ignore.self class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="faqModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-12">
                        <h5 class="modal-question" id="faqModalLabel">Create Weekly Prayer Point</h5>
                    </div>
                    <div class="col-12">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if(session()->has('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session()->get('success') }}
                            </div>
                        @endif
                        @if(session()->has('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session()->get('error') }}
                            </div>
                        @endif
                    </div>
                </div>

            </div>
            <form>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="faqFormControlInput1">Title</label>
                                <input type="text" class="form-control" id="faqFormControlInput1"
                                          placeholder="Enter Title" wire:model="title">
                                @error('title') <span class="text-danger ">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="faqFormControlInput2">Details</label>
                                <textarea rows="3" class="form-control" id="faqFormControlInput2" wire:model="details"
                                          placeholder="Enter Details"></textarea>
                                @error('details') <span
                                    class="form-check-label text-danger ">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="faqFormControlInput3">Scriptures</label>
                                <textarea rows="3" class="form-control" id="faqFormControlInput3" wire:model="scriptures"
                                          placeholder="Enter Scriptures"></textarea>
                                @error('scriptures') <span
                                    class="form-check-label text-danger ">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="faqFormControlInput4">Post Date</label>
                                <input type="date" class="form-control" id="faqFormControlInput4" wire:model="post_date"
                                       placeholder="Enter Post Date">
                                @error('post_date') <span
                                    class="form-check-label text-danger ">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">v
                            <div class="form-group">
                                <label for="faqFormControlInput5">Status</label>
                                <select required type="date" class="form-control" id="faqFormControlInput5" wire:model="status_id" >
                                    <option>--Choose</option>
                                    @foreach($statuses as $status)
                                        <option value="{{$status->id}}" >{{$status->name}}</option>
                                    @endforeach
                                </select>
                                @error('status_id') <span
                                    class="form-check-label text-danger ">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                    <button wire:click.prevent="store()" class="btn btn-primary close-modal">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

