<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

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
    public function update(Request $request, $id)
    {
        //update company
        $company = Company::find($id);
        $company->update($request->all());
        return $company;
    }

    public function getByTin($tin){
        $compnany = Company::where('tin', $tin)->first();
        return $compnany;
    }

    public function login(Request $request){
        try {
            $data=$request->all();

            if(Company::find(['tin'=>$data["tin"]])){
                $credentials = request()->only(['tin', 'password']);
                $token = auth()->guard('companies')->attempt($credentials);

                return [
                    "token"=>$token,
                    "company"=>auth()->guard('companies')->user()
                ];
            }
            else{
                return Company::create($data);
            }
        } catch (\Exception $exception){
            return $exception->getMessage();
        }
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
