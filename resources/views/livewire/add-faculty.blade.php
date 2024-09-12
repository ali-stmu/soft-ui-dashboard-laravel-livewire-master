<div>
    <p>Add Faculty</p>
    <form role="form text-left">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="faculty-name" class="form-control-label">{{ __('Faculty Name') }}</label>
                    <input wire:model="name" class="form-control @error('name') border border-danger @enderror"
                        type="text" placeholder="Faculty Name" id="faculty-name">
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="faculty-location" class="form-control-label">{{ __('Location') }}</label>
                    <input wire:model="location" class="form-control @error('location') border border-danger @enderror"
                        type="text" placeholder="Location" id="faculty-location">
                    @error('location')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <button wire:click.prevent="save" class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ __('Save') }}</button>
        </div>
    </form>

    <!-- Search Input -->
    <div class="row mb-4">
        <div class="col-12">
            <input wire:model="search" type="text" class="form-control" placeholder="Search faculties...">
        </div>
    </div>

    <!-- Faculty Table -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Faculty table</h6>
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
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Location</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Created/Updated By</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Time Stamp</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($faculties as $index => $faculty)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div class="my-auto">
                                                    <!-- Adjusted Serial number -->
                                                    <h6 class="mb-0 text-sm">
                                                        {{ ($faculties->currentPage() - 1) * $faculties->perPage() + $index + 1 }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div class="my-auto">
                                                    <h6 class="mb-0 text-sm">{{ $faculty->name }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div class="my-auto">
                                                    <h6 class="mb-0 text-sm">{{ $faculty->location }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div class="my-auto">
                                                    <h6 class="mb-0 text-sm">{{ $faculty->createdBy->name }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div class="my-auto">
                                                    <h6 class="mb-0 text-sm">
                                                        {{ \Carbon\Carbon::parse($faculty->updated_at)->addHours(5)->format('Y-m-d H:i:s') }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <button wire:click="edit({{ $faculty->id }})"
                                                    class="btn btn-sm btn-primary me-2">
                                                    Edit
                                                </button>

                                                <button wire:click="delete({{ $faculty->id }})"
                                                    class="btn btn-sm btn-danger">
                                                    Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination Links -->
                        <div class="d-flex justify-content-center mt-3">
                            {{ $faculties->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
