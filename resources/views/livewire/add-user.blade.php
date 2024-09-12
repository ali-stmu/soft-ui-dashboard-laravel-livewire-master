<div>
    @if ($message)
        <div id="responseMessage" class="alert alert-success" role="alert">
            {{ $message }}
        </div>
    @endif
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="name" class="form-control-label">Name</label>
                <input wire:model="name" class="form-control @error('name') border border-danger @enderror" type="text"
                    placeholder="Name" id="name">
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="email" class="form-control-label">Email</label>
                <input wire:model="email" class="form-control @error('email') border border-danger @enderror"
                    type="email" placeholder="Email" id="email">
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col">
            <div class="form-group">
                <label for="department" class="form-control-label">Department</label>
                <select wire:model="departmentId"
                    class="form-control select2 @error('departmentId') border border-danger @enderror" id="department">
                    <option value="">Select Department</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
                @error('departmentId')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="designation" class="form-control-label">Designation</label>
                <select wire:model="designationId"
                    class="form-control select2 @error('designationId') border border-danger @enderror"
                    id="designation">
                    <option value="">Select Designation</option>
                    @foreach ($designations as $designation)
                        <option value="{{ $designation->id }}">{{ $designation->name }}</option>
                    @endforeach
                </select>
                @error('designationId')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label for="role" class="form-control-label">Role</label>
            <select wire:model="roleId" class="form-control select2 @error('roleId') border border-danger @enderror"
                id="role">
                <option value="">Select Role</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
            @error('roleId')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>


    <div class="col">
        <button wire:click="saveUser" class="btn btn-primary">Save</button>
    </div>
    <div class="row">
        <div class="row mb-4">
            <div class="col-md-6">
                <input wire:model.debounce.300ms="searchTerm" type="text" class="form-control"
                    placeholder="Search users...">
            </div>
        </div>
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Users table</h6>
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
                                        Email</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Department</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Designation</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Role
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
                                @foreach ($users as $index => $user)
                                    <tr @if ($user->status == 'inactive') style="opacity: 0.9" @endif>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div class="my-auto">
                                                    <!-- Adjusted Serial number -->
                                                    <h6 class="mb-0 text-sm">
                                                        {{ ($users->currentPage() - 1) * $users->perPage() + $index + 1 }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div class="my-auto">
                                                    <h6 class="mb-0 text-sm">{{ $user->name }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div class="my-auto">
                                                    <h6 class="mb-0 text-sm">{{ $user->email }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div class="my-auto">
                                                    <h6 class="mb-0 text-sm">
                                                        {{ $user->department ? $user->department->name : '--' }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div class="my-auto">
                                                    <h6 class="mb-0 text-sm">
                                                        {{ $user->designation ? $user->designation->name : '--' }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div class="my-auto">
                                                    <h6 class="mb-0 text-sm"
                                                        style="color: {{ $user->status === 'active' ? 'green' : 'red' }}">
                                                        {{ $user->status }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div class="my-auto">
                                                    <h6 class="mb-0 text-sm">
                                                        {{ $user->role ? $user->role->name : '--' }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div class="my-auto">
                                                    <h6 class="mb-0 text-sm">
                                                        {{ $user->createdBy ? $user->createdBy->name : '--' }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div class="my-auto">
                                                    <h6 class="mb-0 text-sm">
                                                        {{ \Carbon\Carbon::parse($user->updated_at)->addHours(5)->format('Y-m-d H:i:s') }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <!-- Edit button -->
                                            <button wire:click="editUser({{ $user->id }})"
                                                class="btn btn-sm btn-info" title="Edit">Edit</button>

                                            <!-- Enable/Disable buttons based on status -->
                                            @if ($user->status == 'inactive')
                                                <button wire:click="enableUser({{ $user->id }})"
                                                    class="btn btn-sm btn-success" title="Enable">
                                                    Enable
                                                </button>
                                            @else
                                                <button wire:click="disableUser({{ $user->id }})"
                                                    class="btn btn-sm btn-danger" title="Disable">
                                                    Disable
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('livewire:load', function() {
            // Function to initialize select2
            function initializeSelect2(selector, model) {
                $(selector).select2({
                    placeholder: "Select " + model,
                    allowClear: true
                }).on('change', function() {
                    @this.set(model + 'Id', $(this).val());
                });
            }

            // Initialize select2 for designation, department, and role
            initializeSelect2('#designation', 'designation');
            initializeSelect2('#department', 'department');
            initializeSelect2('#role', 'role');
        });

        document.addEventListener('livewire:update', function() {
            // Re-initialize select2 after Livewire updates
            $('#designation, #department, #role').select2({
                allowClear: true
            });
        });

        document.addEventListener('livewire:load', function() {
            Livewire.on('userStatusChanged', () => {
                location.reload();
            });
        });
    </script>



</div>
