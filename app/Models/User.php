<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\CrewProfile;
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $connection = 'mysql_users';
    
    protected $table = 'tblUsers';
    protected $primaryKey = 'ID';
    public $incrementing = true;
    const CREATED_AT = 'DateCreated';
    const UPDATED_AT = 'DateUpdated';
    public $timestamps = true;
    
    protected $fillable = [
        'Username',
        'Password',
        'Email',
        'Usertype',
        'LastLogin'
    ];
    protected $with = ['userprofile'];

    protected $hidden = [
        'Password',
    ];
    public function userprofile(){
        return $this->hasOne(CrewProfile::class,'UserID')->with(['profileRank','documentSubmitted']);
    }
    public function getAuthPassword()
    {
        return $this->Password;
    }
    
    public function username()
    {
        return 'Username';
    }
}