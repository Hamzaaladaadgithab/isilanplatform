<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Resume extends Model
{
    use HasFactory,HasUuids , SoftDeletes;



    protected $table = 'resumes';

    protected $keyType = 'string';
    public $incrementing = false;


    protected $fillable = [
        'filename',
        'fileurl',
        'summary',
        'contacDetails',
        'education',
        'experience',
        'skills',
        'userid',
    ];

    protected $dates=[
        'deleted_at'
    ];


    protected function casts(): array{
        return [
            'deleted_at'=>'datetime'

        ];
    }


    public function user(){
        return $this->belongsTo(User::class,'userid','id');
    }


    public function jobapplications(){
        return $this->hasMany(JobApplication::class,'resumeid','id');
    }

    




}
