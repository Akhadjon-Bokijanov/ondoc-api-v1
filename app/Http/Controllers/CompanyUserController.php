<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;

class CompanyUserController extends Controller
{

    public function store(Request $request)
    {
        //body for this request:
//        [
//            "users"=>[
//                          ["user_id"=>1, "role_id"=>3],
//                          ["user_id"=>2, "role_id"=>1],
//                          ["user_id"=>3, "role_id"=>2]
//                      ], //user_id s and role_id s
//            "companies"=>[1, 2, 3] //company_id s
//        ]
        try {
            $data = $request->all();
            $users = $data["users"];
            $companies = $data["companies"];
            foreach ($users as $user){
                $user_model = User::find($user["user_id"]);
                foreach ($companies as $company){
                    $company = Company::find($company);

                    $user_model->companies()->attach($company, ["roleId"=>$user["role_id"], "isActive"=>true, 'created_at'=>now()]);
                }
            }

            return [
                "status"=>"ok",
                "success"=>true,
                "companies"=>auth()->user()->companies
            ];
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        //
        //body for this request:
//        [
//            "users"=>[
//                          ["user_id"=>1, "role_id"=>3, "isActive"=>false],
//                          ["user_id"=>2, "role_id"=>1, "isActive"=>true],
//                          ["user_id"=>3, "role_id"=>2, "isActive"=>false]
//                      ], //user_id s and role_id s
//        ]
        try {
            $data = $request->all();
            $users = $data["users"];
            $companies = $data["companies"];
            foreach ($users as $user){
                $user_model = User::find($user["user_id"]);
                foreach ($companies as $company){
                    $company = Company::find($company);

                    $user_model->companies()->updateExistingPivot($company, ["roleId"=>$user["role_id"], "isActive"=>$user["isActive"], 'updated_at'=>now()]);
                }
            }

            return [
                "status"=>"ok",
                "success"=>true,
                "companies"=>auth()->user()->companies
            ];
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }


}
