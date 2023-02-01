<div class="card" style="margin-top: 20px">
    <div class="card-header align-items-center d-flex">
        <div class="card-title mb-0 flex-grow-1 ">
            <div class="col-lg-3">
                <div class="gridjs-head input-group">
                    <span class="input-group-text" id="basic-addon1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg></span>
                    <input wire:model="search" type="text" class="form-control" placeholder="Type a keyword..." aria-label="Type a keyword..." aria-describedby="basic-addon1">
                </div>
            </div>
        </div>
        <div class="form-check form-switch mb-3 flex-shrink-0">
            <input class="form-check-input" type="checkbox" role="switch" wire:model="active" id="active" checked="">
            <label class="form-check-label" for="SwitchCheck1">Active?</label>
        </div>
    </div>

    <div class="card-body">
        <div class="live-preview">
            <div class="table-responsive">
                <table class="table align-middle table-nowrap mb-0">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Skill</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($skills as $skill)
                            <tr>
                                <th scope="row">{{ $skill->id }}</th>
                                <td>{{ $skill->description }}</td>
                                @if($skill->trashed())
                                    <td><span class="badge bg-danger">Deleted</span></td>
                                    <td>
                                        <div class="hstack gap-3 flex-wrap">
                                            <a role="button" wire:click="$emit('activateElement',{{ $skill->id }})" class="link-primary fs-15">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-ccw"><polyline points="1 4 1 10 7 10"></polyline><polyline points="23 20 23 14 17 14"></polyline><path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path></svg>
                                            </a>
                                        </div>
                                    </td>
                                @else
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>
                                        <div class="hstack gap-3 flex-wrap">
                                            <a role="button" wire:click="$emit('setEditElement',{{ $skill->id }})" class="link-success fs-15">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                            </a>
                                            <a role="button" wire:click="$emit('deleteElement',{{ $skill->id }})" class="link-danger fs-15">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                            </a>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="margin-top: 20px">
                {{ $skills->links() }}
            </div>
        </div>
    </div><!-- end card-body -->
</div>
