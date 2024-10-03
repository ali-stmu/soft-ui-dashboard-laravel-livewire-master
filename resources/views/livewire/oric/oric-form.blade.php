<div class="container">
    <form wire:submit.prevent="submit">

        <h2>Research Grant Application Form (STMU-G-A)</h2>
        <!-- Project Information -->
        <div class="card mb-3">
            <div class="card-body">
                <label class="h5 text-black"
                    style="background-color: rgb(210, 219, 223); padding: 0.5rem; display: block; border-radius: 0.75rem;">Project
                    Information</label>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="project_title" class="form-control-label">Project Title</label>
                            <input wire:model="project_title"
                                class="form-control @error('project_title') border border-danger @enderror"
                                type="text" placeholder="Project Title" id="project_title">
                            @error('project_title')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="expected_start_date" class="form-control-label">Expected Start Date</label>
                            <input wire:model="expected_start_date"
                                class="form-control @error('expected_start_date') border border-danger @enderror"
                                type="date" id="expected_start_date">
                            @error('expected_start_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="duration_of_project" class="form-control-label">Duration of Project (in
                                months)</label>
                            <input wire:model="duration_of_project"
                                class="form-control @error('duration_of_project') border border-danger @enderror"
                                type="text" placeholder="Duration in months" id="duration_of_project">
                            @error('duration_of_project')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="total_fund_requested" class="form-control-label">Total Fund Requested</label>
                            <input wire:model="total_fund_requested"
                                class="form-control @error('total_fund_requested') border border-danger @enderror"
                                type="number" placeholder="Total Fund Requested" id="total_fund_requested">
                            @error('total_fund_requested')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- PI Information -->
        <div class="card mb-3">
            <div class="card-body">
                <label class="h5 text-black"
                    style="background-color: rgb(210, 219, 223); padding: 0.5rem; display: block; border-radius: 0.75rem;">Principal
                    Investigator (PI) Details</label>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="pi_name" class="form-control-label">PI Name</label>
                            <input wire:model="pi_name"
                                class="form-control @error('pi_name') border border-danger @enderror" type="text"
                                placeholder="PI Name" id="pi_name">
                            @error('pi_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="pi_designation" class="form-control-label">PI Designation</label>
                            <input wire:model="pi_designation"
                                class="form-control @error('pi_designation') border border-danger @enderror"
                                type="text" placeholder="PI Designation" id="pi_designation">
                            @error('pi_designation')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="pi_email" class="form-control-label">PI Email</label>
                            <input wire:model="pi_email"
                                class="form-control @error('pi_email') border border-danger @enderror" type="email"
                                placeholder="PI Email" id="pi_email">
                            @error('pi_email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="pi_mobile" class="form-control-label">PI Mobile</label>
                            <input wire:model="pi_mobile"
                                class="form-control @error('pi_mobile') border border-danger @enderror" type="text"
                                placeholder="PI Mobile" id="pi_mobile">
                            @error('pi_mobile')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="pi_landline" class="form-control-label">PI Landline</label>
                            <input wire:model="pi_landline"
                                class="form-control @error('pi_landline') border border-danger @enderror"
                                type="text" placeholder="PI Landline" id="pi_landline">
                            @error('pi_landline')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="pi_department" class="form-control-label">PI Department</label>
                            <input wire:model="pi_department"
                                class="form-control @error('pi_department') border border-danger @enderror"
                                type="text" placeholder="PI Department" id="pi_department">
                            @error('pi_department')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="pi_institution" class="form-control-label">PI Institution</label>
                            <input wire:model="pi_institution"
                                class="form-control @error('pi_institution') border border-danger @enderror"
                                type="text" placeholder="PI Institution" id="pi_institution">
                            @error('pi_institution')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Co-PI Information -->
        <div class="card mb-3">
            <div class="card-body">
                <label class="h5 text-black"
                    style="background-color: rgb(210, 219, 223); padding: 0.5rem; display: block; border-radius: 0.75rem;">Co-Principal
                    Investigator (Co-PI) Details</label>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="co_pi_name" class="form-control-label">Co-PI Name</label>
                            <input wire:model="co_pi_name"
                                class="form-control @error('co_pi_name') border border-danger @enderror"
                                type="text" placeholder="Co-PI Name" id="co_pi_name">
                            @error('co_pi_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="co_pi_designation" class="form-control-label">Co-PI Designation</label>
                            <input wire:model="co_pi_designation"
                                class="form-control @error('co_pi_designation') border border-danger @enderror"
                                type="text" placeholder="Co-PI Designation" id="co_pi_designation">
                            @error('co_pi_designation')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="co_pi_department" class="form-control-label">Co-PI Department</label>
                            <input wire:model="co_pi_department"
                                class="form-control @error('co_pi_department') border border-danger @enderror"
                                type="text" placeholder="Co-PI Department" id="co_pi_department">
                            @error('co_pi_department')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="co_pi_institution" class="form-control-label">Co-PI Institution</label>
                            <input wire:model="co_pi_institution"
                                class="form-control @error('co_pi_institution') border border-danger @enderror"
                                type="text" placeholder="Co-PI Institution" id="co_pi_institution">
                            @error('co_pi_institution')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- IRB Approval Information -->
        <div class="card mb-3">
            <div class="card-body">
                <label class="h5 text-black"
                    style="background-color: rgb(210, 219, 223); padding: 0.5rem; display: block; border-radius: 0.75rem;">IRB
                    and EC Approval</label>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="irb_approval_number" class="form-control-label">IRB Approval Number</label>
                            <input wire:model="irb_approval_number"
                                class="form-control @error('irb_approval_number') border border-danger @enderror"
                                type="text" placeholder="IRB Approval Number" id="irb_approval_number">
                            @error('irb_approval_number')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="attachment_irb_and_ec" class="form-control-label">Attachment IRB and
                                EC</label>
                            <input wire:model="attachment_irb_and_ec"
                                class="form-control @error('attachment_irb_and_ec') border border-danger @enderror"
                                type="file" id="attachment_irb_and_ec">
                            @error('attachment_irb_and_ec')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="irb_ec_approval_letter_certificate" class="form-control-label">IRB and EC
                                Approval Letter
                                Certificate</label>
                            <input wire:model="irb_ec_approval_letter_certificate"
                                class="form-control @error('irb_ec_approval_letter_certificate') border border-danger @enderror"
                                type="file" id="irb_ec_approval_letter_certificate">
                            @error('irb_ec_approval_letter_certificate')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Research Details -->
        <div class="card mb-3">
            <div class="card-body">
                <label class="h5 text-black"
                    style="background-color: rgb(210, 219, 223); padding: 0.5rem; display: block; border-radius: 0.75rem;">Research
                    Details</label>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="significance_answer" class="form-control-label">What is the significance of
                                your research for human health or its contribution to relevant areas of basic
                                biomedical science or in your area of interest?</label>
                            <textarea wire:model="significance_answer"
                                class="form-control @error('significance_answer') border border-danger @enderror" id="significance_answer"
                                rows="3" placeholder="Significance Answer"></textarea>
                            @error('significance_answer')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="distinct_value_answer" class="form-control-label">Provide sufficient details
                                to show that the work will add distinct value to what is already known, or in progress
                                and will benefit or fulfill unmet national needs in the health service or
                                industry.</label>
                            <textarea wire:model="distinct_value_answer"
                                class="form-control @error('distinct_value_answer') border border-danger @enderror" id="distinct_value_answer"
                                rows="3" placeholder="Distinct Value Answer"></textarea>
                            @error('distinct_value_answer')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="research_plan_answer" class="form-control-label">Where the research plans
                                involve creating resources or facilities, or forming consortia, networks or centers of
                                excellence, the case will need to address the potential added value, as well as issues
                                of ownership, direction
                                and sustainability.</label>
                            <textarea wire:model="research_plan_answer"
                                class="form-control @error('research_plan_answer') border border-danger @enderror" id="research_plan_answer"
                                rows="3" placeholder="Research Plan Answer"></textarea>
                            @error('research_plan_answer')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="aims_and_objectives" class="form-control-label">Aims and Objectives</label>
                            <textarea wire:model="aims_and_objectives"
                                class="form-control @error('aims_and_objectives') border border-danger @enderror" id="aims_and_objectives"
                                rows="3" placeholder="Aims and Objectives"></textarea>
                            @error('aims_and_objectives')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="milestones_and_deliverables" class="form-control-label">Milestones and
                                Deliverables</label>
                            <textarea wire:model="milestones_and_deliverables"
                                class="form-control @error('milestones_and_deliverables') border border-danger @enderror"
                                id="milestones_and_deliverables" rows="3" placeholder="Milestones and Deliverables"></textarea>
                            @error('milestones_and_deliverables')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="work_plan_attachment" class="form-control-label">Work Plan Attachment</label>
                            <input wire:model="work_plan_attachment"
                                class="form-control @error('work_plan_attachment') border border-danger @enderror"
                                type="file" id="work_plan_attachment">
                            @error('work_plan_attachment')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="economic_significance" class="form-control-label">Economic
                                Significance</label>
                            <textarea wire:model="economic_significance"
                                class="form-control @error('economic_significance') border border-danger @enderror" id="economic_significance"
                                rows="3" placeholder="Economic Significance"></textarea>
                            @error('economic_significance')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="financial_request" class="form-control-label">Financial Request</label>
                            <textarea wire:model="financial_request"
                                class="form-control @error('financial_request') border border-danger @enderror" id="financial_request"
                                rows="3" placeholder="Financial Request"></textarea>
                            @error('financial_request')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Information -->
        {{-- <input type="hidden" wire:model="user_id" value="{{ auth()->id() }}"> --}}

        <div class="row">
            <div class="col text-center">
                <button type="submit" class="btn">Submit</button>
            </div>
        </div>
    </form>

</div>
