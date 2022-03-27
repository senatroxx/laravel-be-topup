<?php

namespace App\Helpers;

class Response
{
    protected static $status;
    protected static $http_code;
    protected static $message;

    public static function status($status)
    {
        self::$status = $status;

        return new self;
    }

    public static function code($code)
    {
        self::$http_code = $code;

        return new self;
    }

    public static function message($message)
    {
        self::$message = $message;

        return new self;
    }

    private function success($data = null)
    {
        $code = self::$http_code;
        $status = self::$status;
        $message = self::$message;

        $response = [
            'meta' => [
                'status' => $status,
                'message' => ($message ? $message : null),
                'code' => ($code ? $code : 200),
            ],
        ];

        if ($data) {
            $response['data'] = $data;
        }

        return $response;
    }

    private function failed($error = null)
    {
        $code = self::$http_code;
        $status = self::$status;
        $message = self::$message;

        $response = [
            'meta' => [
                'code' => ($code ? $code : 400),
                'status' => $status,
                'message' => ($message ? $message : null),
            ],
        ];

        if ($error) {
            $response['error'] = (is_array($error)) ? $error : [$error];
        }

        return $response;
    }

    public function result($data = null)
    {
        $status = self::$status;
        $code = self::$http_code;

        if (empty($code)) {
            $code = ($status === 'success')
            ? 200
            : 400;
        }

        return response()->json(self::$status($data), $code);
    }
}
