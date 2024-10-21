<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class OricFormModal extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'oric_forms';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_title',
        'expected_start_date',
        'duration_of_project',
        'total_fund_requested',
        'pi_name',
        'pi_designation',
        'pi_email',
        'pi_mobile',
        'pi_landline',
        'pi_department',
        'pi_institution',
        'co_pi_name',
        'co_pi_designation',
        'co_pi_department',
        'co_pi_institution',
        'irb_approval_number',
        'attachment_irb_and_ec',
        'irb_ec_approval_letter_certificate',
        'significance_answer',
        'distinct_value_answer',
        'research_plan_answer',
        'aims_and_objectives',
        'milestones_and_deliverables',
        'work_plan_attachment',
        'economic_significance',
        'financial_request',
        'user_id',
        'remarks',
    ];

    /**
     * Get the user who initiated the form.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
