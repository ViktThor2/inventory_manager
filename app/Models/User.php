<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
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

    protected $table = 'users';
    protected $guarded = array();

    public function findData($id)
    {
        return static::find($id);
    }

    public function deleteData($id)
    {
        return static::find($id)->delete();
    }

    public function setData($request)
    {
        if(isset($request['name'])){
            $this->name = $request['name'];
        }
        if(isset($request['email'])){
            $this->email = $request['email'];
        }
        if(isset($request['password'])){
            $this->password = \Hash::make($request['password']);
        }
        if(isset($request['role_id'])){
            $this->role_id = $request['role_id'];
        }
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class);
    }
}
