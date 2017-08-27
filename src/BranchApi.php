<?php

namespace ChanceZeus\BranchApi;

use ChanceZeus\BranchApi\App\AppConfig;
use ChanceZeus\BranchApi\Link\Link;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

class BranchApi
{
    const BASE_URL = 'https://api.branch.io';
    const ENDPOINT_URL = '/v1/url';
    const ENDPOINT_URL_BULK = '/v1/url/bulk';
    const ENDPOINT_APP = '/v1/app';
    const ENDPOINT_CREDIT = '/v1/credits';
    const ENDPOINT_REDEEM = '/v1/redeem';
    const ENDPOINT_RECONCILE = '/v1/reconcile';
    const ENDPOINT_CREDIT_HISTORY = '/v1/credithistory';
    const ENDPOINT_EVENT = '/v1/event';
    const ENDPOINT_EVENT_RESPONSE = '/v1/eventresponse';

    /** @var string */
    private $key;

    /** @var string */
    private $secret;

    /** @var string */
    private $userId;

    /** @var Client */
    private $client;

    /**
     * BranchApi constructor.
     *
     * @param string $key
     * @param string $secret
     * @param string $userId
     */
    public function __construct(string $key, string $secret, string $userId)
    {
        $this->key = $key;
        $this->secret = $secret;
        $this->userId = $userId;

        $this->client = new Client([
            'base_uri' => static::BASE_URL,
            RequestOptions::HTTP_ERRORS => false,
        ]);
    }

    /**
     * @param string $url
     * @param bool $async
     * @return Link|\GuzzleHttp\Promise\PromiseInterface
     */
    public function getLink(string $url, bool $async = false)
    {
        $query = [
            'url' => $url,
            'branch_key' => $this->key,
        ];

        if ($async) {
            return $this->get(static::ENDPOINT_URL, $query, null, true)
                ->then(function (array $response) {
                    return Link::parse($response);
                });
        }

        return Link::parse($this->get(static::ENDPOINT_URL, $query));
    }

    /**
     * @param Link $link
     * @param bool $async
     * @return string|\GuzzleHttp\Promise\PromiseInterface
     * @throws BranchApiException
     */
    public function createLink(Link $link, bool $async = false)
    {
        $data = array_merge(
            [
                'branch_key' => $this->key
            ],
            $link->build()
        );

        if ($async) {
            return $this->post(static::ENDPOINT_URL, $data, null, null, true)
                ->then(function (array $response) {
                    $url = array_get($response, 'url');

                    if (!$url) {
                        if ($error = array_get($response, 'error')) {
                            throw new BranchApiException("Received error {$error} from api");
                        }

                        throw new BranchApiException("Missing URL in response");
                    }

                    return $url;
                });
        }

        $response = $this->post(static::ENDPOINT_URL, $data);

        $url = array_get($response, 'url');
        if (!$url) {
            if ($error = array_get($response, 'error')) {
                throw new BranchApiException("Received error {$error} from api");
            }

            throw new BranchApiException("Missing URL in response");
        }

        return $url;
    }

    public function createDynamicLink(Link $link, bool $async = false)
    {
        if ($async) {
            return $this->getAppConfig(true)
                ->then(function (AppConfig $appConfig) use ($link) {
                    $domain = $appConfig->shortUrlDomain;
                    if (!$domain && !($domain = $appConfig->defaultShortUrlDomain)) {
                        throw new BranchApiException("Unable to determine link domain");
                    }

                    $query = array_filter($link->build(), function ($value) {
                        return !empty($value);
                    });

                    return "https://{$domain}/?" . http_build_query($query);
                });
        }

        $appConfig = $this->getAppConfig();

        $domain = $appConfig->shortUrlDomain;
        if (!$domain && !($domain = $appConfig->defaultShortUrlDomain)) {
            throw new BranchApiException("Unable to determine link domain");
        }

        $query = array_filter($link->build(), function ($value) {
            return !empty($value);
        });

        return "https://{$domain}/?" . http_build_query($query);
    }

    /**
     * @param string $url
     * @param Link $link
     * @param bool $async
     * @return Link|\GuzzleHttp\Promise\PromiseInterface
     */
    public function updateLink(string $url, Link $link, bool $async = false)
    {
        $data = array_except(
            array_merge(
                [
                    'key' => $this->key,
                    'secret' => $this->secret,
                ],
                $link->build()
            ),
            [
                'alias',
                'type',
            ]
        );

        $query = [
            'url' => $url
        ];

        if ($async) {
            return $this->put(static::ENDPOINT_URL, $data, $query, null, true)
                ->then(function (array $response) {
                    return Link::parse($response);
                });
        }

        return Link::parse($this->put(static::ENDPOINT_URL, $data, $query));
    }

    /**
     * @param Link[] $links
     * @param bool $async
     * @return array|\GuzzleHttp\Promise\PromiseInterface
     */
    public function batchCreateLink(array $links, bool $async = false): array
    {
        $data = array_map(function (Link $link) {
            return $link->build();
        }, $links);

        if ($async) {
            $this->post(static::ENDPOINT_URL_BULK . "/{$this->key}", $data, null, null, true)
                ->then(function (array $response) {
                    $results = [];

                    foreach ($response as $link) {
                        $data = array_get($link, 'url');

                        if (!$data && ($error = array_get($link, 'error'))) {
                            $data = new BranchApiException("Received error {$error} from api");
                        }

                        $results[] = $data;
                    }

                    return $results;
                });
        }

        $response = $this->post(static::ENDPOINT_URL_BULK . "/{$this->key}", $data);

        $results = [];

        foreach ($response as $link) {
            $data = array_get($link, 'url');

            if (!$data && ($error = array_get($link, 'error'))) {
                $data = new BranchApiException("Received error {$error} from api");
            }

            $results[] = $data;
        }

        return $results;
    }

    /**
     * @param bool $async
     * @return AppConfig|\GuzzleHttp\Promise\PromiseInterface
     */
    public function getAppConfig(bool $async = false): AppConfig
    {
        if ($async) {
            return $this->get(static::ENDPOINT_APP . "/{$this->key}", ['branch_secret' => $this->secret], null, true)
                ->then(function (array $response) {
                    return AppConfig::parse($response);
                });
        }

        return AppConfig::parse($this->get(static::ENDPOINT_APP . "/{$this->key}", ['branch_secret' => $this->secret]));
    }

    /**
     * @param string $endpoint
     * @param array|null $query
     * @param array|null $headers
     * @param bool $async
     * @return array|\GuzzleHttp\Promise\PromiseInterface
     */
    private function get(string $endpoint, array $query = null, array $headers = null, bool $async = false)
    {
        $params = [
            RequestOptions::HEADERS => $headers,
            RequestOptions::QUERY => $query,
        ];

        if ($async) {
            return $this->client
                ->getAsync(static::ENDPOINT_URL, $params)
                ->then(function (ResponseInterface $response) {
                    return $this->decodeResponse($response);
                });
        }

        return $this->decodeResponse($this->client->get($endpoint, $params));
    }

    /**
     * @param string $endpoint
     * @param array $body
     * @param array|null $query
     * @param array|null $headers
     * @param bool $async
     * @return array|\GuzzleHttp\Promise\PromiseInterface
     */
    private function post(string $endpoint, array $body, array $query = null, array $headers = null, bool $async = false)
    {
        $params = [
            RequestOptions::HEADERS => $headers,
            RequestOptions::QUERY => $query,
            RequestOptions::JSON => $body,
        ];

        if ($async) {
            return $this->client
                ->postAsync(static::ENDPOINT_URL, $params)
                ->then(function (ResponseInterface $response) {
                    return $this->decodeResponse($response);
                });
        }

        return $this->decodeResponse($this->client->post($endpoint, $params));
    }

    /**
     * @param string $endpoint
     * @param array $body
     * @param array|null $query
     * @param array|null $headers
     * @param bool $async
     * @return array|\GuzzleHttp\Promise\PromiseInterface
     */
    private function put(string $endpoint, array $body, array $query = null, array $headers = null, bool $async = false)
    {
        $params = [
            RequestOptions::HEADERS => $headers,
            RequestOptions::QUERY => $query,
            RequestOptions::JSON => $body,
        ];

        if ($async) {
            return $this->client
                ->putAsync(static::ENDPOINT_URL, $params)
                ->then(function (ResponseInterface $response) {
                    return $this->decodeResponse($response);
                });
        }

        return $this->decodeResponse($this->client->put($endpoint, $params));
    }

    /**
     * @param ResponseInterface $response
     * @return array
     * @throws BranchApiException
     */
    private function decodeResponse(ResponseInterface $response): array
    {
        if (($statusCode = $response->getStatusCode()) % 100 !== 2) {
            throw new BranchApiException("Request failed with statuscode {$statusCode}");
        }

        $body = json_decode($response->getBody()->getContents(), true);

        if (!$body || json_last_error() !== JSON_ERROR_NONE) {
            throw new BranchApiException("Could not decode response");
        }

        return $body;
    }
}
