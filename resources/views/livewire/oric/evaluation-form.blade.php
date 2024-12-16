<div class="container my-4">
    <h1 class="mb-4 text-center">Evaluation Form</h1>
    <hr class="my-5">

    <h2 class="text-center">Grading Scale</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th class="text-start">Score</th>
                    <th class="text-start">Description</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($gradingScale as $grade)
                    <tr>
                        <td class="text-start">{{ $grade['score'] }}</td>
                        <td class="text-start">{{ $grade['description'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <hr class="my-5">
    <form wire:submit.prevent="submit">
        @foreach ($criteria as $index => $criterion)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $criterion['name'] }}</h5>
                    <p class="card-text">{{ $criterion['description'] }}</p>
                    <div class="mb-3">
                        <label for="score-{{ $index }}" class="label">Score (1-7)</label>
                        <select class="form-control" id="score-{{ $index }}"
                            wire:model="criteria.{{ $index }}.score" required>
                            <option value="">Select Score</option>
                            @for ($i = 1; $i <= 7; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="comments-{{ $index }}" class="label">Comments</label>
                        <textarea class="form-control" id="comments-{{ $index }}" rows="3"
                            wire:model="criteria.{{ $index }}.comments"></textarea>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="text-end">
            <button type="submit" class="btn btn-primary">Submit Evaluation</button>
        </div>
    </form>
</div>
