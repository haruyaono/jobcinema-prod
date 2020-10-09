<?php

namespace App\Http\Components;

class LineNotify
{
    private $line_notify;

    public function lineNotify($message)
    {
        $this->line_notify = config('app.line_notify');
        $token = $this->line_notify['token'];

        $query = http_build_query(['message' => $message]);
        $header = [
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Bearer ' . $token,
            'Content-Length: ' . strlen($query)
        ];

        $ch = curl_init('https://notify-api.line.me/api/notify');

        $options = [
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_POST            => true,
            CURLOPT_HTTPHEADER      => $header,
            CURLOPT_POSTFIELDS      => $query
        ];

        curl_setopt_array($ch, $options);
        curl_exec($ch);

        curl_close($ch);
    }
}
