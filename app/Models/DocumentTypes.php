<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentTypes extends Model
{
    protected $connection = 'mysql_main';
    protected $table = 'tblDocumentTypes';
    protected $primaryKey = 'ID';
    const CREATED_AT = 'CreatedAt';
    const UPDATED_AT = 'UpdatedAt';
    protected $fillable = [
        'Code',
        'Description',
    ];
}
