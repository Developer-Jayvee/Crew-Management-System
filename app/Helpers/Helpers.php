<?php

namespace App\Helpers;
use App\Models\Ranks;
use App\Models\DocumentTypes;
use App\Models\UserTypes;
class Helpers
{
    public function rankList($code ='',$addBlank = false){
        $ranks =  Ranks::get()->map(function($row){
            return array(
                'code' => $row->CODE,
                'description' => $row->RankDescription
            );
        });
        $response = $addBlank ? array('' => ' - Select rank -') : array();
        foreach ($ranks as $r) $response[$r['code']] = $r['description'];

        return $response;      
    }
    public function documentTypes($code ='',$addBlank = false, $exclude = array()){
        $doc =  DocumentTypes::whereNotIn('Code',$exclude)->get()->map(function($row){
            return array(
                'code' => $row->Code,
                'description' => $row->Description
            );
        });
        $response = $addBlank ? array('' => ' - Select Document -') : array();
        foreach ($doc as $r) $response[$r['code']] = $r['description'];

        return $response;      
    }
     public function userTypeList($code ='',$addBlank = false , $exclude = array()){
        $ranks =  UserTypes::whereNotIn('Code',$exclude)->get()->map(function($row){
            return array(
                'Code' => $row->Code,
                'description' => $row->UserType
            );
        });
        $response = $addBlank ? array('' => ' - Select User Type -') : array();
        foreach ($ranks as $r) $response[$r['Code']] = $r['description'];

        ksort($response);
        return $response;      
    }
}