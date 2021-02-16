<?php

namespace App\Http\Controllers;

use App\Helper\LoginHelper;
use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Http\Response;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get All companies
        return Company::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //create company
        return Company::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Company::find($id)->users;

        //get single company
        return ['company'=>Company::find($id), 'users'=>$user];
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
        //update company
        try {
            if ($company){
                $data = $request->all();
                $company->account = $data["account"];
                $company->name = $data["name"];
                $company->address = $data["address"];
                $company->oked = $data["oked"];
                $company->directorName = $data["directorName"];
                $company->accountant = $data["accountant"];
                $company->phone = $data["phone"];
                $company->mfo = $data["mfo"];
                $company->regCode = $data["regCode"];

                if($company->save())
                {
                    return $company;
                }
            }
            else return \response("company not found", 401);


        }catch (\Exception $exception){
            return $exception->getMessage();
        }

    }

    public function getByTin($tin){
        $compnany = Company::where('tin', $tin)->first();
        $compnany["branches"] = Company::where("parentTin", $compnany->tin)->select("tin", "name")->get();
        return $compnany;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //delete company
        return Company::destroy($id);
    }
}
