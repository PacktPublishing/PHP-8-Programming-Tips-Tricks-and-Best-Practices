<?php
// /repo/ch12/php8_chat_api.php
// NOTE: (1) $request must be a Psr\Http\Message\ServerRequestInterface instance
//       (2) autoloading must be configured to find these classes:
use Chat\Handler\ {
    GetHandler,
    PostHandler,
    NextHandler,
    GetAllNamesHandler,
    DeleteHandler
};
use Chat\Middleware\ {Access,Validate,ValidatePost};
use Chat\Message\Render;
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
