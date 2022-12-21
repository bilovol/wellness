<?php


namespace App\Http\Responses;

use Illuminate\Http\JsonResponse as CoreJsonResponse;


class JsonResponse extends CoreJsonResponse
{
    /**
     * @var array = [
     *      'data' => '(mixed)',
     *      'error' => '!(string)',
     *      'trace' => '!(string)',
     *      'code'=>'!(int)'
     *      'result'=>'!(bool)'
     *
     * ]
     */
    protected $responseData = [];

    public function __construct($data = null, $status = 200, $headers = [], $options = 0)
    {
        parent::__construct($data, $status, $headers, $options);

        if ($data) {
            $this->responseData['data'] = $data;
            parent::setData($this->responseData);
            $this->update();
        }
    }

    /**
     * @param string $error
     * @return $this
     */
    public function setError(string $error): JsonResponse
    {
        $this->responseData['error'] = $error;
        parent::setData($this->responseData);
        $this->update();

        return $this;
    }

    /**
     * @param $code
     * @return $this
     */
    public function setCode($code): JsonResponse
    {
        $this->responseData['code'] = $code;
        parent::setData($this->responseData);
        $this->update();

        return $this;
    }

    /**
     * @param bool $result
     * @return $this
     */
    public function setResult(bool $result): JsonResponse
    {
        $this->responseData['result'] = $result;
        parent::setData($this->responseData);
        $this->update();

        return $this;
    }

    /**
     * @param string $traceAsString
     * @return $this
     */
    public function setTrace(string $traceAsString): JsonResponse
    {
        if (empty($traceAsString)) {
            return $this;
        }

        $this->responseData['trace'] = $traceAsString;
        parent::setData($this->responseData);
        $this->update();

        return $this;
    }

}
