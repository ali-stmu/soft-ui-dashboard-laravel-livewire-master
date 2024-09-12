<div>
    <div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="department-name" class="form-control-label">Department Name</label>
                    <input wire:model="name" class="form-control @error('name') border border-danger @enderror"
                        type="text" placeholder="Department Name" id="department-name">
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="type-id" class="form-control-label">Type</label>
                    <select wire:model="type" class="form-control @error('type') border border-danger @enderror"
                        id="type-id">
                        <option value="">Select Type</option>
                        <option value="Academic">Academic</option>
                        <option value="Non-Academic">Non-Academic</option>
                    </select>
                    @error('type')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="faculty-id" class="form-control-label">Faculty</label>
            <select wire:model="facultyId"
                class="form-control select2 @error('facultyId') border border-danger @enderror" id="faculty-id">
                <option value="">Select Faculty</option>
                @foreach ($faculties as $faculty)
                    <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                @endforeach
            </select>
            @error('facultyId')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


        <button wire:click="saveDepartment" class="btn btn-primary">Save Department</button>
    </div>

    <div class="row mt-4">
        <div class="col-6">
            <input wire:model.debounce.300ms="search" type="text" class="form-control"
                placeholder="Search Departments">
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Department table</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table id="department-table" class="table align-items-center justify-content-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        S/N
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Name
                                    </th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Type
                                    </th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Faculty Name
                                    </th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Created/Updated By
                                    </th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Time Stamp
                                    </th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($departments as $index => $department)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div class="my-auto">
                                                    <!-- Adjusted Serial number -->
                                                    <h6 class="mb-0 text-sm">
                                                        {{ ($departments->currentPage() - 1) * $departments->perPage() + $index + 1 }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div class="my-auto">
                                                    <h6 class="mb-0 text-sm">{{ $department->name }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div class="my-auto">
                                                    <h6 class="mb-0 text-sm">{{ $department->type }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div class="my-auto">
                                                    <h6 class="mb-0 text-sm">{{ $department->faculty->name }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div class="my-auto">
                                                    <h6 class="mb-0 text-sm">{{ $department->createdBy->name }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div class="my-auto">
                                                    <h6 class="mb-0 text-sm">
                                                        {{ \Carbon\Carbon::parse($department->updated_at)->addHours(5)->format('Y-m-d H:i:s') }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <button wire:click="edit({{ $department->id }})"
                                                    class="btn btn-sm btn-primary me-2">
                                                    Edit
                                                </button>

                                                <button wire:click="delete({{ $department->id }})"
                                                    class="btn btn-sm btn-danger">
                                                    Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>


                        <div class="mt-3">
                            {{ $departments->links() }} <!-- Pagination links -->
                        </div>
                    </div>
                </div>
            </div>
            <script>
                document.addEventListener('livewire:load', function() {
                    // Initialize select2 for the Faculty dropdown
                    $('#faculty-id').select2({
                        placeholder: "Select Faculty",
                        allowClear: true
                    }).on('change', function() {
                        @this.set('facultyId', $(this).val());
                    });
                });

                document.addEventListener('livewire:update', function() {
                    // Re-initialize select2 after Livewire updates
                    $('#faculty-id').select2({
                        allowClear: true
                    });
                });
            </script>

        </div>
    </div>
</div>
