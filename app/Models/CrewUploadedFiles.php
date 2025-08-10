<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CrewDocuments;
class CrewUploadedFiles extends Model
{
    protected $connection = 'mysql_main';
    protected $table = 'tblCrewUploadedFiles';
    protected $primaryKey = 'ID';
    const CREATED_AT = 'DateCreated';
    const UPDATED_AT = 'DateUpdated';

     protected $fillable = [
        'ProfileID',
        'FileID',
        'Code',
        'DocName',
        'DocCount',
        'IssuedDate',
        'ExpirationDate',
        'UploadedBy '
    ];
    public function document(){
        return $this->belongsTo(CrewDocuments::class,'FileID','ID');
    }
}
