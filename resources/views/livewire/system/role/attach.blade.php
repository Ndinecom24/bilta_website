

<!-- Modal -->
<div wire:ignore.self class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="roleModalLabel">Attach Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <form>
            <div class="modal-body">

                <table class="table" id="myTable">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Slug</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($all_roles as $role)
                        <tr>
                            <td><input type="checkbox" wire:model="selectedRoles" id="role_id[]"
                                       value="{{$role->id}}"></td>
                            <td>{{$role->name}}</td>
                            <td>{{$role->slug}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                @if(sizeof($all_roles ) > 0)
                    @if(sizeof($selectedRoles) > 0)
                <button  wire:click.prevent="attachRole()"  class="btn btn-primary close-modal">Attach </button>
                @endif
                @endif
            </div>
            </form>
        </div>
    </div>
</div>

