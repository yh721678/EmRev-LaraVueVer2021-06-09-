<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthApiTest extends TestCase
{
    //【Laravel】PHPUnitテスト用にDBを設定してデフォルトのDBを汚さなくする
    // https://qiita.com/sola-msr/items/b317bb788f21dac176c4
    // テスト用メソッドは接頭辞がtestじゃないとエラーがでる。
    // https://nao550.hateblo.jp/entry/20130806/p3
    // HTTP レスポンスステータスコード
    // https://developer.mozilla.org/ja/docs/Web/HTTP/Status
    // Laravel 5.3でREST APIのテストコードを書く
    // 422が返ってきている時はバリテーション周りで引っかかっている。
    // https://qiita.com/keitakn/items/1a43d53e9c3b422ec5ef

    use RefreshDatabase;

    protected $resetDatabase = true;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        if ($this->resetDatabase) {
            Artisan::call('migrate:refresh');
            Artisan::call('db:seed');
        }
        \DB::beginTransaction();
    }

    /**
     * A basic feature test get method.
     * @test
     * @return void
     */
    public function test_新しいユーザーを作成して返却する()
    {
        $response = $this->json('POST', route('register'), [
            'email' => 'dummy@gmail.com',
            'password' => 'test12345',
        ]);
        $response->assertStatus(201);
    }

    /**
     * A basic feature test get method.
     * @test
     * @return void
     */
    public function test_ログイン()
    {
        $response = $this->json('POST', route('login'), [
            'email' => 'dummy@gmail.com',
            'password' => 'test12345'
        ]);
        $response->assertStatus(201);
    }
}
