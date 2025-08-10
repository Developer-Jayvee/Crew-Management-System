<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ranks extends Model
{
    protected $connection = 'mysql_main';
    protected $table = 'tblRanks';
    protected $primaryKey = 'ID';
    const CREATED_AT = 'DateCreated';
    const UPDATED_AT = 'DateUpdated';
    protected $fillable = [
        'CODE',
        'RankDescription',
        'Alias',
    ];
}
