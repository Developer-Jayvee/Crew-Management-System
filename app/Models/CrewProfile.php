<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Ranks;
use App\Models\CrewUploadedFiles;
class CrewProfile extends Model
{
    
    protected $connection = 'mysql_main';
    protected $table = 'tblCrewProfile';
    protected $primaryKey = 'ID';
    const CREATED_AT = 'DateCreated';
    const UPDATED_AT = 'DateUpdated';
    
    protected $fillable = [
        'UserID',
        'LName',
        'FName',
        'MName',
        'Age',
        'BDate',
        'Weight',
        'Height',
        'Rank',
        'Usertype',
        'Address',
        'Email',
    ];

    public function user(){
        return $this->hasOne(User::class,'ID','UserID');
    }
    public function profileRank(){
        return $this->hasOne(Ranks::class,'CODE','Rank');
    }
    public function documentSubmitted(){
        return $this->hasMany(CrewUploadedFiles::class,'ProfileID');
    }
}
