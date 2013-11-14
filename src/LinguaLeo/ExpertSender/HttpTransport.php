<?php
namespace LinguaLeo\ExpertSender;

class HttpTransport
{
    const CONNECTION_ERROR = 312241;

    function __construct()
    {
    }

    public function query($url, $method = 'GET', $content = null)
    {
        $http = [
            'method' => $method,
            'header' => "Content-Type: text/xml\r\n",
            'timeout' => 30,
            'ignore_errors' => true
        ];

        if ($content != null) {
            $http['content'] = $content;
        }

        $context = stream_context_create(['http' => $http]);

        $result = @file_get_contents($url, false, $context);
        if ($result === false) {
            throw new \Exception("Can't connect to ES", self::CONNECTION_ERROR);
        }

        $headers = $http_response_header;
        $responseCode = 500;
        foreach ($headers as $header) {
            if (preg_match('~HTTP.+ ([0-9]+).+~', $header, $matches)) {
                $responseCode = $matches[1];
            }
        }

        return new ExpertSenderResponse($result, $responseCode);
    }

    public function post($url, $body)
    {
        return $this->query($url, 'POST', $body);
    }

    public function get($url, $data)
    {
        return $this->query($url . '?' . http_build_query($data), 'GET');
    }

    public function delete($url, $data)
    {
        return $this->query($url . '?' . http_build_query($data), 'DELETE');
    }
}