<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Company;

class CompanyController extends Controller
{
    /**
     * 会社のインスタンス
     *
     * @var \App\Company
     */
    private $company;

    /**
     * 会社コントローラーのインスタンスを作成
     *
     * @param  \App\Company $company
     * @return void
     */
    public function __construct(Company $company) {
        $this->company = $company;
    }

    /**
     * 一覧
     *
     * @return \Illuminate\Http\JsonResponse
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $company = $this->company->findOrFail($id);

        return response()->json($company, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 新規作成
     *
     * @param  \App\Http\Requests\CompanyRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CompanyRequest $request)
    {
        $this->company->create($request->get('company'));
        $response = ['status' => 'OK'];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 編集
     *
     * @param  int $id
     * @param  \App\Http\Requests\CompanyRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, CompanyRequest $request)
    {
        $company = $this->company->findOrFail($id);
        $company->update($request->get('company'));
        $response = ['status' => 'OK'];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 削除
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $company = $this->company->findOrFail($id);
        $company->delete();
        $response = ['status' => 'OK'];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
