<?php

namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Routing\Router;
use Symfony\Component\HttpFoundation\RedirectResponse;


class DespuesLogin implements AuthenticationSuccessHandlerInterface
{
    protected $router, $security;
    
    public function __construct(Router $router, AuthorizationChecker $security)
    {
        $this->router = $router;
        $this->security = $security;
    }
    
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        #ruta por defecto
        $url = 'mis_soportes';
        if($this->security->isGranted('ROLE_ADMIN')) {
            
            $url = 'soportes_admin';
        }
        $response = new RedirectResponse($this->router->generate($url));
            
        return $response;
    }
}

