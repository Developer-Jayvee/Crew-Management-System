<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\Rule;
use App\Models\UserTypes;
use App\Facades\HelperFacade;


class APIUserController extends Controller
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
        $userTypeList =  UserTypes::get()->map(function($row){
            return array(
                'value' => $row->ID,
                'description' => $row->UserType
            );
        })->toArray();
        $userID = array_map(function($row){
            return $row['value'];
        },$userTypeList);
        
        $userList = implode(", ",array_map(function($row){
            return $row['value'] .' = ' .$row['description'];
        },$userTypeList));

        $validatedData = $request->validate([
            'Username' => [
                'required',
                'string',
                'max:10',
                'regex:/^[a-zA-Z]+$/'
            ],
            'Email' => 'required|email|max:255',
            'Password' => [
                'required',
                'string',
                'min:8',
                'max:20',
                'regex:/^[a-zA-Z0-9]+$/'
            ],
            'Usertype' => [
                    'required',
                    'integer',
                    Rule::in($userID)
            ],
        ], [
            'Username.string' => 'Username can only contain letters(no special characters)',
            'Username.required' => 'Username is required',
            'Username.max' => 'Username cannot exceed 10 characters',
            'Password.required' => 'Password is required',
            'Password.min' => 'Password must be at least 8 characters',
            'Password.max' => 'Password cannot exceed 20 characters',
            'Password.regex' => 'Password can only contain letters and numbers (no special characters)',
            'Email.email' => 'Invald Email format',
            'Email.required' =>'Email is required',
            'Usertype.in' => "Available User types are :  ". $userList

        ]);
        
        $checkIfExist = User::where('Username',$request->Username)->exists();
        if($checkIfExist){
            return response()->json(['status' => 'Username is already exists.'], 409);
        }

        User::create([
            'Username' => $request->Username,
            'Email' => $request->Email,
            'Usertype'=>3,
            'Password' => Hash::make($request->Password),
        ]);
        $response = [
            'status' => 'success',
            'message' => 'User created successfully',
            'data' => [
                'Username' => $validatedData['Username'],
                'Email' => $validatedData['Email'],
            ]
        ];

        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $username)
    {
        if(empty($id)){
            return response()->json('', 200);
        }
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
}
