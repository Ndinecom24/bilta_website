<!-- Modal -->
<div wire:ignore.self class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-12">
                        <h5 class="modal-title" id="faqModalLabel">Update Item Category</h5>
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
                                <label for="faqFormControlInput1">Name</label>
                                <input type="text" class="form-control" id="faqFormControlInput1"
                                       placeholder="Enter Name" wire:model="name">
                                @error('name') <span class="text-danger ">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="faqFormControlInput2">Description</label>
                                <textarea rows="3" class="form-control" id="faqFormControlInput2" wire:model="description"
                                          placeholder="Enter Description"></textarea>
                                @error('description') <span
                                    class="form-check-label text-danger ">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="faqFormControlInput2">Type</label>
                                <select  required class="form-control" id="faqFormControlInput3" wire:model="type" >
                                    <option value="">--Choose--</option>
                                    <option value="News">News</option>
                                    <option value="Images">Images</option>
                                    <option value="Videos">Videos</option>
                                    <option value="Projects">Projects</option>
                                    <option value="Prayer Points">Prayer Points</option>
                                </select>
                                @error('type') <span
                                    class="form-check-label text-danger ">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="status_id">Status</label>
                                <select  class="form-control" id="status_id" wire:model="status_id" >
                                    @foreach($statuses as $status )
                                        <option value="{{$status->id}}">{{$status->name}}</option>
                                    @endforeach
                                </select>
                                @error('status_id') <span
                                    class="form-check-label text-danger ">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal-footer">
                    <button wire:click.prevent="update()" class="btn btn-success ">Save</button>
                    <button wire:click.prevent="cancel()"  data-dismiss="modal"  class="btn btn-danger">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>


