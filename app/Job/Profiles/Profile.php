<?php

namespace App\Job\Profiles;

use App\Job\Users\User;
use Illuminate\Database\Eloquent\Model;
use  \Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

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

        if (!is_null($this->postcode)) {
            list($postcode1,  $postcode2) = explode('-', $this->postcode);
        }

        array_push($arrayCode, $postcode1);
        array_push($arrayCode, $postcode2);

        return $arrayCode;
    }

    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }
}
