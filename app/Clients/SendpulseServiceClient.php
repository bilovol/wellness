<?php

namespace App\Clients;

use App\Exceptions\UnauthorizedException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Psr\SimpleCache\InvalidArgumentException;

class SendpulseServiceClient extends BaseServiceClient
{
    const GRANT_TYPE_CLIENT_CREDENTIALS = 'client_credentials';

    /**
     * @var string
     */
    public $tokenStorage;

    /**
     * @var string
     */
    public $tokenStorageDefaultTtl;

    /**
     * @var string
     */
    public $tokenPrefix;

    /**
     * @var bool
     */
    public $tokenRefreshed = false;

    /**
     * @var string
     */
    public $clientSecret;

    /**
     * @var string
     */
    public $clientId;

    public function __construct(string $clientId, string $clientSecret)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;

        $this->baseUrl = config('sendpulse.api.url');

        $this->tokenPrefix = config('sendpulse.token.prefix');
        $this->tokenStorage = config('sendpulse.token.storage');
        $this->tokenStorageDefaultTtl = config('sendpulse.token.tll');

    }

    /**
     * @param string $path
     * @param string $method
     * @param array $data
     * @param bool $useToken
     * @return array|null
     * @throws InvalidArgumentException
     * @throws UnauthorizedException
     */
    public function executeRequest(string $path, string $method = self::METHOD_GET, array $data = array(), bool $useToken = true): ?array
    {
        $url = $this->baseUrl . self::PATH_DELIMITER . $path;
        $headers = [];

        if (empty($this->clientId) || empty($this->clientSecret)) {
            throw new UnauthorizedException('Could not connect to api, check your ID and SECRET');
        }

        if ($useToken) {
            $token = $this->getAccessToken() ?? $this->getNewAccessToken();
            $headers['Authorization'] = self::TOKEN_TYPE_BEARER . ' ' . $token;
        }

        switch ($method) {
            case self::METHOD_POST:
                $headers['Content-Type'] = 'application/json';
                $response = Http::withHeaders($headers)->post($url, $data);
                break;
            case self::METHOD_PUT:
                $headers['Content-Type'] = 'application/json';
                $response = Http::withHeaders($headers)->put($url, $data);
                break;
            case self::METHOD_DELETE:
                $headers['Content-Type'] = 'application/json';
                $response = Http::withHeaders($headers)->delete($url, $data);
                break;
            default:
                $response = Http::withHeaders($headers)->get($url, $data);
        }

        $body = json_decode($response->body(), true);

        return $body ?? [];
    }

    /**
     * @return string|null
     * @throws InvalidArgumentException
     */
    public function getAccessToken(): ?string
    {
        return Cache::store($this->tokenStorage)->get($this->tokenPrefix . $this->clientId);
    }


    /**
     * @return string|null
     */
    public function getNewAccessToken(): ?string
    {
        $result = $this->post('oauth/access_token', [
            'grant_type' => self::GRANT_TYPE_CLIENT_CREDENTIALS,
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret
        ], false);

        $expired = $result['expires_in'] ?? $this->tokenStorageDefaultTtl;
        $accessToken = $result['access_token'] ?? null;

        if (!empty($accessToken)) {
            Cache::store($this->tokenStorage)->put($this->tokenPrefix . $this->clientId, $accessToken, $expired);
        }

        return $accessToken;
    }

}
