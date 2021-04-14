<?php
// /repo/src/Http/Client/ClientInterface.php
namespace Http\Client;
use Http\Request;
interface StrategyInterface
{
    // send a request
    public function send(Request $request) : string|false;
}
