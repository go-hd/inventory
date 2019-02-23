<?php

namespace Tests\Feature;

use App\Models\Company;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyApiResponseTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * テスト環境をセットアップ
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    /**
     * 会社のリストを取得するテスト
     *
     * @return void
     */
    public function testIndex()
    {
        $companies = Company::all();

        $this->get('/companies')
            ->assertSuccessful()
            ->assertJsonCount($companies->count())
            ->assertJson($companies->toArray());
    }

    /**
     * 会社の詳細を取得するテスト
     *
     * @return void
     */
    public function testShow()
    {
        $company = Company::query()->first();

        $this->get('/companies/' . $company->id)
            ->assertSuccessful()
            ->assertJson($company->toArray());
    }
}
