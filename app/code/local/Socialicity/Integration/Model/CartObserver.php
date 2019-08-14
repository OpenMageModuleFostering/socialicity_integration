<?php

require('app/code/local/Socialicity/Integration/Core/SocialicityRepository.php');

class Socialicity_Integration_Model_CartObserver
{
	public function checkoutCartProductAddAfter($observer)
	{
		Mage::log('Socialicity/CartObserver/ product added to cart');

		$referralId = SocialicityRepository::getReferralId();

		if ($referralId != null) {	
			$discountCode = SocialicityRepository::getDiscountCode();

			Mage::getSingleton('checkout/cart')->getQuote()->setCouponCode($discountCode)->save();	
			Mage::log('Socialicity/CartObserver/ coupon code applied: ' . $discountCode);			  
		}
	}
}

?>