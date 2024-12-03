<div class="container">
    <h2>Manage Reviewers</h2>

    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <form>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Name:</label>
                    <input type="text" class="form-control" wire:model="name">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" class="form-control" wire:model="email">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Designation:</label>
                    <input type="text" class="form-control" wire:model="designation">
                    @error('designation')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Institute Name:</label>
                    <input type="text" class="form-control" wire:model="institute_name">
                    @error('institute_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Country:</label>
                    <input type="text" class="form-control" wire:model="country">
                    @error('country')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            @if (!$updateMode)
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Password:</label>
                        <input type="password" class="form-control" wire:model="password">
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            @endif
        </div>
        @if (!$updateMode)
            <button wire:click.prevent="store" class="btn btn-success">Save</button>
        @endif
        @if ($updateMode)
            <button wire:click.prevent="update" class="btn btn-warning">Update</button>
        @endif
    </form>

    <hr>

    <h4>List of Reviewers</h4>
    <div class="mb-3">
        <input type="text" wire:model="search" class="form-control" placeholder="Search by name or email...">
    </div>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Designation</th>
                <th>Institute</th>
                <th>Country</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reviewers as $reviewer)
                <tr>
                    <td>{{ $reviewer->name }}</td>
                    <td>{{ $reviewer->email }}</td>
                    <td>{{ $reviewer->designation }}</td>
                    <td>{{ $reviewer->institute }}</td>
                    <td>{{ $reviewer->country }}</td>
                    <td>
                        <button wire:click="edit({{ $reviewer->id }})" class="btn btn-primary">Edit</button>
                        <button wire:click="delete({{ $reviewer->id }})" class="btn btn-danger">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        {{ $reviewers->links() }} <!-- This generates the pagination links -->
    </div>
</div>
