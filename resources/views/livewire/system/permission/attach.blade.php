

<!-- Modal -->
<div wire:ignore.self class="modal fade" id="permissionModal" tabindex="-1" role="dialog" aria-labelledby="permissionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="permissionModalLabel">Attach Permission</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <form>
            <div class="modal-body">

{{--                <div class="col-md-12">--}}
{{--                    <div class="form-group">--}}
{{--                        <label for="fam_other_name">Roles </label>--}}
{{--                        <select class="form-control" id="permission_id" name="permission_id" >--}}
{{--                            <option value="">--CHOOSE--</option>--}}
{{--                            @foreach($all_permissions as $permission)--}}
{{--                                <option value="{{$permission->id}}">{{$permission->name}}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                    </div>--}}
{{--                </div>--}}

                <table class="table" id="myTable">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Slug</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($all_permissions as $permission)
                        <tr>
                            <td><input type="checkbox" wire:model="selectedPermissions" id="permission_id[]"
                                       value="{{$permission->id}}"></td>
                            <td>{{$permission->name}}</td>
                            <td>{{$permission->slug}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                @if(sizeof($all_permissions ) > 0)
                    @if(sizeof($selectedPermissions) > 0)
                <button  wire:click.prevent="attachPermission()"  class="btn btn-primary close-modal">Attach </button>
                @endif
                @endif
            </div>
            </form>
        </div>
    </div>
</div>

