<div class="container mt-4">
    <style>
        .research-table {
            width: 100%;
            border-collapse: collapse;
        }

        .research-table th,
        .research-table td {
            padding: 0.75rem;
            border: 1px solid #dee2e6;
            vertical-align: top;
            text-align: left;
        }

        .research-table th {
            background-color: rgb(210, 219, 223);
            width: 25%;
        }

        .research-table td {
            word-wrap: break-word;
            white-space: normal;
        }

        .heading-title {
            background-color: rgb(210, 219, 223);
            padding: 0.5rem;
            border-radius: 0.75rem;
            text-align: center;
        }
    </style>

    <h2 class="mb-4 text-center">Research Grant Details</h2>
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            Initiated By: {{ $researchGrant->user->name }}
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <tbody>
                    <!-- Project Information Section -->
                    <tr>
                        <th colspan="4">
                            <h2
                                style="background-color: rgb(210, 219, 223); padding: 0.5rem; display: block; border-radius: 0.75rem;">
                                Project Information
                            </h2>
                        </th>
                    </tr>
                    <tr>
                        <th style="width: 20%;">Project Title</th>
                        <td style="width: 30%;">{{ $researchGrant->project_title }}</td>
                        <th style="width: 20%;">Expected Start Date</th>
                        <td style="width: 30%;">{{ $researchGrant->expected_start_date }}</td>
                    </tr>
                    <tr>
                        <th>Duration Of Project</th>
                        <td>{{ $researchGrant->duration_of_project }}</td>
                        <th>Total Fund Requested</th>
                        <td>{{ $researchGrant->total_fund_requested }}</td>
                    </tr>

                    <!-- Principal Investigator (PI) Details Section -->
                    <tr>
                        <th colspan="4">
                            <h2
                                style="background-color: rgb(210, 219, 223); padding: 0.5rem; display: block; border-radius: 0.75rem;">
                                Principal Investigator (PI) Details
                            </h2>
                        </th>
                    </tr>
                    <tr>
                        <th>PI Name</th>
                        <td>{{ $researchGrant->pi_name }}</td>
                        <th>PI Designation</th>
                        <td>{{ $researchGrant->pi_designation }}</td>
                    </tr>
                    <tr>
                        <th>PI Email</th>
                        <td>{{ $researchGrant->pi_email }}</td>
                        <th>PI Department</th>
                        <td>{{ $researchGrant->pi_department }}</td>
                    </tr>
                    <tr>
                        <th>PI Mobile</th>
                        <td>{{ $researchGrant->pi_mobile }}</td>
                        <th>PI Landline</th>
                        <td>{{ $researchGrant->pi_landline }}</td>
                    </tr>
                    <tr>
                        <th>PI Institution</th>
                        <td colspan="3">{{ $researchGrant->pi_institution }}</td>
                    </tr>

                    <!-- Co-Principal Investigator (Co-PI) Details Section -->
                    <tr>
                        <th colspan="4">
                            <h2
                                style="background-color: rgb(210, 219, 223); padding: 0.5rem; display: block; border-radius: 0.75rem;">
                                Co-Principal Investigator (Co-PI) Details
                            </h2>
                        </th>
                    </tr>
                    <tr>
                        <th>Co-PI Name</th>
                        <td>{{ $researchGrant->co_pi_name }}</td>
                        <th>Co-PI Designation</th>
                        <td>{{ $researchGrant->co_pi_designation }}</td>
                    </tr>
                    <tr>
                        <th>Co-PI Department</th>
                        <td>{{ $researchGrant->co_pi_department }}</td>
                        <th>Co-PI Institution</th>
                        <td>{{ $researchGrant->co_pi_institution }}</td>
                    </tr>

                    <!-- IRB and EC Approval Section -->
                    <tr>
                        <th colspan="4">
                            <h2
                                style="background-color: rgb(210, 219, 223); padding: 0.5rem; display: block; border-radius: 0.75rem;">
                                IRB and EC Approval
                            </h2>
                        </th>
                    </tr>
                    <tr>
                        <th>IRB Approval Number</th>
                        <td>{{ $researchGrant->irb_approval_number }}</td>
                        <th>Attachment IRB and EC</th>
                        <td>
                            @if ($researchGrant->attachment_irb_and_ec)
                                <a href="{{ asset('storage/' . $researchGrant->attachment_irb_and_ec) }}"
                                    target="_blank">
                                    View Attachment
                                </a>
                            @else
                                No attachment available
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>IRB and EC Approval Letter Certificate</th>
                        <td colspan="3">
                            @if ($researchGrant->irb_ec_approval_letter_certificate)
                                <a href="{{ asset('storage/' . $researchGrant->irb_ec_approval_letter_certificate) }}"
                                    target="_blank">
                                    View Attachment
                                </a>
                            @else
                                No attachment available
                            @endif
                        </td>
                    </tr>

                    <table class="research-table">
                        <tr>
                            <th colspan="4">
                                <h2 class="heading-title">Research Details</h2>
                            </th>
                        </tr>
                        <tr>
                            <th>What is the significance of your research for human health or its contribution to
                                relevant areas of basic biomedical science or in your area of interest?</th>
                            <td>{{ $researchGrant->significance_answer }}</td>
                        </tr>
                        <tr>
                            <th>Provide sufficient details to show that the work will add distinct value to what is
                                already known, or in progress and will benefit or fulfill unmet national needs in the
                                health service or industry.</th>
                            <td>{{ $researchGrant->distinct_value_answer }}</td>
                        </tr>
                        <tr>
                            <th>Where the research plans involve creating resources or facilities, or forming consortia,
                                networks, or centers of excellence, the case will need to address the potential added
                                value, as well as issues of ownership, direction, and sustainability.</th>
                            <td>{{ $researchGrant->research_plan_answer }}</td>
                        </tr>
                        <tr>
                            <th>Aims and Objectives</th>
                            <td>{{ $researchGrant->aims_and_objectives }}</td>
                        </tr>
                        <tr>
                            <th>Milestone and Deliverable</th>
                            <td>{{ $researchGrant->milestones_and_deliverables }}</td>
                        </tr>
                        <tr>
                            <th>Work Plan Attachment</th>
                            <td>
                                @if ($researchGrant->attachment_irb_and_ec)
                                    <a href="{{ asset('storage/' . $researchGrant->work_plan_attachment) }}"
                                        target="_blank">
                                        View Attachment
                                    </a>
                                @else
                                    No attachment available
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Economic Significance</th>
                            <td>{{ $researchGrant->economic_significance }}</td>
                        </tr>
                        <tr>
                            <th>Financial Request</th>
                            <td>{{ $researchGrant->financial_request }}</td>
                        </tr>
                    </table>
                </tbody>
            </table>
        </div>
        <div class="card-footer d-flex justify-content-between">
            <!-- Back to List button -->
            <a href="{{ route('research-grants.index') }}" class="btn btn-secondary">Back to List</a>
        </div>

    </div>

</div>
</div>
