<div>
    <form wire:submit.prevent="save">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="title">{{ __('Title/Subject') }}</label>
                    <input wire:model="title" type="text" class="form-control" id="title"
                        placeholder="Enter title/subject">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="description">{{ __('Description') }}</label>
                    <textarea wire:model="description" class="form-control" id="description" rows="1" placeholder="Enter description"></textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="dispatch_date">{{ __('Dispatch Date') }}</label>
                    <input wire:model="dispatch_date" type="date" class="form-control" id="dispatch_date">
                    @error('dispatch_date')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">

                    <label for="dispatcher_id">{{ __('Dispatcher') }}</label>
                    <select wire:model="dispatcher_id" class="form-control select2" id="dispatcher_id">
                        <option value="">Select Dispatcher</option>
                        @if ($dispatchers)
                            @foreach ($dispatchers as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        @endif
                        <option value="other">Other</option>
                    </select>
                    @error('dispatcher_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>


            <!-- Textbox to input custom dispatcher name -->
            @if ($dispatcher_id === 'other')
                <div class="form-group">
                    <label for="custom_dispatcher">{{ __('Custom Dispatcher Name') }}</label>
                    <input wire:model="custom_dispatcher" type="text" class="form-control" id="custom_dispatcher"
                        placeholder="Enter custom dispatcher name">
                    @error('custom_dispatcher')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            @endif


        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="attachment">{{ __('Attachment') }}</label>
                    <input wire:model="attachment" type="file" class="form-control-file" id="attachment">
                    @error('attachment')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <h5>Requested To:</h5>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="department" class="form-control-label">Department</label>
                    <select wire:model="departmentId"
                        class="form-control select2 @error('departmentId') border border-danger @enderror"
                        id="department">
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
            {{-- <div class="col-md-4">
                <div class="form-group">
                    <label for="role" class="form-control-label">Role</label>
                    <select wire:model="roleId"
                        class="form-control select2  @error('roleId') border border-danger @enderror" id="role">
                        <option value="">Select Role</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('roleId')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div> --}}
            <div class="col-md-4">
                <div class="form-group">
                    <label for="user" class="form-control-label">Employee</label>
                    <select wire:model="userId"
                        class="form-control select2  @error('userId') border border-danger @enderror" id="user">
                        <option value="">Select Employee</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('userId')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>


        <x-bladewind::button outline="true" color="red" radius="small"
            can_submit="true">{{ __('Submit') }}</x-bladewind::button>

    </form>
    <br>

    <table class="table">
        <input type="text" wire:model.debounce.300ms="search" placeholder="Search documents..."
            class="form-control mb-3">
        <thead>
            <tr>
                <th>#</th> <!-- Column for Serial Number -->
                <th>ID</th> <!-- New column for ID -->
                <th>Title</th>
                <th>Description</th>
                <th>Attachment</th>
                <th>Dispatch Date</th>
                <th>Dispatcher</th>
                <th>Requested To</th>
                <th>Approved Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($documents as $index => $document)
                <tr>
                    <td>{{ ($documents->currentPage() - 1) * $documents->perPage() + $index + 1 }}</td>
                    <!-- Serial number based on iteration -->
                    <td>{{ $document->id }}</td> <!-- Display document ID -->
                    <td>{{ $document->title }}</td>
                    <td>{{ $document->description }}</td>
                    <td>
                        @if ($document->attachment)
                            <a href="{{ asset('storage/' . $document->attachment) }}" target="_blank">View
                                Attachment</a>
                        @else
                            No attachment
                        @endif
                    </td>
                    <td>{{ $document->dispatch_date }}</td>
                    <td>{{ $document->dispatcher?->name ?? $document->dispatcher_name }}</td>
                    <td>{{ $document->user?->name ?? '--' }}</td> <!-- Handling null user and null user name -->
                    <td>{{ $document->approved_date ?? '--' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $documents->links() }}

    @if (session()->has('message'))
        <div class="alert alert-success mt-3">
            {{ session('message') }}
        </div>
    @endif
    <script>
        document.addEventListener('livewire:load', function() {
            // Function to initialize select2
            function initializeSelect2(selector, model) {
                $(selector).select2({
                    placeholder: "Select " + model.charAt(0).toUpperCase() + model.slice(1),
                    allowClear: true
                }).on('change', function() {
                    @this.set(model + 'Id', $(this).val());
                });
            }

            // Initialize select2 for designation, department, and role
            initializeSelect2('#designation', 'designation');
            initializeSelect2('#department', 'department');
            initializeSelect2('#role', 'role');
            initializeSelect2('#user', 'user');

            // Add other dropdowns as needed
        });

        document.addEventListener('livewire:update', function() {
            // Re-initialize select2 after Livewire updates
            $('#designation, #department, #role,#user').select2({
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
