<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as AuthUser;
use TCG\Voyager\Traits\VoyagerUser;
use App\Course;
use App\Lesson;
use App\Badge;

class User extends AuthUser
{
    use VoyagerUser;

    protected $guarded = [];
    protected $hidden = ['pivot'];
    /**
     * On save make sure to set the default avatar if image is not set.
     */
    public function save(array $options = [])
    {
        // If no avatar has been set, set it to the default
        $this->avatar = $this->avatar ?: config('voyager.user.default_avatar', 'users/default.png');

        parent::save();
    }

    public function setCreatedAtAttribute($value)
    {
        $this->attributes['created_at'] = Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'courses_users');
    }

     public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'lessons_users');
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'badge_issued')->withTimestamps();
    }
}
