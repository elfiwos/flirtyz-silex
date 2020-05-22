<?php

namespace App\Services;

class EmojisService extends BaseService
{

    public function getAll()
    {
        return $this->db->fetchAll("SELECT * FROM emoji");
    }

    public function getAllEmojis($catId)
    {
        return $this->db->fetchAll("SELECT * FROM emoji where category_id=$catId");
    }

    public function getAllCategories()
    {
        return $this->db->fetchAll("SELECT * FROM category");
    }
    public function getCatName($catId)
    {
        return $this->db->fetchAll("SELECT name FROM category where id=$catId");
    }
    public function categoriesUUID($uuid)
    {
        return $this->db->fetchAll("SELECT * FROM deleted_categories where uuid ='".$uuid."'");
    }
    public function emojisUUID($uuid)
    {
        return $this->db->fetchAll("SELECT * FROM deleted_emojis where uuid ='".$uuid."'");
    }
    public function favoriteUUID($uuid)
    {
        return $this->db->fetchAll("SELECT * FROM deleted_favorites where uuid ='".$uuid."'");
    }
     public function favoriteUUIDID($emoji_id,$uuid)
    {
        return $this->db->delete("deleted_favorites", array("emoji_id" => $emoji_id,"uuid" => $uuid));
    }
     public function recentUUIDID($emoji_id,$uuid)
    {
        return $this->db->delete("deleted_recents", array("emoji_id" => $emoji_id,"uuid" => $uuid));
    }
    public function recentUUID($uuid)
    {
        return $this->db->fetchAll("SELECT * FROM deleted_recents where uuid ='".$uuid."'");
    }
    public function getCategory($id)
    {
        return $this->db->fetchAll("SELECT * FROM category where id=$id");
    }

     public function getEmojiByCategory($id)
    {
        return $this->db->fetchAll("SELECT * FROM emoji where category_id=$id");
    }
    public function getFavoriteEmojs($uuid)
    {
        return $this->db->fetchAll("SELECT * FROM favorites LEFT JOIN emoji ON favorites.emoji_id=emoji.id where uuid='".$uuid."'");
    }
     public function getTheme($uuid)
    {
        return $this->db->fetchAll("SELECT * FROM themes where uuid='".$uuid."'");
    }
     public function getRecentEmojs($uuid)
    {
        return $this->db->fetchAll("SELECT * FROM recent LEFT JOIN emoji ON recent.emoji_id=emoji.id where uuid='".$uuid."'");
    }
     public function getfreeEmojis()
    {
        return $this->db->fetchAll("SELECT * FROM emoji LEFT JOIN category ON emoji.category_id=category.id where version = 'Free'");
    }
     public function getpaidEmojis()
    {
        return $this->db->fetchAll("SELECT * FROM emoji LEFT JOIN category ON emoji.category_id=category.id where version = 'Premium'");
    }

    public function getFreeCategories()
    {
        return $this->db->fetchAll("SELECT * FROM category WHERE version = 'Free'");
    }
    public function getPaidCategories()
    {
        return $this->db->fetchAll("SELECT * FROM category WHERE version = 'Premium'");
    }
    function saveRecent($recent)
    {
        $this->db->insert("recent", $recent);
        return $this->db->lastInsertId();
    }
    function removeCategory($deletedCategory)
    {
        $this->db->insert("deleted_categories", $deletedCategory);
        return $this->db->lastInsertId();
    }
    function removeEmoji($deletedCategory)
    {
        $this->db->insert("deleted_emojis", $deletedCategory);
        return $this->db->lastInsertId();
    }
    function removeFavorite($deletedCategory)
    {
        $this->db->insert("deleted_favorites", $deletedCategory);
        return $this->db->lastInsertId();
    }
    function removeRecent($deletedCategory)
    {
        $this->db->insert("deleted_recents", $deletedCategory);
        return $this->db->lastInsertId();
    }
    function removeTheme($deletedCategory)
    {
        $this->db->insert("deleted_themes", $deletedCategory);
        return $this->db->lastInsertId();
    }
    function updateRecent($recent,$emoji_id,$uuid)
    {
        return $this->db->update('recent', $recent, ['emoji_id'=>$emoji_id,'uuid' => $uuid]);
    }
    function updateFavorite($recent,$emoji_id,$uuid)
    {
        return $this->db->update('favorites', $recent, ['emoji_id'=>$emoji_id,'uuid' => $uuid]);
    }
    function updateTheme($theme,$uuid)
    {
        return $this->db->update('themes', $theme, ['uuid' => $uuid]);
    }
    function saveTheme($theme)
    {
        $this->db->insert("themes", $theme);
        return $this->db->lastInsertId();
    }
    function saveFavorite($favorite)
    {
        $this->db->insert("favorites", $favorite);
        return $this->db->lastInsertId();
    }

    function save($emoji)
    {
        $this->db->insert("emoji", $emoji);
        return $this->db->lastInsertId();
    }

    function saveCategory($emojiCategory)
    {
        $this->db->insert("category", $emojiCategory);
        return $this->db->lastInsertId();
    }

    function updateCategory($id, $category)
    {
        return $this->db->update('category', $category, ['id' => $id]);
    }

    function update($id, $emoji)
    {
        return $this->db->update('emoji', $emoji, ['id' => $id]);
    }

    function delete($id)
    {
        return $this->db->delete("emoji", array("id" => $id));
    }

    function deleteCategory($id)
    {
        return $this->db->delete("category", array("id" => $id));
    }

}