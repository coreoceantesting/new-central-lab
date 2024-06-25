<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class TestResult extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'test_result';

    protected $fillable = ['test_result_id', 'patient_id', 'test_id', 'result', 'method_id', 'type', 'generated_date'];

    public function patientDetails()
    {
        return $this->belongsTo(PatientDetail::class, 'patient_id', 'patient_id');
    }

    public function test_name()
    {
        return $this->belongsTo(SubCategory::class, 'test_id', 'id');
    }

    public function method()
    {
        return $this->belongsTo(Method::class, 'method_id', 'id');
    }

}
