<?php



class SpecifierPay extends CActiveRecordBehavior
{
    
    function __construct($key){

    	Stripe::setApiKey($key);

    }
    
    /**
     * Create new customer info
     * @var $company
     * @var $email
     * @var $cardArray = array ("number"=>, "exp_month"=>, "exp_year"=>, "cvc"=>, "name"=>, 
     * 							"address_line1"=>, "address_line2"=>, "address_city"=>, "address_zip"=>, "address_country"=>)
     * @return customer object / false
     */
    public function insertClient($company, $email, $cardArr){
    	
    	try {
    		return 

	    	Stripe_Customer::create(array(
			  "description" => $company,
			  "email" => $email,
			  "card" => $cardArr
			));
    	}
    	catch (Exception $e){
    		return false;
    	}
    	

    }

    /**
     * Get customer info
     * @var $id
     * @return customer object / false
     * 
     */
    public function getClient($id){
    	try {

    		return 

    		Stripe_Customer::retrieve($id);

    	}
    	catch (Exception $e){
    		return false;
    	}
    }

    

    /**
     * Subscribe service for customers on recurring basis
     * @var $clientObj
     * @var $planId  // subscription plan id
     * @return subscription obj / false
     */
    public function insertSubscription($clientObj, $planId){

    	try {

    		return 

    		$clientObj->subscriptions->create(array("plan" => $planId));

    	}
    	catch (Exception $e){

    		return false;
    	}

    }
}