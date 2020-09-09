<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use Illuminate\Http\Request;
use App\Repositories\Company\CompanyRepositoryInterface as CompanyRepository;
use App\Repositories\Location\LocationRepositoryInterface as LocationRepository;
use App\Repositories\LocationType\LocationTypeRepositoryInterface as LocationTypeRepository;
use App\Repositories\User\UserRepositoryInterface as UserRepository;
use App\Repositories\UserInvite\UserInviteRepositoryInterface as UserInviteRepository;

class RegisterController extends Controller
{
    /**
     * @var CompanyRepository
     */
    private $companyRepository;

    /**
     * @var LocationRepository
     */
    private $locationRepository;

    /**
     * @var LocationTypeRepository
     */
    private $locationTypeRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var UserInviteRepository
     */
    private $userInviteRepository;

    /**
     * RegisterController constructor.
     *
     * @param CompanyRepository $companyRepository
     * @param LocationRepository $locationRepository
     * @param LocationTypeRepository $locationTypeRepository
     * @param UserRepository $userRepository
     * @param UserInviteRepository $userInviteRepository
     */
    public function __construct(
        CompanyRepository $companyRepository,
        LocationRepository $locationRepository,
        LocationTypeRepository $locationTypeRepository,
        UserRepository $userRepository,
        UserInviteRepository $userInviteRepository
    ) {
        $this->companyRepository = $companyRepository;
        $this->locationRepository = $locationRepository;
        $this->locationTypeRepository = $locationTypeRepository;
        $this->userRepository = $userRepository;
        $this->userInviteRepository = $userInviteRepository;
    }

    /**
     * ユーザーを登録する
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $data = $request->get('data');

        // 会社
        $company = $this->companyRepository->store($data['company']);

        // 拠点種別（はじめなのでメイン固定）
        $location_type = $this->locationTypeRepository->store([
            'company_id' => $company->id,
            'name' => 'メイン拠点'
        ]);

        // 拠点
        $data['location']['location_type_id'] = $location_type->id;
        $data['location']['company_id'] = $company->id;
        $location = $this->locationRepository->store($data['location']);

        // ユーザー
        $data['user']['location_id'] = $location->id;
        $this->userRepository->store($data['user']);

        $response = ['status' => 'OK'];
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * 招待ユーザーを登録する
     *
     * @param UserRegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerInvited(UserRegisterRequest $request) {

        $data = $request->all();

        $userInvite = $this->userInviteRepository
            ->getByToken($data['company_code'], $data['email'], $data['token']);

        if (empty($userInvite)) {
            $response = ['status' => 'NG'];
            return response()->json($response, 500, [], JSON_PRETTY_PRINT);
        }

        $company = $this->companyRepository->getByCode($data['company_code']);

        //TODO location_idどうするか
        // ユーザー登録
        $data['location_id'] = $company->first_location->id;
        $this->userRepository->store($data);

        // 招待レコードは削除する
        $userInvite->delete();

        $response = ['status' => 'OK'];
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
