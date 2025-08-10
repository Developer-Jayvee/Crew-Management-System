<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTypes extends Model
{
    protected $connection = 'mysql_users';
    
    protected $table = 'tblUserTypes';
    protected $primaryKey = 'ID';
    public $incrementing = true;
    const CREATED_AT = 'DateCreated';
    const UPDATED_AT = 'DateUpdated';
    public $timestamps = true;
    
    protected $fillable = [
        'Code',
        'UserType',
    ];
}
