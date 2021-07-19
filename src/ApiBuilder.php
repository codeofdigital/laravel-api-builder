<?php

namespace CodeOfDigital\ApiBuilder;

use Illuminate\Http\Client\Factory;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Illuminate\Support\Traits\Macroable;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

abstract class ApiBuilder
{
    use Macroable {
        Macroable::__call as macroCall;
    }

    /**
     * @var PendingRequest
     */
    protected $request;

    /**
     * Authorization token for API request call (If needed)
     *
     * @var string
     */
    protected $token;

    /**
     * Authorization type (Eg: Bearer, Public-API, etc.)
     *
     * @var string
     */
    protected $authorizationType = 'Bearer';

    /**
     * Base URL for the incoming API call
     *
     * @var string
     */
    protected $baseUrl;

    /**
     * Return the response in JSON format
     *
     * @var bool
     */
    protected $asJson = true;

    private $method;
    private $path;
    private $query = [];
    private $data = [];

    public static function build(...$args)
    {
        return app(static::class, $args);
    }

    public function __construct(Factory $factory)
    {
        $this->baseUrl = $this->getBaseUrl();
        $this->token = $this->getToken();
        $this->request = $factory->baseUrl($this->baseUrl);
        $this->resolveToken();
        $this->buildRequest($this->request);
    }

    protected function buildRequest(PendingRequest $pendingRequest)
    {
        $pendingRequest->acceptJson()->asJson();
    }

    public function buildMethodAndPath(string $method, string $path): ApiBuilder
    {
        return tap($this, function () use ($method, $path) {
            $this->method = strtoupper($method);
            $this->path = $path;
        });
    }

    public function buildData(array $data): ApiBuilder
    {
        return tap($this, function () use ($data) {
            return $this->data = array_merge_recursive($this->data, $data);
        });
    }

    public function buildQuery(array $query): ApiBuilder
    {
        return tap($this, function () use ($query) {
            return $this->query = array_merge_recursive($this->query, $query);
        });
    }

    public function send()
    {
        $url = Str::of($this->path)->when(!empty($this->query), function (Stringable $path) {
            $path->append('?', http_build_query($this->query));
        });

        if (!$this->method)
            throw new BadRequestException('HTTP method is unavailable. Please provide a HTTP method.');

        switch ($this->method) {
            case 'GET':
            case 'HEAD':
                $response = $this->request->send($this->method, $this->path, $this->query); break;
            case 'POST':
            case 'PUT':
            case 'PATCH':
            case 'DELETE':
                $response = $this->request->send($this->method, $url, $this->data); break;
            default:
                throw new \OutOfBoundsException('HTTP method is invalid. Please provide a correct HTTP method.');
        }

        return $this->asJson ? $response->object() : $response->json();
    }

    public function getBaseUrl()
    {
        if (isset($this->baseUrl))
            return $this->baseUrl;

        if (!is_null(Config::get('api-builder.base_uri')))
            return Config::get('api-builder.base_uri');

        throw new \RuntimeException('No baseUrl is configured.');
    }

    public function setBaseUrl($baseUrl): ApiBuilder
    {
        return tap($this, function () use ($baseUrl) {
            $this->baseUrl = $baseUrl;
            $this->request->baseUrl($baseUrl);
        });
    }

    public function getToken()
    {
        if (isset($this->token))
            return $this->token;

        if (!is_null(Config::get('api-builder.token')))
            return Config::get('api-builder.token');

        return null;
    }

    public function setToken($token)
    {
        return tap($this, function () use ($token) {
            $this->token = $token;
            $this->request->withToken($token, $this->authorizationType);
        });
    }

    private function resolveToken(): void
    {
        if (isset($this->token))
            $token = $this->token;
        else
            $token = config('api-builder.token');

        if ($token)
            $this->request->withToken($token, $this->authorizationType);
    }

    public function getRequest(): PendingRequest
    {
        return $this->request;
    }

    public function __call($method, $parameters)
    {
        if (method_exists($this->request, $method)) {
            call_user_func_array([$this->request, $method], $parameters);
            return $this;
        }

        throw new \BadMethodCallException(sprintf(
            'Method %s::%s does not exist.', static::class, $method
        ));
    }
}