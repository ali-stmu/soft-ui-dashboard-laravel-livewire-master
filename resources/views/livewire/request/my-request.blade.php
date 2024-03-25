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
                    <label for="attachment">{{ __('Attachment') }}</label>
                    <input wire:model="attachment" type="file" class="form-control-file" id="attachment">
                    @error('attachment')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">

        </div>
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </form>
    @if (session()->has('message'))
        <div class="alert alert-success mt-3">
            {{ session('message') }}
        </div>
    @endif
</div>
