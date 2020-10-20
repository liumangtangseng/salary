<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{

    protected $fillable = ['basic_salary', 'post_salary', 'confidentiality_fee', 'subsidy', 'internship_subsidy', 'performance_bonus', 'other_additions', 'mid_night_shift_subsidy', 'overtime_pay', 'total_payable_salay', 'post_deduction', 'leave_deduction', 'sick_leave_deduction', 'other_deduction', 'total_actual_salary', 'expends_base','fund', 'social_security', 'total_salary_reduce_other', 'income_tax', 'total_salary_to_card', 'year', 'month', 'staff_id',];
    protected $table = 'salary';

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
