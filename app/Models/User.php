<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\JobItem;
use App\Models\Apply;
use App\Models\Profile;
use App\Notifications\EmailVerificationJa;
use Illuminate\Support\Facades\Auth;
use  \Illuminate\Database\Eloquent\Relations\hasOne;
use  \Illuminate\Database\Eloquent\Relations\hasMany;
use  \Illuminate\Database\Eloquent\Relations\belongsToMany;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile(): hasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function applies(): hasMany
    {
        return $this->hasMany(Apply::class);
    }

    public function favourites(): belongsToMany
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

    public function getFullNameAttribute()
    {
        return "{$this->last_name}" . '　' . "{$this->first_name}";
    }

    public static function checkFavCount()
    {
        if (Auth::check()) {
            $loginUser = auth()->user();
            $favedJobItems = $loginUser->favourites();
            if (!$favedJobItems) {
                return 0;
            } else {
                return $favedJobItems->count();
            }
        } else {
            return false;
        }
    }

    public function existsAppliedJobItem(int $id): bool
    {
        return $this->applies()->where('job_item_id', $id)->exists();
    }
}
