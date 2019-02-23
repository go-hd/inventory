<?php

namespace Tests\Feature;

use App\Company;
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

    /**
     * 会社を新規登録するテスト
     *
     * @return void
     */
    public function testStore()
    {
        $data = ['name' => 'TestCompany'];
        $response = $this->post('/companies', $data);
        $response->assertSuccessful()->assertJson(['status' => 'OK']);
    }

    /**
     * 会社を更新するテスト
     *
     * @return void
     */
    public function testUpdate()
    {
        $company = factory(Company::class)->create();

        $data = ['name' => 'UpdatedTestCompany'];

        $this->put('/companies/'. $company->id, $data)
            ->assertSuccessful()
            ->assertJson(['status' => 'OK']);

        $updatedData = Company::query()->find($company->id)->toArray();

        foreach ($data as $key => $value) {
            $this->assertSame($value, $updatedData[$key]);
        }
    }

    /**
     * 会社を削除するテスト
     *
     * @return void
     */
    public function testDestroy()
    {
        $company = factory(Company::class)->create();
        $count = Company::query()->count();

        $this->delete('/companies/'. $company->id)
            ->assertSuccessful()
            ->assertJson(['status' => 'OK']);

        $this->assertCount($count - 1, Company::query()->get());
    }
}
