<?php

namespace App\Services;

class AdvertismentsService extends BaseService
{

    public function getAll()
    {
        return $this->db->fetchAll("SELECT * FROM advertisment ORDER BY RAND()");
    }

    function save($ad)
    {
         
        $this->db->insert("advertisment", $ad);
       // return $this->db->lastInsertId();
    }

    function update($id, $ad)
    {
        return $this->db->update('advertisment', $ad, ['id' => $id]);
    }
    function delete($id)
    {
        return $this->db->delete("advertisment", array("id" => $id));
    }

}