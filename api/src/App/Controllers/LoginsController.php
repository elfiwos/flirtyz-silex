<?php

namespace App\Controllers;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LoginsController 
{
 
    protected $adService;

    public function __construct($service)
    {
        $this->adService = $service;
    }

    public function login(Request $request)
    {

        $username  = $request->request->get('username');
        $password  = $request->request->get('password');
         return new JsonResponse($this->adService->autenticate($username, $password));
    }

    public function logout()
    {
        return new JsonResponse($this->adService);
    }

    
    public function getDataFromRequest(Request $request)
    {
        return $ad = array(
            "ad" => $request->request->get("ad")
        );
    }
}