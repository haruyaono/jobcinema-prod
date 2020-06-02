<?php

namespace App\Job\Applies;


use App\Job\Users\User;
use App\Job\JobItems\JobItem;
use Illuminate\Database\Eloquent\Model;

class Apply extends Model
{

    protected $table = 'applies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'last_name',
        'first_name',
        'postcode',
        'prefecture',
        'city',
        'gender',
        'age',
        'phone1',
        'phone2',
        'phone3',
        'occupation',
        'final_education',
        'work_start_date',
        'desired_salary',
        'job_msg',
        'job_q1',
        'job_q2',
        'job_q3'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function jobitems()
    {
        return $this->belongsToMany(JobItem::class, 'apply_job_item')
                    ->withPivot([
                        'id',
                        'job_item_id',
                        's_status',
                        'e_status',
                        'oiwaikin',
                        'oiwaikin_status',
                        'first_attendance',
                        'no_first_attendance'
                    ])->withTimeStamps();
    }


    /**
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
