<?php
// /repo/src/Http/Request.php
namespace Http;
class Request
{
    public $url      = '';
    public $method   = 'GET';
    public $scheme   = '';
    public $host     = '';
    public $port     = '';
    public $user     = '';
    public $pass     = '';
    public $path     = '';
    public $query    = '';
    public $fragment = '';
    public $debug    = FALSE;
    public function __construct(string $url)
    {
        $result = [];
        $parsed = parse_url($url);
        $vars   = array_keys(get_object_vars($this));
        foreach ($vars as $name)
            $this->$name = $parsed[$name] ?? '';
        if (!empty($this->query))
            parse_str($this->query, $result);
        $this->query = $result;
        $this->url   = $url;
    }
}
