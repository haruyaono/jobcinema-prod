<?php

namespace App\Job\Profiles;

use App\Job\Users\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use softDeletes; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates= ['deleted_at'];

     /**
     * Get the postcode of the profile.
     *
     * @param null $options
     * @return string
     */
    public function getPostCode($options = null)
    {
        $arrayCode = [];
        $postcode1 = '';
        $postcode2 = '';

        if(!is_null($this->postcode)) {
            list($postcode1,  $postcode2) = explode('-', $this->postcode);
        } 

        array_push($arrayCode, $postcode1);
        array_push($arrayCode, $postcode2);

        return $arrayCode;
    }

    /**
     * Get the resume of the profile.
     *
     * @param null $options
     * @return string
     */
    public function getResume($options = null)
    {
        return $this->resume;
    }

    public function user()
    {
        return $this->BelongsTo(User::class);
    }

}
