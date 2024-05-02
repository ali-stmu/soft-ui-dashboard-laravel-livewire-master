<div>
    <form wire:submit.prevent="save">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="title">{{ __('Title') }}</label>
                    <input wire:model="title" type="text" class="form-control" id="title" placeholder="Enter title">
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
                    <select wire:model="dispatcher_id" class="form-control" id="dispatcher_id">
                        <option value="">Select Dispatcher</option>
                        @if ($dispatchers)
                            @foreach ($dispatchers as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        @else
                            <option value="" disabled>No dispatchers available</option>
                        @endif
                    </select>
                    @error('dispatcher_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
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
            <div class="col">
                <div class="form-group">
                    <label for="department" class="form-control-label">Department</label>
                    <select wire:model="departmentId"
                        class="form-control @error('departmentId') border border-danger @enderror" id="department">
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
                    <label for="role" class="form-control-label">Role</label>
                    <select wire:model="roleId" class="form-control @error('roleId') border border-danger @enderror"
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
                <div class="form-group">
                    <label for="user" class="form-control-label">User</label>
                    <select wire:model="userId" class="form-control @error('userId') border border-danger @enderror"
                        id="user">
                        <option value="">Select User</option>
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
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </form>
    <table class="table">
        <thead>
            <tr>
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
            @foreach ($documents as $document)
                <tr>
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
                    <td>{{ $document->dispatcher->name }}</td> <!-- Assuming dispatcher relation exists -->
                    <td>{{ $document->user->name }}</td> <!-- Assuming dispatcher relation exists -->
                    <td>{{ $document->approved_date ?: '--' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if (session()->has('message'))
        <div class="alert alert-success mt-3">
            {{ session('message') }}
        </div>
    @endif
</div>
