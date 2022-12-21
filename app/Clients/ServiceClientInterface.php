<?php

namespace App\Clients;

interface ServiceClientInterface
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_DELETE = 'DELETE';
    const PATH_DELIMITER = '/';
    const TOKEN_TYPE_BEARER = 'Bearer';
    const TOKEN_TTL_FIX = 100;

    /**
     * @param string $path
     * @param array $data
     * @param bool $useToken
     * @return array|null
     */
    public function get(string $path, array $data = [], bool $useToken = false): ?array;

    /**
     * @param string $path
     * @param array $data
     * @param bool $useToken
     * @return array|null
     */
    public function post(string $path, array $data = [], bool $useToken = true): ?array;

    /**
     * @param string $path
     * @param array $data
     * @param bool $useToken
     * @return array|null
     */
    public function put(string $path, array $data = [], bool $useToken = true): ?array;

    /**
     * @param string $path
     * @param array $data
     * @param bool $useToken
     * @return array|null
     */
    public function delete(string $path, array $data = [], bool $useToken = true): ?array;

    /**
     * @param string $path
     * @param string $method
     * @param array $data
     * @param bool $useToken
     * @return array|null
     */
    public function executeRequest(string $path, string $method = self::METHOD_GET, array $data = array(), bool $useToken = true): ?array;

    /**
     * @return string|null
     */
    public function getAccessToken(): ?string;
}
