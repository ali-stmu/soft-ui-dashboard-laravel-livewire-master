<div>
    <div>
        <div class="col">
            <div class="form-group">
                <label for="designation-name" class="form-control-label">Designation Name</label>
                <input wire:model="name" class="form-control @error('name') border border-danger @enderror" type="text"
                    placeholder="Designation Name" id="designation-name">
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <button wire:click="save" class="btn btn-primary">Save</button>
    </div>

    <div class="row mt-4">
        <div class="col-6">
            <input wire:model.debounce.300ms="search" type="text" class="form-control"
                placeholder="Search Designations">
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Designation table</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center justify-content-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">S/N
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Created/Updated By</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Time
                                        Stamp</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($designations as $index => $designation)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div class="my-auto">
                                                    <!-- Adjusted Serial number -->
                                                    <h6 class="mb-0 text-sm">
                                                        {{ ($designations->currentPage() - 1) * $designations->perPage() + $index + 1 }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div class="my-auto">
                                                    <h6 class="mb-0 text-sm">{{ $designation->name }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div class="my-auto">
                                                    <h6 class="mb-0 text-sm">{{ $designation->createdBy->name }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div class="my-auto">
                                                    <h6 class="mb-0 text-sm">
                                                        {{ \Carbon\Carbon::parse($designation->updated_at)->addHours(5)->format('Y-m-d H:i:s') }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div class="my-auto">
                                                    <button wire:click="edit({{ $designation->id }})"
                                                        class="btn btn-sm btn-primary">Edit</button>
                                                    <button wire:click="delete({{ $designation->id }})"
                                                        class="btn btn-sm btn-danger">Delete</button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-3">
                            {{ $designations->links() }} <!-- Pagination links -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
