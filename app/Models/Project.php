<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'owner_id',
        'slug'
    ];

    protected static function boot()
    {
        parent::boot();

        /**
         * listens to when a create method is called on this model.
         * Therefore, when project is created add current user as project member
         *  */
        static::created(function ($project) {
            // auth()->user()->teams()->attach($project->id);
            $project->members()->attach(auth()->id());
        });

        static::deleted(function ($project) {
            $project->members()->sync([]);
        });
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    public function hasPendingInvite($email)
    {
        return (bool)$this->invitations()->where('recipient_email', $email)->count();
    }

    public function members()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function hasUser(User $user)
    {
        return $this->members()->where('user_id', $user->id)->first() ? true : false;
    }
}
