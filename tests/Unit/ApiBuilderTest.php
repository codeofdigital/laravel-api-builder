<?php

namespace CodeOfDigital\ApiBuilder\Tests\Unit;

use CodeOfDigital\ApiBuilder\Exceptions\ApiBuilderException;
use CodeOfDigital\ApiBuilder\Tests\Models\ApiLog;
use CodeOfDigital\ApiBuilder\Tests\Models\User;
use CodeOfDigital\ApiBuilder\Tests\Stubs\TestAPI;
use CodeOfDigital\ApiBuilder\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\PendingRequest;
use Symfony\Component\HttpFoundation\Response;

class ApiBuilderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_will_not_api_logging_when_running_api_request()
    {
        $this->app['config']->set('api-builder.logging', false);

        $this->assertFalse(TestAPI::canApiLogging());
    }

    /** @test */
    public function it_will_api_logging_when_running_api_request()
    {
        $this->app['config']->set('api-builder.logging', true);

        $this->assertTrue(TestAPI::canApiLogging());
    }

    /** @test */
    public function it_can_create_a_pending_request()
    {
        $this->assertInstanceOf(
            PendingRequest::class,
            TestAPI::build()->getRequest()
        );
    }

    /** @test */
    public function it_can_send_an_api_request()
    {
        $result = TestAPI::to('GET', '/posts/1')->send();

        $this->assertFalse(empty($result));
    }

    /** @test */
    public function it_can_add_query_params()
    {
        $result = TestAPI::to('GET', 'comments')
            ->buildQuery(['postId' => 1])->send();

        $this->assertFalse(empty($result));

        $this->assertCount(5, $result->response);

        foreach ($result->response as $item)
            $this->assertEquals(1, $item->postId);
    }

    /** @test */
    public function it_can_add_data_to_the_request()
    {
        $result = TestAPI::to('POST', 'posts')
            ->buildData([
                'title' => 'api builder package testing',
                'body' => 'api builder package testing',
                'userId' => 1
            ])->send();

        $this->assertEquals(Response::HTTP_CREATED, $result->status);
    }

    /** @test */
    public function it_can_return_response_in_object_and_array_type()
    {
        $resultOne = TestAPI::to('GET', 'comments')
            ->buildQuery(['postId' => 1])->send();

        foreach ($resultOne->response as $item)
            $this->assertTrue(is_object($item));

        TestAPI::$asObject = false;

        $resultTwo = TestAPI::to('GET', 'comments')
            ->buildQuery(['postId' => 1])->send();

        foreach ($resultTwo->response as $item)
            $this->assertTrue(is_array($item));
    }

    /** @test */
    public function it_resolves_logged_in_user_and_logging_api_responses()
    {
        $user = factory(User::class)->create([
            'first_name' => 'Adam',
            'last_name' => 'McCallum',
            'email' => 'adammccalumn@gmail.com'
        ]);

        $this->actingAs($user);

        TestAPI::to('POST', 'posts')
            ->buildData([
                'title' => 'api builder package testing',
                'body' => 'api builder package testing',
                'userId' => 1
            ])->send();

        $apiLog = ApiLog::query()->first();

        $this->assertEquals($user->id, $apiLog->user_id);

        $this->assertCount(14, $apiLog->toArray());
    }

    /** @test */
    public function it_fails_when_ip_address_resolver_implementation_is_invalid()
    {
        $this->expectException(ApiBuilderException::class);
        $this->expectExceptionMessage('Invalid IpAddressResolver implementation');

        $this->app['config']->set('api-builder.resolver.ip_address', null);

        TestAPI::to('GET', 'comments')->buildQuery(['postId' => 1])->send();
    }

    /** @test */
    public function it_fails_when_user_agent_resolver_implementation_is_invalid()
    {
        $this->expectException(ApiBuilderException::class);
        $this->expectExceptionMessage('Invalid UserAgentResolver implementation');

        $this->app['config']->set('api-builder.resolver.user_agent', null);

        TestAPI::to('GET', 'comments')->buildQuery(['postId' => 1])->send();
    }

    /** @test */
    public function it_fails_when_user_resolver_implementation_is_invalid()
    {
        $this->expectException(ApiBuilderException::class);
        $this->expectExceptionMessage('Invalid UserResolver implementation');

        $this->app['config']->set('api-builder.resolver.user', null);

        TestAPI::to('GET', 'comments')->buildQuery(['postId' => 1])->send();
    }

    /** @test */
    public function it_can_set_api_token_in_config_and_class()
    {
        $request = TestAPI::build();

        $this->assertEquals('foobar', $request->getToken());

        $request->setToken('public-api-token');

        $this->assertEquals('public-api-token', $request->getToken());
    }

    /** @test */
    public function it_can_set_base_uri_using_function_and_config()
    {
        $request = TestAPI::build();

        $this->assertEquals('https://jsonplaceholder.typicode.com', $request->getBaseUrl());

        $request->setBaseUrl('https://example.com');

        $this->assertEquals('https://example.com', $request->getBaseUrl());
    }

    /** @test */
    public function it_can_create_new_api_builder_class_using_command()
    {
        $this->assertTrue(file_exists(__DIR__.'/../../src/Commands/stubs/api-builder.stub'));

        $this->artisan('make:api-builder TestAPI')->assertExitCode(0);

        $this->assertTrue(file_exists(__DIR__.'/../../vendor/orchestra/testbench-core/laravel/app/ApiBuilder/Builder/TestAPI.php'));
    }
}