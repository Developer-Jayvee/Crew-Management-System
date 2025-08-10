<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Facades\HelperFacade;
use Illuminate\Support\Facades\Hash;


use App\Models\CrewDocuments;
use App\Models\CrewUploadedFiles;
use App\Models\CrewProfile;
use App\Models\Ranks;
use App\Models\DocumentTypes;
use App\Models\UserTypes;
use App\Models\User;

use Carbon\Carbon;
class AdminController extends Controller
{
    public function index(Request $req){
        return redirect('login');
    }
    public function dashboard(Request $req){
        $data = (object) $req->all();
        $response = array('data' => $data);
        $docList = HelperFacade::documentTypes('',true);
        $response['docList'] = collect($docList);
        $response['rankList'] = collect(HelperFacade::rankList('',true));
        $response['crewList'] = CrewProfile::with(['profileRank','documentSubmitted.document'])->where('Usertype','G')->get()->collect()->map(function($row) use($docList){
            $documents = [];
            if($row->documentSubmitted){
                foreach($row->documentSubmitted as $d){
                        $documents[]  = [
                        'fileID' => $d->FileID,
                        'data' =>!empty($d->document->FileData) ? base64_encode($d->document->FileData): '',
                        'code' => $d->Code,
                        'description' => $docList[$d->Code] ?? "",
                        'issuedDate' => $d->IssuedDate,
                        'expiryDate' => $d->ExpirationDate,
                        'uploadedBy' => $d->UploadedBy, 
                    ];
                }
               
            }
            return [
                'id' => $row->ID,
                'name' => $row->FName.' '.$row->MName.' '.$row->LName,
                'email' => $row->Email,
                'rank' => $row->profileRank->RankDescription ?? "",
                'rankCode' => $row->profileRank->CODE ?? "",
                'last' => $row->LName,
                'first' => $row->FName,
                'middle' => $row->MName,
                'address' => $row->Address,
                'weight' => $row->Weight,
                'height' => $row->Height,
                'age' => $row->Age,
                'bdate' => $row->BDate,
                'docs' => json_encode($documents)
            ];
        });
        return view('admin.index',$response);
    }
    public function submitDocument(Request $req){
        $req->validate([
            'document' => 'required|file|mimes:pdf|max:2048',
        ]);
        $file = $req->file('document');
        $data = (object) $req->all();
        $uploadedBy = Auth::user()->Username;
        $docList = HelperFacade::documentTypes('',true);
        $document = CrewDocuments::create([
            'UserID'=>$data->userid ?? "",
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
    public function deleteFileSubmitted(CrewUploadedFiles $file,$id){
        $uploadedFile = $file->where('FileID',$id)->with('document')->first();
        if(!empty($uploadedFile->document)) $uploadedFile->document->delete();
        $uploadedFile->delete();
        return response()->json(['message' => 'Successfully deleted the file']);
    }
    public function getDocDetails(CrewUploadedFiles $file,$id){
        $return = array();
        $fileData = $file->where('FileID',$id)->with('document')
        ->each(function($row) use(&$return){
            $return['fileData'] = [
                'Code' => $row->Code,
                'Name' => $row->DocName,
                'Count' => $row->DocCount,
                'Issued' => $row->IssuedDate,
                'Expiry' => $row->ExpirationDate,
                'UploadedBy' => $row->document->UploadedBy ?? "",
                'file' => json_encode(base64_encode($row->document->FileData ?? ""))
            ];
        });
        $return['fileData'] = collect($return['fileData']);
        return view('admin.document.documentDetails',$return);
    }
    public function config(Request $req){
        $data =  $req->input();
        $rankList = Ranks::get()->collect()->map(function($row){
            return [
                'code' => $row->CODE,
                'description' => $row->RankDescription,
                'alias' => $row->Alias
            ];
        });
        $documentList = DocumentTypes::get()->collect()->map(function($row){
            return [
                'code' => $row->Code,
                'description' => $row->Description,
            ];
        });
        $userTypeList = UserTypes::get()->collect()->map(function($row){
            return [
                'code' => $row->Code,
                'description' => $row->UserType,
            ];
        });
        return view('admin.configurations.config',compact('data','rankList','documentList','userTypeList'));
    }
    
    public function addNewRank(Request $req){
        $data = (object) $req->all();
        $checkIfUsed = CrewProfile::where('Rank',$data->code)->count();
        if($checkIfUsed > 0) return response()->json(['status' => 0 ,'message' => 'Rank is currently used.']);
        Ranks::getModel()->updateOrCreate([
            'CODE' => $data->code,
            'Alias' => $data->alias
        ],
        [
            'CODE' => $data->code,
            'RankDescription' => $data->description,
            'Alias' => $data->alias
        ]);

       return response()->json(['status' => 1,'message' => 'Successfully added rank']);
    }
    public function deleteRank(Ranks $rank , $code){
        $checkIfUsed = CrewProfile::where('Rank',$code)->count();
        if($checkIfUsed > 0)     if($checkIfUsed > 0) return response()->json(['status' => 0 ,'message' => 'Rank is currently used.']);
        $delete = $rank->where('CODE',$code)->first();

        if($delete) $delete->delete();
        return response()->json(['status'=>1 ,'message' => 'Successfully deleted.']);
    }
    public function addNewDocument(Request $req){
        $data = (object) $req->all();
        $checkIfUsed = CrewUploadedFiles::where('Code', $data->code)->count();
        if($checkIfUsed > 0) return response()->json(['status' => 0 ,'message' => 'Document type is currently used.']);
        DocumentTypes::getModel()->updateOrCreate([
            'Code' => $data->code
        ],
        [
            'Code' => $data->code,
            'Description' => $data->description,
        ]);
        return response()->json(['status' => 1 ,'message' => 'Successfully added document type']);
    }
    public function deleteDocument(DocumentTypes $docs , $code){
        $checkIfUsed = CrewUploadedFiles::where('Code',$code)->count();
        if($checkIfUsed > 0) return response()->json(['status' => 0 ,'message' => 'Document type is currently used.']);

        $delete = $docs->where('Code',$code)->first();

        if($delete) $delete->delete();
        return response()->json(['status' => 1 ,'message' => 'Successfully deleted.']);
    }

    public function addNewUserType(Request $req){
        $data = (object) $req->all();
        $checkIfExist = UserTypes::where('Code',$data->code)->exists();
        if(!$checkIfExist){
            UserTypes::create([
                'Code' => $data->code,
                'UserType' => $data->description,
            ]);
            return response()->json(['status' => 1 ,'message' => 'Successfully added user type']);
        }
        return 0;
    }
    public function deleteUserType(UserTypes $usertype , $code){
        $delete = $usertype->where('Code',$code)->first();
        $checkIfUsed = User::where('Usertype',$code)->count();
        if($checkIfUsed > 0){
            return response()->json(['status' => 0 ,'message' => 'User type is currently used.']);
        }

        if($delete) $delete->delete();
        return response()->json(['status' => 1 ,'message' => 'Successfully deleted.']);
    }

    public function accountList(Request $req){
        $userTypeList  = HelperFacade::userTypeList('');
        $userList = User::get()->collect()->map(function($row) use($userTypeList){
            return [
                'username' => $row->Username,
                'email' => $row->Email,
                'usertype' => $userTypeList[$row->Usertype] ?? ""
            ];
        });
        return view('admin.accounts.accountList',compact('userList'));
    }
    public function deleteUserAccount(User $user, $username){
        $useracc = $user->where('Username',$username)->with('userprofile')->first();
        if($useracc){
            if(!empty($useracc->userprofile)) $useracc->userprofile->delete();
            $useracc->delete();
            return response()->json(['message' => 'Successfully deleted.']);
        }
        return 0;
    }
    public function getUserAccountSetup(User $user,$username){
        $useracc = collect($user->select('Username','Email')->where('Username',$username)->first());
        return view('admin.accounts.updateuser',compact('useracc'));
    }
    public function addNewUser(Request $req){
        $userTypeList  = HelperFacade::userTypeList('',false,['G']);
        return view('admin.accounts.addNewUser',compact('userTypeList'));
    }
    public function saveNewAccount(Request $req){
        $data = (object) $req->all();
        $newUser = User::where('Username',$data->username)->first();
        if($newUser) return response()->json(['status'=> 0,'message' => 'Username is already exists.']);

            
            User::create([
                'Username' => $data->username,
                'Email' => $data->email,
                'Usertype' => $data->type,
                'Password' => Hash::make($data->cpassword)
            ]);
            return response()->json(['status' => 1,'message' => 'Successfully created new account.']);
        
        return response()->json(['status'=>0,'message' => 'Failed to creat new account.']);
    }
    public function updateAccount(Request $req){
        $data =  (object) $req->all();
        $toUpdate = array();
        $useracc = User::where('Username',$data->username)->first();
        if($useracc){
            if(!empty($req->new)){
                if(!Hash::check($data->current, $useracc->password)){
                    return response()->json(['status'=>0,'message' => 'Current password is incorrect']);
                }
                $toUpdate['Password'] = Hash::make($data->new);
            }
            if($useracc->Email != $data->email){
                $profile = CrewProfile::where('UserID',$useracc->ID)->update([
                                'Email' => $data->email
                            ]);
                $toUpdate['Email'] =  $data->email;
            }

            if(count($toUpdate) > 0) $useracc->update($toUpdate);
            return response()->json(['status'=>1,'message' => 'User Account is successfully updated.']);
        }

        return response()->json(['status'=>0,'message' => 'No data found.']);
        
    }
    public function deleteCrew( $id){
        $crewProfile = CrewProfile::with(['user','documentSubmitted.document'])->find($id);
        if($crewProfile){
            // if(!empty($crewProfile->user)) $crewProfile->user->delete();
            // if(!empty($crewProfile->documentSubmitted->document)) $crewProfile->documentSubmitted->document->delete();
            // if(!empty($crewProfile->documentSubmitted)) $crewProfile->documentSubmitted->delete();
            $crewProfile->delete();
            return response()->json(['status'=>1,'message' => 'Successfully deleted.']);
        }
         return response()->json(['status'=>0,'message' => 'Failed to delete profile.']);
    }
}
