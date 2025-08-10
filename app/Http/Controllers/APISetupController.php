<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\HelperFacade;

use App\Models\Ranks;
use App\Models\UserTypes;
use App\Models\DocumentTypes;
use App\Models\CrewUploadedFiles;
use App\Models\CrewProfile;
class APISetupController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function createNewRank(Request $request){
        try {
            $validatedData = $request->validate([
                'CODE' => [
                        'required',
                        'string',
                        'max:10',
                        'regex:/^[a-zA-Z]+$/'
                    ],
                    'Description' => 'required|max:200',
                    'Alias' => 'required|max:150',
                ],
                [
                    'CODE.required' => 'CODE is required',
                    'Description.required' => 'Description is required',
                    'Alias.required' => 'Alias is required',
                ]);
            $rank = Ranks::where('CODE',$request->CODE)->first();
            if($rank) return response()->json(['status' => 'failed' , 'message' => 'Rank is already exist.'], 500);
            
            Ranks::create([
                'CODE' => $request->CODE,
                'RankDescription' => $request->Description,
                'Alias' => $request->Alias
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Successfully saved new rank.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to save new Crew Rank',
                'error' => $th->getMessage()
            ], 500);
        }
    }
    public function showRanks(Request $request){
        try {
            $validatedData = $request->validate([
               'CODE' => 'max:10|string',
               'Description' => 'max:200',
               'Alias' => 'max:150',
            ]);
            $response = array();

            $response['rankList'] = Ranks::query()
            ->orWhere(function($w) use($request){
                if(isset($request->Search) && !empty($request->Search)){
                    $w->orWhere('CODE',$request->Search)
                    ->orWhere('RankDescription',$request->Search)
                    ->orWhere('Alias',$request->Search);
                }
            })
            ->paginate($request->limit ? $request->limit : 15)
            ->through(function($row) {
                return [
                    'CODE' => $row->CODE,
                    'Description' => $row->RankDescription,
                    'Alias' => $row->Alias,
                ];
            });
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve Crew Ranks',
                'error' => $th->getMessage()
            ], 500);
        }
    }
    public function updateRank(Request $request){
        try {
            $validatedData = $request->validate([
               'CODE' => 'max:10|string|required',
               'Description' => 'max:200',
               'Alias' => 'max:150',
            ],
            [
                'CODE.required' =>'CODE is required.'
            ]);
            $response = array();
            $status = 200;
            $isUsed = CrewProfile::where('Rank',$validatedData['CODE'])->count();
            if(!Ranks::where('CODE',$validatedData['CODE'])->exists()){
                $response = ['message' => 'Crew Rank does not exists.' ];
                $status = 500;
            }else if($isUsed > 0){
                $response = ['message' => 'Crew Rank is currently used.' ];
                $status = 500;
            }
            else{
                $toUpdate = array();

                if($request->Description) $toUpdate['RankDescription'] = $request->Description;
                if($request->CODE) $toUpdate['CODE'] = $request->CODE;
                if($request->Alias) $toUpdate['Alias'] = $request->Alias;


                Ranks::query()
                ->where('CODE',$validatedData['CODE'])
                ->update($toUpdate);
                $response['message'] = 'Successfully updated existing rank.';
            }
            return response()->json($response, $status);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update Crew Ranks',
                'error' => $th->getMessage()
            ], 500);
        }
    }
    public function deleteRank(Request $request){
        try {
            $validatedData = $request->validate([
               'CODE' => 'max:10|string|required',
               'Description' => 'max:200',
               'Alias' => 'max:150',
            ],
            [
                'CODE.required' =>'CODE is required.'
            ]);
            $response = array();
            $status = 200;
            $isUsed = CrewProfile::where('Rank',$validatedData['CODE'])->count();
            $rank = Ranks::where('CODE',$validatedData['CODE'])->first();
            if(empty($rank)){
                $response = ['message' => 'Crew Rank does not exists.' ];
                $status = 500;
            }else if($isUsed > 0){
                $response = ['message' => 'Crew Rank is currently used.' ];
                $status = 500;
            }
            else{
                $rank->delete();
                $response['message'] = 'Successfully deleted existing rank.';
            }
            return response()->json($response, $status);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete Crew Ranks',
                'error' => $th->getMessage()
            ], 500);
        }
    }
    public function createNewDocumentType(Request $request){
        try {
            $validatedData = $request->validate([
               'Code' => [
                       'required',
                       'string',
                       'max:10',
                       'regex:/^[a-zA-Z]+$/'
                   ],
                   'Description' => 'required|max:200',
               ],
               [
                   'Code.required' => 'CODE is required',
                   'Description.required' => 'Description is required',
               ]);
               DocumentTypes::create([
                   'Code' => $request->Code,
                   'Description' => $request->Description,
               ]);
               return response()->json([
                   'status' => 'success',
                   'message' => 'Successfully saved new Document type.'
               ], 200);
            //code...
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to save new Document type',
                'error' => $th->getMessage()
            ], 500);
        }
    }
    public function showDocumentTypes(Request $request){
        try {
            $validatedData = $request->validate([
               'Code' => 'max:10|string',
               'Description' => 'max:200',
            ]);
            $response = array();

            $response['documentTypeList'] = DocumentTypes::query()
             ->orWhere(function($w) use($request){
                if(isset($request->Search) && !empty($request->Search)){
                    $w->orWhere('Code',$request->Search)
                    ->orWhere('Description',$request->Search);
                }
            })
            ->paginate($request->limit ? $request->limit : 15)
            ->through(function($row) {
                return [
                    'Code' => $row->Code,
                    'Description' => $row->Description,
                ];
            });
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve Document Types',
                'error' => $th->getMessage()
            ], 500);
        }
    }
    public function updateDocumentType(Request $request){
        try {
            $validatedData = $request->validate([
                'Code' => 'max:10|string|required',
                'Description' => 'max:200',
            ],
            [
                'Code.required' =>'Code is required.'
            ]);
            $response = array();
            $status = 200;
            $isUsed = CrewUploadedFiles::where('Code',$validatedData['Code'])->count();
            if(!DocumentTypes::where('Code',$validatedData['Code'])->exists()){
                $response = ['message' => 'Document Type does not exists.' ];
                $status = 500;
            }else if($isUsed > 0) {
                $response = ['message' => 'Document Type is currently used.' ];
                $status = 500;
            }
            else{
                DocumentTypes::query()
                ->where('CODE',$validatedData['Code'])
                ->update($validatedData);
                $response['message'] = 'Successfully updated existing document type.';
            }
            return response()->json($response, $status);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update document type',
                'error' => $th->getMessage()
            ], 500);
        }
    }
    public function deleteDocumentType(Request $request){
        try {
            $validatedData = $request->validate([
              'Code' => 'max:10|string|required',
            ],
            [
                'Code.required' =>'Code is required.'
            ]);
            $response = array();
            $status = 200;
            $isUsed = CrewUploadedFiles::where('Code',$validatedData['Code'])->count();
            $rank = DocumentTypes::where('Code',$validatedData['Code'])->first();
            if(empty($rank)){
                $response = ['message' => 'Document Type does not exists.' ];
                $status = 500;
            }else if($isUsed > 0) {
                $response = ['message' => 'Document Type is currently used.' ];
                $status = 500;
            }
            else{
                $rank->delete();
                $response['message'] = 'Successfully deleted existing Document Type.';
            }
            return response()->json($response, $status);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete Document Type',
                'error' => $th->getMessage()
            ], 500);
        }
    }
    public function createNewUserType(Request $request){
        try {
            $validatedData = $request->validate([
               'Usertype' => [
                       'required',
                       'string',
                       'max:100',
                       'regex:/^[a-zA-Z]+$/'
               ],
               'Code' => [
                    'required',
                    'string',
                    'max:5',
               ]
               ],
               [
                   'Usertype.required' => 'Usertype is required',
                   'Code.required' => 'Code is required'
               ]);
               UserTypes::create([
                    'Code' => $request->Code,
                   'UserType' => $request->Usertype,
               ]);
               return response()->json([
                   'status' => 'success',
                   'message' => 'Successfully saved new User type.'
               ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to save new User type',
                'error' => $th->getMessage()
            ], 500);
        }


    }
    public function showUserTypes(Request $request){
        try {
            $validatedData = $request->validate([
                'Code' => 'max:5',
                'UserType' => 'max:200',
            ]);
            $response = array();

            $response['usertypeList'] = UserTypes::query()
            ->orWhere(function($w) use($request){
                if(isset($request->Search) && !empty($request->Search)){
                    $w->orWhere('UserType',$request->Search)
                    ->orWhere('Code',$request->Search);
                }
            })
            ->paginate($request->limit ? $request->limit : 15)
            ->through(function($row) {
                return [
                    'Code' => $row->Code,
                    'UserType' => $row->UserType,
                ];
            });
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve User Types',
                'error' => $th->getMessage()
            ], 500);
        }
    }
     public function updateUserType(Request $request){
        try {
            $validatedData = $request->validate([
                'Code' => 'max:10|string|required',
                'UserType' => 'max:200',
            ],
            [
                'Code.required' =>'Code is required.',
            ]);
            $response = array();
            $status = 200;
            $isUsed = CrewProfile::where('Usertype',$validatedData['Code'])->count();
            if(!UserTypes::where('Code',$validatedData['Code'])->exists()){
                $response = ['message' => 'User Type does not exists.' ];
                $status = 500;
            }else if($isUsed > 0) {
                $response = ['message' => 'User Type is currently used.' ];
                $status = 500;
            }
            else{
                UserTypes::query()
                ->where('Code',$validatedData['Code'])
                ->update($validatedData);
                $response['message'] = 'Successfully updated existing user type.';
            }
            return response()->json($response, $status);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update user type',
                'error' => $th->getMessage()
            ], 500);
        }
    }
    public function deleteUserType(Request $request){
        try {
            $validatedData = $request->validate([
              'Code' => 'max:10|string|required',
            ],
            [
                'Code.required' =>'Code is required.'
            ]);
            $response = array();
            $status = 200;
            $isUsed = CrewProfile::where('Code',$validatedData['Code'])->count();
            $user = UserTypes::where('Code',$validatedData['Code'])->first();
            if(empty($user)){
                $response = ['message' => 'User Type does not exists.' ];
                $status = 500;
            }else if($isUsed > 0) {
                $response = ['message' => 'User Type is currently used.' ];
                $status = 500;
            }
            else{
                $user->delete();
                $response['message'] = 'Successfully deleted existing User Type.';
            }
            return response()->json($response, $status);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete User Type',
                'error' => $th->getMessage()
            ], 500);
        }
    }
    
}
