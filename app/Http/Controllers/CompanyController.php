<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;

class CompanyController extends Controller
{
    /**
     * @var \App\Models\Company
     */
    private $company;

    /**
     * CompanyControllerの初期化を行う
     *
     * @param \App\Models\Company $company
     * @return void
     */
    public function __construct(Company $company) {
        $this->company = $company;
    }

    /**
     * 一覧
     * 
     * @return \Illuminate\Routing\ResponseFactory
     */
    public function index()
    {
        $companies = $this->company->all();
        return response()->json($companies, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 詳細
     * 
     * @param  int $id
     * @return \Illuminate\Routing\ResponseFactory
     */
    public function show($id)
    {
        $company = $this->company->findOrFail($id);
        return response()->json($company, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 新規作成
     * 
     * @param  CompanyRequest $request
     * @return \Illuminate\Routing\ResponseFactory
     */
    public function store(CompanyRequest $request)
    {
        $this->company->create($request->get('company'));
        $response = array('status' => 'OK');
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 編集
     * 
     * @param  int $id
     * @param  CompanyRequest $request
     * @return \Illuminate\Routing\ResponseFactory
     */
    public function update($id, CompanyRequest $request)
    {
        $company = $this->company->findOrFail($id);
        $company->update($request->get('company'));
        $response = array('status' => 'OK');
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 削除
     * 
     * @param  int $id
     * @return \Illuminate\Routing\ResponseFactory
     */
    public function destroy($id)
    {
        $company = $this->company->findOrFail($id);
        $company->delete();
        $response = array('status' => 'OK');
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
