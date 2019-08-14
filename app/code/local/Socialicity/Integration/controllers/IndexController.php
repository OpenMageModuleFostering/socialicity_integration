<?php

require('app/code/local/Socialicity/Integration/Core/SocialicityRepository.php');

class Socialicity_Integration_IndexController extends Mage_Core_Controller_Front_Action
{
	/* For more information see: http://www.drewgillson.com/blog/how-to-apply-magento-coupon-codes-automatically/ */
	public function indexAction() {

		Mage::log('Socialicity/Index/ landing page accessed');

		$request = $this->getRequest();
		$referralId = $request->getParam('referralId');
		$url = $request->getParam('url');		
		$discountCode = $request->getParam('discountCode');	

		if ($request->getParam('debug') == 'true') {
			echo 'ReferralId: ' . SocialicityRepository::getReferralId() . '<br />';		
			echo 'Discount: ' . SocialicityRepository::getDiscountCode() . '<br />';

			die();
		}

		if ($referralId != null && $url != null && $discountCode != null) {

			Mage::log('Socialicity/Index/  referralId: ' . $referralId);
			Mage::log('Socialicity/Index/  url: ' . $url);
			Mage::log('Socialicity/Index/  discountCode: ' . $discountCode);

			SocialicityRepository::setReferralId($referralId);
			SocialicityRepository::setDiscountCode($discountCode);
			
			header('HTTP/1.1 307 Temporary Redirect');
			$gclid = $request->getParam('gclid');

			header('Location: ' . $url . '?gclid=' . $gclid);
			die();
		} else {
			$this->_redirect('/');
		}			
	}
}

?>
