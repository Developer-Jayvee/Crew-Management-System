<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Facades\HelperFacade;


use App\Models\User;
use App\Models\CrewProfile;

use Carbon;
class SignupController extends Controller
{
    public function signupsetup(Request $request){
        $response = array();
        $response['rankList'] = collect(HelperFacade::rankList('',true));


        return view('layouts.signup',$response);
    }
    public function signup(Request $request){
        $data = (object) $request->all();
        $tobeSave = array();
        
        if(User::where('Username',$data->username)->exists()){
           return redirect()->back()->withErrors(['err' => 'Username is already exists.']);
        }

       
        $useracc = User::create([
            'Username' => $data->username,
            'Email' => $data->email,
            'Usertype'=>'G',
            'Password' => Hash::make($data->password),
        ]);

        if($useracc){
            CrewProfile::create([
                'UserID' => $useracc->ID,
                'LName' => $data->lname,
                'FName' => $data->fname,
                'MName' => $data->mname,
                'Age' => $data->age,
                'BDate' => $data->bdate,
                'Weight' => $data->weight,
                'Height' => $data->height,
                'Rank' => $data->rank,
                'Usertype' => 'G',
                'Address'=> $data->address,
                'Email' => $data->email
             ]);
        }
        return redirect('login')->with('status','Successfully Registered.');
    }
}
