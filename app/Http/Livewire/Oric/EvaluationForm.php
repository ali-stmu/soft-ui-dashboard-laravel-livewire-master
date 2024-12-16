<?php

namespace App\Http\Livewire\Oric;

use App\Models\EvaluationCriteria;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EvaluationForm extends Component
{
    public $formId; // The ID of the form being evaluated
    public $criteria = [];

    public function mount()
    {
        $this->formId = request()->query('formId');


        // Map existing column structure to criteria array
        $this->criteria = [
            [
                'column_prefix' => 'capacity_commitment',
                'name' => 'Capacity and Commitment of PI(s) and Team Members',
                'description' => "To what extent does the PI(s) and overall project team demonstrate ability, expertise, and necessary skills to conduct the proposed research? To what extent has the PI(s) shown commitment and devoted significant time for project execution?",
                'weightage' => 15,
                'score' => null,
                'comments' => '',
            ],
            [
                'column_prefix' => 'objectives',
                'name' => 'Clear and Realistic Objectives',
                'description' => "To what extent are the objectives of the project clearly defined, measurable, and achievable within the project timeline?",
                'weightage' => 15,
                'score' => null,
                'comments' => '',
            ],
            [
                'column_prefix' => 'novelty',
                'name' => 'Rationale, Novelty, and Originality of the Study',
                'description' => "What is the significance of the research for human health or its contribution to relevant areas of basic biomedical science? Does the proposal provide sufficient details to show that the work will add distinct value to what is already known or in progress and will benefit or fulfill unmet national needs? To what extent does the proposed activity suggest and explore creative and original concepts, demonstrate innovation potential, and transform concepts into new products, services, or business models?",
                'weightage' => 20,
                'score' => null,
                'comments' => '',
            ],
            [
                'column_prefix' => 'methodology',
                'name' => 'Credibility of Design, Methodology, and Approach',
                'description' => "To what extent are the proposed methodology, strategies, and approach well-reasoned, well-organized, and based on a sound rationale? Are key activities and procedures to complete the project clearly articulated and reasonable? Are the resources assigned to the proposed work in line with their objectives and deliverables?",
                'weightage' => 20,
                'score' => null,
                'comments' => '',
            ],
            [
                'column_prefix' => 'resources',
                'name' => 'Availability of Resources and Facilities',
                'description' => "To what extent are adequate resources (human, technical, and other) available to the PI(s) (either at the home institution or through collaboration) necessary to carry out the proposed activities in a timely manner?",
                'weightage' => 10,
                'score' => null,
                'comments' => '',
            ],
            [
                'column_prefix' => 'budget',
                'name' => 'Budget Reasonability and Justification',
                'description' => "To what extent is the budget under each item clearly outlined with sufficient details and justification and reasonable for the proposed work? Are the cash or in-kind costs clearly identified?",
                'weightage' => 20,
                'score' => null,
                'comments' => '',
            ],
        ];
    }

    public function submit()
    {
        $this->validate([
            'criteria.*.score' => 'required|integer|min:1|max:7',
            'criteria.*.comments' => 'nullable|string',
        ]);

        foreach ($this->criteria as $criterion) {
            $columnPrefix = $criterion['column_prefix'];

            EvaluationCriteria::updateOrCreate(
                ['receiver_id' => Auth::id(), 'form_id' => $this->formId],
                [
                    "{$columnPrefix}_weightage" => $criterion['weightage'],
                    "{$columnPrefix}_score" => $criterion['score'],
                    "{$columnPrefix}_comments" => $criterion['comments'],
                ]
            );
        }

        session()->flash('success', 'Evaluation submitted successfully!');
    }

    public function render()
    {
        return view('livewire.oric.evaluation-form', [
            'gradingScale' => [
                ['score' => '7 - Outstanding', 'description' => 'Exceptionally strong proposal with negligible weaknesses'],
                ['score' => '6 - Excellent', 'description' => 'Very strong proposal with negligible weaknesses'],
                ['score' => '5 - Very Good', 'description' => 'Very strong proposal with minor weaknesses'],
                ['score' => '4 - Good', 'description' => 'Strong proposal with minor weaknesses'],
                ['score' => '3 - Average', 'description' => 'Proposal having some strengths but moderate weaknesses'],
                ['score' => '2 - Weak', 'description' => 'Proposal having few strengths with major weaknesses'],
                ['score' => '1 - Poor', 'description' => 'Proposal having very few strengths with numerous major weaknesses'],
            ],
        ]);
    }
}
