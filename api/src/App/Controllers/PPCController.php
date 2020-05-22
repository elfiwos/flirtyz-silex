<?php
/**
 * Created by IntelliJ IDEA.
 * User: kibrom
 * Date: 6/22/17
 * Time: 5:31 PM
 */

namespace App\Controllers;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PPCController{

    protected $ppcService;

    public function __construct($service)
    {
        $this->ppcService = $service;
    }

    public function registerClick(Request $request){

        $ad_id = $request->request->get('ad_id');

        $click = $this->ppcService->getClickByAdId($ad_id);

        $new_click = array(

            'ad_id' => $ad_id,
            'click_count'  => $click[0]['click_count'] + 1,
            'updated_at'  => date("Y-m-d"),
        );

        if(empty($click)){

            return new JsonResponse($this->ppcService->registerClick($new_click));

        }else{

            return new JsonResponse($this->ppcService->updateAdClick($new_click,$ad_id));
        }

    }

    public function getClickByAdId($ad_id){

        return new JsonResponse($this->ppcService->getClickByAdId($ad_id));
    }
    
    public function updateAdClick($new_click,$ad_id){

        return new JsonResponse($this->ppcService->updateAdClick($new_click,$ad_id));
        
    }
    
    public function getAllAdClickes(){
        
        return new JsonResponse($this->ppcService->getAllAdClickes());
    }
}