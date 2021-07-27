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
    public function exec(ServerRequestInterface $request)
    {
        $params   = $request->getQueryParams();
        $method   = strtolower($request->getMethod());
        $dontcare = (new Access())->process($request, new NextHandler());
        switch ($method) {
            case 'post' :
                $response = (new ValidatePost())->process($request, new PostHandler());
                break;
            case 'delete' :
                $response = (new DeleteHandler())->handle($request);
                break;
            case 'get' :
                if (!empty($params['all'])) {
                    $response = (new GetAllNamesHandler())->handle($request);
                    break;
                }
            default    :
                $response = (new Validate())->process($request, new GetHandler());
        }
        return Render::output($request, $response);
    }
}
