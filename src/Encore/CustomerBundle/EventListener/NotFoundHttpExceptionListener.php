<?php
namespace Encore\CustomerBundle\EventListener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Matcher\RequestMatcherInterface;
use Symfony\Component\Routing\RouterInterface;

class NotFoundHttpExceptionListener
{

    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if (!($exception instanceof NotFoundHttpException)) {
            return;
        }

        $request = $event->getRequest();
        $path = $request->getPathInfo();

        // check if the request path ends with a backslash (/)
        // the query string is supposedly not present in the path
        if ('/' !== substr($path, -1)) {
            return;
        }

        // create a modified request
        $serverParams = $request->server->all();
        $requestUri = $request->getRequestUri();
        $serverParams['REQUEST_URI'] = preg_replace('/\/(\?|$)/', '$1', $requestUri, 1);
        $correctedRequest = $request->duplicate(
            null, // $query
            null, // $request
            null, // $attributes
            null, // $cookies
            null, // $files
            $serverParams
        );

        // match the corrected path using the router
        try {
            if ($this->router instanceof RequestMatcherInterface) {
                $this->router->matchRequest($correctedRequest);
            } else {
                $this->router->match($correctedRequest->getPathInfo());
            }

            $response = new RedirectResponse($correctedRequest->getRequestUri(), 301);

            // set the redirect response onto the event
            $event->setResponse($response);
        } catch (\Exception $e) {
            // the router failed to match the corrected path
            // suppress the exception
        }
    }
}
