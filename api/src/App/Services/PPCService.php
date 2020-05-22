<?php
/**
 * Created by IntelliJ IDEA.
 * User: kibrom
 * Date: 6/22/17
 * Time: 5:32 PM
 */

namespace App\Services;

class PPCService extends BaseService{

    public function getAll(){

        return $this->db->fetchAll("SELECT * FROM ppc");
    }

    public function registerClick($click){

        return $this->db->insert("ppc",$click);

    }
    
    public function getClickByAdId($ad_id){

        return $this->db->fetchAll("SELECT * FROM ppc where ad_id=$ad_id");
    }
    
    public function updateAdClick($click,$ad_id){

        return $this->db->update("ppc",$click,['ad_id'=>$ad_id]);
    }

    public function getAllAdClickes(){

        return $this->db->fetchAll("SELECT ad.name,ad.description,ppc.click_count,ad.created_at FROM advertisment ad INNER JOIN ppc ON ad.id = ppc.ad_id");
    }
}