<?php

namespace App\Controllers;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class AdvertismentsController
{

    protected $adService;

    public function __construct($service)
    {
        $this->adService = $service;
    }

    public function getAll()
    {
        return new JsonResponse($this->adService->getAll());
    }

    public function save(Request $request)
    {
      $base64_string = $request->request->get('file') ;
      $output_file = $request->request->get('image') ;

      $ifp = fopen($_SERVER["DOCUMENT_ROOT"].'/admin/uploads/advertisment/'.$output_file, "wb");

       $data = explode(',', $base64_string);
      fwrite($ifp, base64_decode($data[1])); 
      fclose($ifp);
   

   $dimension = getimagesize($_SERVER["DOCUMENT_ROOT"].'/admin/uploads/advertisment/'.$output_file);
    $width = $dimension[0];
    $height = $dimension[1];


   
    if($width < 310 || $width > 330 || $height < 40 || $height > 60){
    unlink($_SERVER["DOCUMENT_ROOT"].'/admin/uploads/advertisment/'.$output_file);
    $message = 1;
    }              
   else{

        $post = array(
        'image' => $request->request->get('image'),
        'description'  => $request->request->get('description'),
        'name'  => $request->request->get('name'),
        'url'  => $request->request->get('url'),
        'updated_at'  => date("Y-m-d"),
        'created_at'  => date("Y-m-d"),
    );
       $this->adService->save($post);
        $message = 0;
     }
     return new JsonResponse(array("message" => $message));
    }

    public function update($id, Request $request)
    {
        
      if($request->request->get('file'))
      {
      $base64_string = $request->request->get('file') ;
      $output_file = $request->request->get('image') ;

      $ifp = fopen($_SERVER["DOCUMENT_ROOT"].'/admin/uploads/advertisment/'.$output_file, "wb");

       $data = explode(',', $base64_string);

       fwrite($ifp, base64_decode($data[1])); 
      fclose($ifp);
   

   $dimension = getimagesize($_SERVER["DOCUMENT_ROOT"].'/admin/uploads/advertisment/'.$output_file);
    $width = $dimension[0];
    $height = $dimension[1];
   
     if($width < 310 || $width > 330 || $height < 40 || $height > 60){
    unlink($_SERVER["DOCUMENT_ROOT"].'/admin/uploads/advertisment/'.$output_file);
    $message = $_SERVER["DOCUMENT_ROOT"].'/admin/uploads/advertisment/'.$output_file;
    }              
   else{

      $post = array(
        'image' => $request->request->get('image'),
        'description'  => $request->request->get('description'),
        'name'  => $request->request->get('name'),
        'url'  => $request->request->get('url'),
        'updated_at'  => date("Y-m-d"),
    );


        $this->adService->update($id, $post);
         $message = 0;
        //return new JsonResponse($id);
     }
 }else{
     $post = array(
        'description'  => $request->request->get('description'),
        'name'  => $request->request->get('name'),
        'url'  => $request->request->get('url'),
        'updated_at'  => date("Y-m-d"),
    );
     $this->adService->update($id, $post);
         $message = 0;
  }
     return new JsonResponse(array("message" => $message));
 }
    

    public function delete($id)
    {

        return new JsonResponse($this->adService->delete($id));

    }


    public function getDataFromRequest(Request $request)
    {
        return $ad = array(
            "ad" => $request->request->get("ad")
        );
    }
}