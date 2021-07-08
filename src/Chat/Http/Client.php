<?php
namespace Chat\Http;

class Client
{
    public const POST_HEADERS  = [
        'Accept: application/json',
        'User-Agent: PHP',
        'Content-type: application/x-www-form-urlencoded',
    ];
    public const GET_HEADERS  = [
        'Accept: application/json',
        'User-Agent: PHP',
    ];
    /**
     * Handles a GET to the API end point $url
     *
     * @param string $url : API end point
     * @return string $json : JSON data
     */
    public static function doGet(string $url)
    {
        $opts = [
            'http' => [
                'method'     => 'GET',
                'header'     => implode("\r\n", self::GET_HEADERS)
            ]
        ];
        $context = stream_context_create($opts);
        $response = file_get_contents($url, FALSE, $context);
        return json_decode($response, TRUE);
    }
    /**
     * Handles a DELETE to the API end point $url
     *
     * @param string $url : API end point
     * @return string $json : JSON data
     */
    public static function doDelete(string $url)
    {
        $opts = [
            'http' => [
                'method'     => 'DELETE',
                'header'     => implode("\r\n", self::GET_HEADERS)
            ]
        ];
        $context = stream_context_create($opts);
        $response = file_get_contents($url, FALSE, $context);
        return json_decode($response, TRUE);
    }
    /**
     * Handles a POST to the API end point $url
     *
     * @param string $url : API end point
     * @param array $post : usually $_POST
     * @return array $json : JSON data | []
     */
    public static function doPost(string $url, array $post) : array
    {
        $opts = [
            'http' => [
                'method'     => 'POST',
                'user-agent' => 'PHP',
                'header'     => implode("\r\n", self::POST_HEADERS),
                'content'    => http_build_query($post)
            ]
        ];
        $context  = stream_context_create($opts);
        $response = file_get_contents($url, FALSE, $context);
        $data     = json_decode($response, TRUE);
        if (json_last_error()) {
            return ['status' => 'fail', 'data' => ['error' => json_last_error_msg(), 'response' => var_export($response, TRUE)]];
        } else {
            return $data;
        }
    }
}
