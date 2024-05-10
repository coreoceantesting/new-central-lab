<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class SubCategory extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['sub_category_name', 'units', 'bioreferal', 'main_category'];
}
