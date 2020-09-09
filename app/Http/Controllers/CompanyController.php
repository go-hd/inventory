<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\Company\CompanyRepositoryInterface as CompanyRepository;

class CompanyController extends Controller
{
    /**
     * @var CompanyRepository
     */
    private $companyRepository;

    /**
     * 会社コントローラーのインスタンスを作成
     *
     * @param  CompanyRepository $companyRepository
     * @return void
     */
    public function __construct(CompanyRepository $companyRepository) {
        $this->companyRepository = $companyRepository;
    }

    /**
     * 一覧
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $companies = $this->companyRepository->getList($request->get('search', null));

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
        $company = $this->companyRepository->getOne($id);

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
        $this->companyRepository->store($request->all());
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
        $this->companyRepository->update($id, $request->all());
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
        $this->companyRepository->delete($id);
        $response = ['status' => 'OK'];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * フロントからのバリデーション用
     *
     * @param CompanyRequest $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function validation(CompanyRequest $request) {
        $response = ['status' => 'OK'];
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
