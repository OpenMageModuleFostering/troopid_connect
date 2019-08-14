<?php

class TroopID_Connect_Helper_Data extends Mage_Core_Helper_Abstract {

    const CACHE_TAG = "troopid_connect";
    const CACHE_KEY = "troopid_affiliations";

    public function getKey($key, $storeId = null) {
        return Mage::getStoreConfig("troopid_connect/settings/" . $key, $storeId);
    }

    public function isEnabled() {
        return $this->getKey("enabled") == "1";
    }

    public function isSandbox() {
        return $this->getKey("sandbox_mode") == "1";
    }

    public function isOperational() {
        return $this->isEnabled() && $this->getKey("client_id") && $this->getKey("client_secret");
    }

    public function getAffiliations() {
        $cache  = Mage::getSingleton('core/cache');
        $oauth  = Mage::helper("troopid_connect/oauth");
        $values = $cache->load(self::CACHE_KEY);

        if (is_array($values))
            return $values;

        $values = $oauth->getAffiliations();
        $cache->save($values, self::CACHE_KEY, array(self::CACHE_TAG), 60*60);

        return $values;
    }

}