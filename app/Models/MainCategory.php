<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class MainCategory extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['main_category_name', 'initial', 'type'];
}
