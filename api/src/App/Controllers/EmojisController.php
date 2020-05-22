<?php

namespace App\Controllers;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class EmojisController
{

    protected $imojisService;

    public function __construct($service)
    {
        $this->imojisService = $service;
    }

    public function getAll()
    {
        return new JsonResponse($this->imojisService->getAll());
    }

    public function getAllEmojis($catId)
    {
        return new JsonResponse($this->imojisService->getAllEmojis($catId));
    }

    public function getAllCategories()
    {
        return new JsonResponse($this->imojisService->getAllCategories());
    }
     public function getCatName($id)
    {
        return new JsonResponse($this->imojisService->getCatName($id));
    }
    public function categoriesUUID()
    {

        return new JsonResponse($this->imojisService->getFreeCategories());  
      
    }

    public function getCategory($id)
    {
        return new JsonResponse($this->imojisService->getCategory($id));
    }
    public function getEmojiByCategory($id, $uuid)
    {

    $deletedCategories = $this->imojisService->emojisUUID($uuid);
        if(empty($deletedCategories)){
        return new JsonResponse($this->imojisService->getEmojiByCategory($id));
        }
        $allCategories = $this->imojisService->getEmojiByCategory($id);
         foreach ($allCategories as $key=>$category) {
           foreach ($deletedCategories as $deletedCategory) {
           if($category['id'] == $deletedCategory['emoji_id']){
             unset($allCategories[$key]);
            }
        }
         }

        return new JsonResponse(array_values($allCategories));

       
    }
    public function getFavoriteEmojs($uuid)
    {

        $deletedCategories = $this->imojisService->favoriteUUID($uuid);
        if(empty($deletedCategories)){
        return new JsonResponse($this->imojisService->getFavoriteEmojs($uuid));
        }
        $allCategories = $this->imojisService->getFavoriteEmojs($uuid);
         foreach ($allCategories as $key=>$category) {
           foreach ($deletedCategories as $deletedCategory) {
           if($category['id'] == $deletedCategory['emoji_id']){
             unset($allCategories[$key]);
            }
        }
         }

        return new JsonResponse(array_values($allCategories));
        
    }
    public function getRecentEmojs($uuid)
    {
        $deletedCategories = $this->imojisService->recentUUID($uuid);
        if(empty($deletedCategories)){
         return new JsonResponse($this->imojisService->getRecentEmojs($uuid));
        }
        $allCategories = $this->imojisService->getRecentEmojs($uuid);
         foreach ($allCategories as $key=>$category) {
           foreach ($deletedCategories as $deletedCategory) {
           if($category['id'] == $deletedCategory['emoji_id']){
             unset($allCategories[$key]);
            }
        }
         }

        return new JsonResponse(array_values($allCategories));
       
    }
    public function getTheme($uuid)
    {
        return new JsonResponse($this->imojisService->getTheme($uuid));
    }
    public function getfreeEmojis()
    {
        return new JsonResponse($this->imojisService->getfreeEmojis());
    }
    public function getpaidEmojis()
    {
        return new JsonResponse($this->imojisService->getpaidEmojis());
    }

     public function saveRecent($emoji_id, $uuid)
    {
         $deletedfav = $this->imojisService->recentUUIDID($emoji_id,$uuid);

       $recentEmojs = $this->imojisService->getRecentEmojs($uuid);
       foreach ($recentEmojs as $remoji) {
           if($emoji_id == $remoji['emoji_id']){
           $recent = array(
        'emoji_id' => $emoji_id,
        'uuid'  => $uuid,
        'updated_at'  => date("Y-m-d"),
            );
           return new JsonResponse($this->imojisService->updateRecent($recent,$emoji_id,$uuid));
           }
       }

        $recent = array(
        'emoji_id' => $emoji_id,
        'uuid'  => $uuid,
        'created_at'  => date("Y-m-d"),
    );
        return new JsonResponse($this->imojisService->saveRecent($recent));
    }
     public function saveTheme($color, $uuid)
    {
        $recentEmojs = $this->imojisService->getTheme($uuid);
        if(is_array($recentEmojs) && count($recentEmojs) > 0){
        $theme = array(
        'theme' => $color,
        'uuid'  => $uuid
          );
        return new JsonResponse($this->imojisService->updateTheme($theme,$uuid));
           }
          
        $theme = array(
        'theme' => $color,
        'uuid'  => $uuid
    );
        return new JsonResponse($this->imojisService->saveTheme($theme));
    }
     public function saveFavorite($emoji_id, $uuid)
    {
        $deletedfav = $this->imojisService->favoriteUUIDID($emoji_id,$uuid);
         
           $recentEmojs = $this->imojisService->getFavoriteEmojs($uuid);
       foreach ($recentEmojs as $remoji) {
           if($emoji_id == $remoji['emoji_id']){
           $recent = array(
        'emoji_id' => $emoji_id,
        'uuid'  => $uuid,
        'updated_at'  => date("Y-m-d"),
            );
           return new JsonResponse($this->imojisService->updateFavorite($recent,$emoji_id,$uuid));
           }
       }

          $favorite = array(
        'emoji_id' => $emoji_id,
        'uuid'  => $uuid,
        'created_at'  => date("Y-m-d"),
    );
        return new JsonResponse($this->imojisService->saveFavorite($favorite));
    }
    public function getFreeCategories()
    {
        return new JsonResponse($this->imojisService->getFreeCategories());
    }
    public function getPaidCategories()
    {
        return new JsonResponse($this->imojisService->getPaidCategories());
    }

    public function uploadImage($upload_dir='emojicategory')
    {
        $target_dir = $_SERVER["DOCUMENT_ROOT"].'/uploads/'.$upload_dir.'/';
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        return new JsonResponse("The file ". basename( $_FILES["file"]["name"]). " has been uploaded.");
        } else {
            return new JsonResponse("Sorry, there was an error uploading your file.");
        }
    }

    public function save(Request $request)
    {
        $emoji = [];
        $emoji['image'] = $request->request->get('image');
        $emoji['name'] = $request->request->get('name');
        $emoji['category_id'] = $request->request->get('category_id');
        return new JsonResponse(array("id" => $this->imojisService->save($emoji)));

    }

    public function saveCategory(Request $request)
    {

        $emojiCategory = [];
        $emojiCategory['image'] = $request->request->get('image');
        $emojiCategory['name'] = $request->request->get('name');
        $emojiCategory['version'] = $request->request->get('version');
        return new JsonResponse(array("id" => $this->imojisService->saveCategory($emojiCategory)));

    }
    public function removeCategory($uuid, $id)
    {

        $deletedCategory = array(
        'category_id' => $id,
        'uuid'  => $uuid,
    );
        return new JsonResponse($this->imojisService->removeCategory($deletedCategory));

    }
    public function removeEmoji($uuid, $id)
    {

        $deletedCategory = array(
        'emoji_id' => $id,
        'uuid'  => $uuid,
    );
        return new JsonResponse($this->imojisService->removeEmoji($deletedCategory));

    }

public function removeFavorite($uuid, $id)
    {

        $deletedCategory = array(
        'emoji_id' => $id,
        'uuid'  => $uuid,
    );
        return new JsonResponse($this->imojisService->removeFavorite($deletedCategory));

    }

public function removeRecent($uuid, $id)
    {

        $deletedCategory = array(
        'emoji_id' => $id,
        'uuid'  => $uuid,
    );
        return new JsonResponse($this->imojisService->removeRecent($deletedCategory));

    }

public function removeTheme($uuid, $id)
    {

        $deletedCategory = array(
        'theme_id' => $id,
        'uuid'  => $uuid,
    );
        return new JsonResponse($this->imojisService->removeTheme($deletedCategory));

    }


    public function updateCategory($id, Request $request)
    {
        $emojiCategory = [];
        $emojiCategory['image'] = $request->request->get('image');
        $emojiCategory['name'] = $request->request->get('name');
        $emojiCategory['version'] = $request->request->get('version');
        $this->imojisService->updateCategory($id, $emojiCategory);
        return new JsonResponse($category);

    }

    public function update($id, Request $request)
    {
        $emoji = $this->getDataFromRequest($request);
        $this->imojisService->update($id, $emoji);
        return new JsonResponse($emoji);

    }

    public function delete($id)
    {
        return new JsonResponse($this->imojisService->delete($id));
    }

    public function deleteCategory($id)
    {
        return new JsonResponse($this->imojisService->deleteCategory($id));
    }

    public function getDataFromRequest(Request $request)
    {
        return $emoji = array(
            "emoji" => $request->request->get("emoji")
        );
    }
}