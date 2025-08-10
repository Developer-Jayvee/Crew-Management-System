<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CrewUploadedFiles;
class CrewDocuments extends Model
{
    protected $connection = 'mysql_files';
    protected $table = 'tblCrewDocuments';
    protected $primaryKey = 'ID';
    const CREATED_AT = 'DateCreated';
    const UPDATED_AT = 'DateUpdated';

    protected $fillable = [
        'UserID',
        'FileData',
        'FileName',
        'FileType',
        'mime_type',
        'UploadedBy'
    ];

    public function uploadedFile(){
        return $this->hasOne(CrewUploadedFiles::class,'FileID');
    }

}
