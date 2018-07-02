<?php

namespace App\Redirection;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class RedirectingController
{
    public function removeTrailingSlash(Request $request)
    {
        $pathInfo = $request->getPathInfo();
        $requestUri = $request->getRequestUri();

        $url = str_replace($pathInfo, rtrim($pathInfo, ' /'), $requestUri);

        // 308 (Permanent Redirect) is similar to 301 (Moved Permanently) except
        // that it does not allow changing the request method (e.g. from POST to GET)
        return new RedirectResponse($url, 308);
    }
}
