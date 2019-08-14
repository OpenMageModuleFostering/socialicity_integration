<?php

class SocialicityRepository
{
	public static function setReferralId($referralId) {
		SocialicityRepository::set_value('socialicity_referral_id', $referralId);	
	}

	public static function getReferralId() {
		return SocialicityRepository::get_value('socialicity_referral_id');
	}

	public static function clearReferralId() {
		SocialicityRepository::set_value('socialicity_referral_id', null);	
	}

	public static function setDiscountCode($discountCode) {
		SocialicityRepository::set_value('socialicity_discount_code', $discountCode);
	}

	public static function getDiscountCode() {
		return SocialicityRepository::get_value('socialicity_discount_code');
	}

	public static function clearDiscountCode() {
		SocialicityRepository::set_value('socialicity_discount_code', null);
	}

	public static function getUsername() {
		return Mage::getStoreConfig('socialicity/socialicity_general/username', Mage::app()->getStore());
		//return "pawelburzynski@moneydebtandcredit.com";
	}

	public static function getPassword() {
		return Mage::getStoreConfig('socialicity/socialicity_general/password', Mage::app()->getStore());
		//return "Password11";
	}

	public static function getConfirmUrl() {
		return Mage::getStoreConfig('socialicity/socialicity_advanced/server_url', Mage::app()->getStore());
		//return "http://socialicitywebapi/api/Referral/Confirm";
	}

	private static function get_value($key) {
		return $_COOKIE[$key];
	}

	private static function set_value($key, $value) {
		if ($value) {
			setcookie($key, $value, 0, '/');			
		} else {			
			setcookie($key, '', time()-3600, '/');
		}
	}

}

?>