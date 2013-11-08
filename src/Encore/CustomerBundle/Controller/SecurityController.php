<?php

namespace Encore\CustomerBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Controller\SecurityController as BaseSecurityController;
use Symfony\Component\Security\Core\SecurityContext;

class SecurityController extends BaseSecurityController
{
    public function loginAction(Request $request)
    {
        $sc = $this->container->get('security.context');

        if ($sc->isGranted('ROLE_CUSTOMER')) {
            $url = $this->container->get('router')->generate('encore_home');

            return new RedirectResponse($url);
        }

        return parent::loginAction($request);
    }

    protected function renderLogin(array $data)
    {
        $data['user'] = null;
        $data['referer_url'] = $this->container->get('request')->headers->get('referer');

        return parent::renderLogin($data);
    }
}
