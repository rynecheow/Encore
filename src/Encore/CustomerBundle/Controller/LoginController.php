<?php

namespace Encore\CustomerBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller{

    public function indexAction(){
        return new Response("<h1>Login</h1>");
    }
} 