<?php

namespace App\Clients;

abstract class BaseServiceClient implements ServiceClientInterface
{
    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @param string $path
     * @param array $data
     * @param bool $useToken
     * @return array|null
     */
    public function get(string $path, array $data = [], bool $useToken = false): ?array
    {
        return $this->executeRequest($path, self::METHOD_GET, $data, $useToken);
    }

    /**
     * @param string $path
     * @param array $data
     * @param bool $useToken
     * @return array|null
     */
    public function post(string $path, array $data = [], bool $useToken = true): ?array
    {
        return $this->executeRequest($path, self::METHOD_POST, $data, $useToken);
    }

    /**
     * @param string $path
     * @param array $data
     * @param bool $useToken
     * @return array|null
     */
    public function put(string $path, array $data = [], bool $useToken = true): ?array
    {
        return $this->executeRequest($path, self::METHOD_PUT, $data, $useToken);
    }

    /**
     * @param string $path
     * @param array $data
     * @param bool $useToken
     * @return array|null
     */
    public function delete(string $path, array $data = [], bool $useToken = true): ?array
    {
        return $this->executeRequest($path, self::METHOD_DELETE, $data, $useToken);
    }
}
