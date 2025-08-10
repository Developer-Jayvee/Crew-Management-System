<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\HelperFacade;

use App\Models\CrewProfile;
use App\Models\User;
use App\Models\CrewDocuments;
use App\Models\CrewUploadedFiles;
use App\Models\DocumentTypes;

use Illuminate\Validation\Rule;
class APICrewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = (object) $request->all();
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        try {
            $response = $where = array();
            $rankList = HelperFacade::rankList('');
            $response['request'] = $request->all();

            if($request->Lastname) $where[] = ['LName',$request->Lastname];
            if($request->Firstname) $where[] = ['FName',$request->Firstname];
            if($request->Middlename) $where[] = ['MName',$request->Middlename];
            if($request->Email) $where[] = ['Email',$request->Email];


            
            $response['crewList'] = CrewProfile::query()
            ->orWhere($where)
            ->paginate($request->limit ? $request->limit : 15)
            ->through(function($row) use ($rankList) {
                return [
                    'FirstName' => $row->FName,
                    'LastName' => $row->LName,
                    'MiddleName' => $row->MName,
                    'Age' => $row->Age,
                    'BirthDate' => $row->BDate,
                    'Weight' => $row->Weight,
                    'Height' => $row->Height,
                    'Rank' => $rankList[$row->Rank] ?? "Unknown Rank",
                    'Email' => $row->Email,
                    'Address' => $row->Address,
                ];
            });
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve crew data'
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateDocument(Request $request){
        try {
            $doc =  DocumentTypes::get()->map(function($row){
                return array(
                    'code' => $row->Code,
                    'description' => $row->Description
                );
            })->toArray();
            $documentCodes = array_map(function($row){
                return $row['code'];
            },$doc);
            $docList = implode(", ",array_map(function($row){
                return $row['code'] . ' => '. $row['description'];
            },$doc));
            $request->validate([
                'files' => 'required|file|mimes:pdf|max:10240', // PDF up to 10MB
                'Type' => [
                        'string',
                        Rule::in($documentCodes)
                ],
                'Username' => [
                    'required',
                    'string',
                    'max:10',
                    'regex:/^[a-zA-Z]+$/'
                ],
            ], [
                'Username.string' => 'Username can only contain letters(no special characters)',
                'Username.required' => 'Username is required',
                'Username.max' => 'Username cannot exceed 10 characters',
                // 'Type.required' => 'Document type is required',
                'Type.in' => 'Document code type available are : '.$docList

            ]);
            


            $user = User::where('Username',$request->Username)->with('userprofile')->first();
            if($user){
                if(!empty($user->userprofile->documentSubmitted)){
                    $doc = CrewDocuments::where('UserID',$user->ID)->first();
                    if($doc){
                        $hasFile = $request->hasFile('files');
                        if($hasFile){
                            $file = $request->file('files');
                            $doc->update([
                                'FileName' => $file->getClientOriginalName(),
                                'FileData' => file_get_contents($file->getRealPath()),
                                'mime_type' => $file->getMimeType(),
                                'FileType' => 'pdf',
                            ]);

                            $updateFile = array( 'FileName'=>$file->getClientOriginalName() );
                            if($request->Type) $update['Code'] = $request->Type;
                            
                            CrewUploadedFiles::where('FileID',$doc->ID)->update($updateFile);
                            return response()->json([
                                'status' => 'success',
                                'message' => 'Successfully updated crew document'
                            ], 200);
                        }
                       
                    }
                    // $user->userprofile->update($request->input());
                }
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update document',
                'error' => $th->getMessage()
            ], 500);
        }
    }
    public function updateProfile(Request $request)
    {
        try {
            $user = User::where('Username',$request->username)->with('userprofile')->first();
            if($user){
                if(!empty($user->userprofile)){
                    $availableFieldToUpdate = array_filter(
                        $user->userprofile->getFillable(),
                        function($row){
                            return $row != 'UserID' && $row != 'Usertype';
                    });
                    $user->userprofile->update($request->input());
                    return response()->json([
                        'status' => 'success',
                        'Available fields to update' => $availableFieldToUpdate,
                        'message' => 'Successfully updated crew profile'
                    ], 200);
                }
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve crew data',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
