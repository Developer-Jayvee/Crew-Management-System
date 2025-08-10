<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CrewProfile;
use App\Facades\HelperFacade;


class StaffController extends Controller
{
    
    public function dashboard(Request $request){
        $docTypes = HelperFacade::documentTypes('');
        $crew = CrewProfile::with(['profileRank','documentSubmitted.document'])
        ->get()
        ->collect()
        ->map(function($row) use($docTypes){
            $document = [];
            if(!empty($row->documentSubmitted)){
                foreach($row->documentSubmitted as $docs){
                   $document[] = [
                        'name' => $docs->DocName,
                        'type' => $docTypes[$docs->Code] ?? "",
                        'issued' => $docs->IssuedDate,
                        'expiry' => $docs->ExpirationDate,
                        'status' => '',
                        'fileData' => base64_encode($docs->document->FileData)
                   ];
                }
            }
            return [
                'fullname' => $row->FName.' '.$row->MName.' '.$row->LName,
                'rank' => $row->profileRank->RankDescription,
                'documents' => $document
            ];
        });
        return view('staff.dashboard',compact('crew'));
    }
}
