<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Facades\HelperFacade;

use App\Models\CrewDocuments;
use App\Models\CrewUploadedFiles;

use Carbon\Carbon;
class GuestController extends Controller
{
    public function dashboard(Request $req){
        $user = collect(Auth::user());

        $documentSubmitted = CrewUploadedFiles::where('ProfileID',Auth::user()->userprofile->ID)
        ->get()
        ->map(function($row){ 
            return $row['Code'];
         })->toArray();
        $docList = collect(HelperFacade::documentTypes('',false,$documentSubmitted));
        $remainingDocument =collect(HelperFacade::documentTypes(''));
        $fileData = [];
        CrewDocuments::where('UserID',Auth::user()->ID)->each(function($row) use(&$fileData){
            $fileData[$row->ID ] = [
                'data' => base64_encode($row->FileData),
                'filename' => $row->FileName
            ];
        });
        return view('crew.dashboard',compact('user','docList','fileData','remainingDocument'));
    }
    public function deleteDocument(CrewUploadedFiles $file , $id){
        $data = $file->where('ID',$id)->first();

        if($data){
            $fileData = CrewDocuments::find($data->FileID)->delete();
            $data->delete();

            return response()->json(['status' => 1 ,'message' => 'Successfully deleted.']);
        }
        return response()->json(['status' => 0 ,'message' => 'Failed to delete file.']);
    }
    public function uploadDocument(Request $req){
        $req->validate([
            'document' => 'required|file|mimes:pdf|max:2048',
        ]);
        $file = $req->file('document');
        $data = (object) $req->all();
        $uploadedBy = Auth::user()->Username;
        $docList = HelperFacade::documentTypes('',true);
        $document = CrewDocuments::create([
            'UserID'=>Auth::user()->ID,
            'FileName' => $file->getClientOriginalName(),
            'FileData' => file_get_contents($file->getRealPath()),
            'mime_type' => $file->getMimeType(),
            'FileType' => 'pdf',
            'UploadedBy' => $uploadedBy
        ]);

        if($document){
            $newUPloadedFiles = CrewUploadedFiles::create([
                'ProfileID'=> $data->userid ?? "",
                'FileID' => $document->ID,
                'Code' => $data->documentType ?? "",
                'DocName' =>  $file->getClientOriginalName(),
                'DocCount' => $data->userid ?  CrewUploadedFiles::where('ProfileID',$data->userid)->count() + 1 : 0,
                'IssuedDate' => Carbon::now(),
                'ExpirationDate' => $data->expirationDate,
                'UploadedBy' => $uploadedBy
            ]);
            
            $crewList = CrewUploadedFiles::where('FileID',$document->ID)->with('document')->get()->collect()->map(function($row) use($docList){
                $documents = [
                        'fileID' => $row->FileID,
                        'data' =>!empty($row->document->FileData) ? base64_encode($row->document->FileData): '',
                        'code' => $row->Code,
                        'description' => $docList[$row->Code] ?? "",
                        'issuedDate' => $row->IssuedDate,
                        'expiryDate' => $row->ExpirationDate,
                        'uploadedBy' => $row->UploadedBy, 
                ];
                return json_encode($documents);
            });
        }


        return response()->json(['message' => 'Successfully uploaded file','data' => $crewList ?? []]);
    }
    
}
