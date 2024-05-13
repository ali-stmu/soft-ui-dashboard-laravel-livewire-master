<div>
    <h2>Forward With Signature</h2>
    <p>Request ID: {{ $request->id }}</p>
    <div>
        <div>
            <div>
                <form>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col">
                                <label for="forwardwithsignremarks">Remarks</label>
                                <input wire:model.defer="forwardwithsignremarks" type="text" class="form-control"
                                    id="forwardwithsignremarks">
                                @error('forwardwithsignremarks')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="date">Return/Forward Date</label>
                                <input wire:model.defer="forwardwithsignreturnForwardDate" type="date"
                                    class="form-control" id="forwardwithsignreturnForwardDate">
                                @error('forwardwithsignreturnForwardDate')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <h5>Forwarded To:</h5>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="department" class="form-control-label">Department</label>
                                <select wire:model="departmentId"
                                    class="form-control @error('departmentId') border border-danger @enderror"
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
                        <div class="col">
                            <div class="form-group">
                                <label for="role" class="form-control-label">Role</label>
                                <select wire:model="roleId"
                                    class="form-control @error('roleId') border border-danger @enderror" id="role">
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
                                <select wire:model="userId"
                                    class="form-control @error('userId') border border-danger @enderror" id="user">
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
                    <x-bladewind::button type="submit" outline="true" color="red" text="white"
                        wire:click="forwardwithsignRequest">
                        Confirm
                    </x-bladewind::button>




                    {{-- <x-bladewind::button color="red" radius="small"
                        can_submit="true">{{ __('Sign in') }}</x-bladewind::button>
                    <button wire:click="forwardwithsignRequest" type="submit" class="btn btn-primary">Confirm</button> --}}
                </form>
            </div>
        </div>
    </div>
</div>
