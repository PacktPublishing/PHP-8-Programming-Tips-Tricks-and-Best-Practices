<?php
// /repo/src/Chat/Messsage/Api.php;
namespace Chat\Message;
// NOTE: $request must be a Psr\Http\Message\ServerRequestInterface instance
use Chat\Handler\ {
    GetHandler,
    PostHandler,
    NextHandler,
    GetAllNamesHandler,
    DeleteHandler
};
use Chat\Middleware\ {Access,Validate,ValidatePost};
use Chat\Message\Render;
use Psr\Http\Message\ServerRequestInterface;
class Pipe
{
    public static function exec(ServerRequestInterface $request)
    {
        $params   = $request->getQueryParams();
        $method   = strtolower($request->getMethod());
        $dontcare = (new Access())->process($request, new NextHandler());
        $response = match ($method) {
            'post'   => (new ValidatePost())->process($request, new PostHandler()),
            'delete' => (new DeleteHandler())->handle($request),
            'get'    => (!empty($params['all'])
                     ? (new GetAllNamesHandler())->handle($request)
                     : (new Validate())->process($request, new GetHandler())),
            default => (new Validate())->process($request, new GetHandler())
        };
        return Render::output($request, $response);
    }
}
