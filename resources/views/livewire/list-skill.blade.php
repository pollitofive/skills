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
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($skills as $skill)
                            <tr>
                                <th scope="row">{{ $skill->id }}</th>
                                <td>{{ $skill->description }}</td>
                                @if($skill->trashed())
                                    <td><span class="badge bg-danger">Deleted</span></td>
                                @else
                                    <td><span class="badge bg-success">Active</span></td>
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
