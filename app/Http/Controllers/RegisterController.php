<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Requests\UserRegisterRequest;
use App\Location;
use App\LocationType;
use App\User;
use App\UserInvite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    /**
     * 会社のインスタンス
     *
     * @var \App\Company
     */
    private $company;
    /**
     * 拠点のインスタンス
     *
     * @var \App\Location
     */
    private $location;
    /**
     * 拠点種別のインスタンス
     *
     * @var \App\LocationType
     */
    private $locationType;
    /**
     * ユーザーのインスタンス
     *
     * @var \App\User
     */
    private $user;
    /**
     * 招待のインスタンス
     *
     * @var \App\User
     */
    private $userInvite;

    /**
     * RegisterController constructor.
     *
     * @param Company $company
     * @param Location $location
     * @param LocationType $locationType
     * @param User $user
     */
    public function __construct(Company $company, Location $location, LocationType $locationType, User $user, UserInvite $userInvite) {
        $this->company = $company;
        $this->location = $location;
        $this->locationType = $locationType;
        $this->user = $user;
        $this->userInvite = $userInvite;
    }


    public function register(Request $request)
    {
        $data = $request->get('data');

        // 会社
        $company = $this->company->create($data['company']);

        // 拠点種別（はじめなのでメイン固定）
        $location_type = $this->locationType->create([
            'company_id' => $company->id,
            'name' => 'メイン拠点'
        ]);

        // 拠点
        $data['location']['location_type_id'] = $location_type->id;
        $data['location']['company_id'] = $company->id;
        $location = $this->location->create($data['location']);

        // ユーザー
        $data['user']['location_id'] = $location->id;
        $this->user->create($data['user']);

        $response = ['status' => 'OK'];
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }

    public function registerInvited(UserRegisterRequest $request) {

        $data = $request->all();

        $userInvite = $this->userInvite
            ->whereHas('company', function ($query) use ($data) {
                $query->where('company_code', $data['company_code']);
            })
            ->where('email', $data['email'])
            ->where('token', $data['token'])
            ->first();

        if (empty($userInvite)) {
            $response = ['status' => 'NG'];
            return response()->json($response, 500, [], JSON_PRETTY_PRINT);
        }

        $company = $this->company->where('company_code', $data['company_code'])->first();

        //TODO location_idどうするか
        // ユーザー登録
        $data['location_id'] = $company->first_location->id;
        $this->user->create($data);

        // 招待レコードは削除する
        $userInvite->delete();

        $response = ['status' => 'OK'];
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
