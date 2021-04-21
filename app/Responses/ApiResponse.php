<?php

namespace App\Responses;

use App\Formatters\ErrorMessageFormatter;
use Carbon\Carbon;
use Illuminate\Support\MessageBag;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiResponse {

    const INVALID_USERNAME = 'INVALID_USERNAME';
    const INVALID_PASSWORD = 'INVALID_PASSWORD';
    const UNKNOWN_RESOURCE = 'UNKNOWN_RESOURCE';
    const EMAIL_UNVERIFIED = 'EMAIL_UNVERIFIED';
    const UNAUTHORIZED = 'UNAUTHORIZED';
    const SEASON_CREATED = 'SEASON_CREATED';

    public static function send(int $code, $data = null, string $message = null, array $headers = [])
    {
        $response = [];

        if (null !== $data){
            $response['Data'] = $data;
        }

        if ($data instanceof MessageBag){
            $response['Data'] = ErrorMessageFormatter::format($data);
        }

        if (null !== $message){
            $response['Message'] = $message;
        }

        $response['Timezone'] = env('APP_TIMEZONE');
        $response['DateTime'] = Carbon::now()->format(env('APP_DATETIME_FORMAT'));
        $response['EpochTime'] = Carbon::now()->timestamp;

        if ('testing' !== env('APP_ENV')) {
            $response['ExecutionTime'] = round(microtime(true) * 1000) - START . ' ms';
        }

        $result = (new JsonResponse($response, $code, $headers))->setEncodingOptions(JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        return $result;
    }

    public static function message(string $message){
        return static::send(400, null, $message);
    }
}