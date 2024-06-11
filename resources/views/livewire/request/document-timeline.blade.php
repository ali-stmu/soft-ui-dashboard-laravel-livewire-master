<div class="container">
    <div class="row">
        <div class="col-md-12">
            <x-bladewind::timeline-group align_left="true" position="left" anchor="big" stacked="true">

                @foreach ($documentTimeline as $key => $documentData)
                    @php
                        // Generate a random color for each document
                        $colors = ['orange', 'green', 'purple', 'gray', 'pink', 'blue'];
                        $randomColor = $colors[array_rand($colors)];
                    @endphp
                    <x-bladewind::timeline-group color="{{ $randomColor }}">
                        <x-bladewind::timeline date="{{ $documentData['document']['created_at']->diffForHumans() }}">
                            <x-slot:content>
                                <ul>
                                    <li>
                                        <strong>Title:</strong> {{ $documentData['document']['title'] }}
                                    </li>

                                    <li><strong>Description:</strong> {{ $documentData['document']['description'] }}
                                    </li>
                                    <li><strong>Initiated By:</strong> {{ $documentData['document']['initiator'] }}</li>
                                    <hr>
                                    <x-bladewind::timeline-group>
                                        @foreach ($documentData['approvalRequests'] as $approvalRequest)
                                            <x-bladewind::timeline
                                                date="{{ $approvalRequest['created_at']->diffForHumans() }}">
                                                <x-slot:content>
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <strong class="index-number">{{ $loop->iteration }}</strong>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <strong>Assigned By:</strong>
                                                            {{ $approvalRequest['assignedBy'] }}<br>
                                                            <strong>Assigned To:</strong>
                                                            {{ $approvalRequest['assignedTo'] }}
                                                        </div>
                                                        <div class="col-md-6">
                                                            <strong>Status:</strong>
                                                            @if ($approvalRequest['status'] === 'finalapproved')
                                                                Forwarded
                                                            @else
                                                                {{ $approvalRequest['status'] }}
                                                            @endif
                                                            <br>
                                                            <strong>Signed Date:</strong>
                                                            {{ $approvalRequest['signedDate'] }}
                                                        </div>
                                                    </div>
                                                </x-slot:content>
                                            </x-bladewind::timeline>
                                            <hr>
                                        @endforeach
                                    </x-bladewind::timeline-group>
                                </ul>
                            </x-slot:content>
                        </x-bladewind::timeline>
                    </x-bladewind::timeline-group>
                @endforeach
            </x-bladewind::timeline-group>
        </div>
    </div>
</div>
