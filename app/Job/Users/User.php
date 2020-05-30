<?php

namespace App\Job\Users;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
use App\Job\JobItems\JobItem;
use App\Models\Profile;
use App\Models\Company;
use App\Notifications\EmailVerificationJa;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    // use SoftDeletes; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'last_name',
        'first_name',
        'email', 
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
         'remember_token',
    ];

    protected $dates= ['deleted_at'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    // public function company()
    // {
    //     return $this->hasOne(Company::class);
    // }
    public function jobs()
    {
        return $this->hasMany(JobItem::class);
    }

    public function users()
    {
        return $this->belongsToMany(JobItem::class)->withPivot('id')->withTimeStamps()->using(GroupUser::class);
    }

    public function favourites()
    {
            return $this->belongsToMany(JobItem::class, 'favourites', 'user_id', 'job_item_id')->as('fav')->withTimeStamps();
    }

    /**
     * パスワード再設定メールの送信
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new EmailVerificationJa($token));
    }

    public function getLastNameNullAttribute()
    {
        return ($this->last_name) ? $this : '';
    }


    public static function checkFavCount()
    {
            if(Auth::check()) {
                $loginUser = auth()->user();
                $favedJobItems = $loginUser->favourites();
                if(!$favedJobItems) {
                    return 0;
                } else {
                    return $favedJobItems->count();
                }

            } else {
                return false;
            }
    }

}
