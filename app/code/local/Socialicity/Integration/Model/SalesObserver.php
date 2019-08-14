<?php

require('app/code/local/Socialicity/Integration/Core/SocialicityRepository.php');

class Socialicity_Integration_Model_SalesObserver
{
	public function salesOrderPlaceAfter($observer)
	{				
		$referralId = SocialicityRepository::getReferralId();       
		Mage::log('Socialicity/SalesObserver/ checkout');

		if ($referralId != null) {

			$grandTotal = Mage::getSingleton('checkout/cart')->getQuote()->getGrandTotal();
			$message = '{ "ReferralId": "' . $referralId .'", "DiscountedAmount": ' . $grandTotal . ' }';

			Mage::log('Socialicity/SalesObserver/ sending message: ' . $message);
			Mage::log('Socialicity/SalesObserver/ using server: ' . SocialicityRepository::getConfirmUrl());

			$curl = curl_init();

			curl_setopt($curl, CURLOPT_SSLVERSION,3);

			curl_setopt($curl, CURLOPT_POST, 1);

			curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($curl, CURLOPT_USERPWD, SocialicityRepository::getUsername() . ':' . SocialicityRepository::getPassword());

			curl_setopt($curl, CURLOPT_POSTFIELDS, $message);
			curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json'));

			curl_setopt($curl, CURLOPT_URL, SocialicityRepository::getConfirmUrl());			
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

			$result = curl_exec($curl);

			if (curl_errno($curl)) {
				Mage::log('Socialicity/SalesObserver socialicity update failed');				
			} else {
				Mage::log('Socialicity/SalesObserver socialicity update success');
			}

			Mage::log('Socialicity/SalesObserver server response:' . $result);		
		}	

		SocialicityRepository::clearReferralId();
		SocialicityRepository::clearDiscountCode();
	}
}

?>