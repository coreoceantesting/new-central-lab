<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class PatientDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['patient_id', 'health_post_name', 'patient_uniqe_id', 'first_name', 'middle_name', 'last_name', 'mob_no', 'aadhar_no', 'age', 'gender', 'address', 'main_category_id', 'tests', 'lab', 'refering_doctor_name', 'date', 'created_by', 'created_at', 'updated_by', 'updated_at', 'status', 'remark', 'patient_status', 'deleted_by', 'deleted_at', 'received_by', 'received_at', 'first_approval_status', 'first_approval_remark', 'first_approval_by', 'first_approval_at', 'second_approval_status', 'second_approval_remark', 'second_approval_by', 'second_approval_at'];

    public function labName()
    {
        return $this->belongsTo(Lab::class, 'lab', 'id');
    }

    public static function booted()
    {
        static::created(function (self $user)
        {
            if(Auth::check())
            {
                self::where('patient_id', $user->id)->update([
                    'created_by'=> Auth::user()->id,
                ]);
            }
        });
        static::updated(function (self $user)
        {
            if(Auth::check())
            {
                self::where('patient_id', $user->id)->update([
                    'updated_by'=> Auth::user()->id,
                ]);
            }
        });
        static::deleting(function (self $user)
        {
            if(Auth::check())
            {
                self::where('patient_id', $user->id)->update([
                    'deleted_by'=> Auth::user()->id,
                ]);
            }
        });
    }
}
