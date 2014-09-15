<?php



class SpecifierPay extends CActiveRecordBehavior
{
    
    function __construct($key){

    	Stripe::setApiKey($key);

    }
    
    /**
     * Create new customer info
     * @var string $company
     * @var string $email
     * @var array $cardArray = array ("number"=>, "exp_month"=>, "exp_year"=>, "cvc"=>, "name"=>, 
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
     * Update Client info 
     * @var string $description
     * @var string $email 
     * @var array $cardArray = array ("number"=>, "exp_month"=>, "exp_year"=>, "cvc"=>, "name"=>, 
     * 							"address_line1"=>, "address_line2"=>, "address_city"=>, "address_zip"=>, "address_country"=>)
     * 
     * @return customer object / false
     * 
     */

    public function updateClient($clientObj, $description = null, $email = null, $cardArr = array()){

    	try {

    		if (isset($description)){
    			$clientObj->description = $description;
    		}

    		if (isset($email)){
    			$clientObj->email = $email;
    		}
    		
    		if (isset($cardArr) && is_array($cardArr)){
    			$clientObj->card = $cardArr;
    		}

    		return 

    		$clientObj->save();

    	}
    	catch (Exception $e){

    		return false;
    	}
    }

    /**
     * Get customer info
     * @var string $id
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
     * Insert a charge
     * @var int $amount (aud dollar)
     * @var string $clientId
     * @var string $description
     * 
     * @return customer charge object / false
     */
    public function insertCharge($amount, $clientId, $description){

    	try {

    		return 

    		Stripe_Charge::create(array(
			  "amount" => $amount * 100,
			  "currency" => "aud",
			  "customer" => $clientId,
			  "description" => $description
			));

    	}
    	catch (Exception $e){
    		return false;
    	}
    }

    /**
     * Get a charge info
     * @var string $chargeId
     * 
     * @return charge object / false
     * 
     */

    public function getCharge($chargeId){
    	try {

    		return 

    		Stripe_Charge::retrieve($chargeId);

    	}
    	catch (Exception $e){
    		return false;
    	}
    }

    /**
     * List charge based on client and limit
     * @var object $clientObj
     * @var int $limit
     * 
     * @return object array of charge
     * 
     * 
     */

   	public function listCharge($clientObj, $limit = 3){
   		try {

   			return 

   			Stripe_Charge::all(array("customer" => $clientObj, "limit" => $limit));
   		}
   		catch (Exception $e){
   			return false;
   		}

   	}



    /**
     * Subscribe service for customers on recurring basis
     * @var class $clientObj
     * @var string $planId  // subscription plan id
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

    /**
     * Get a subscription info
     * @var object $clientObj
     * @var string $subId
     * 
     * @return subscription object / false
     * 
     */

    public function getSubscription($clientObj, $subId){
    	try {

    		return 

    		$clientObj->subscriptions->retrieve($subId);

    	}
    	catch (Exception $e){
    		return false;
    	}
    }

    /**
     * Cancel the subscription until the end of current period
     * @var object $clientObj
     * @var string $subId
     * 
     * @return subscription object / false
     */

    public function cancelSubscription($clientObj, $subId){
    	try {

    		return 

    		$clientObj->subscriptions->retrieve($subId)->cancel(array('at_period_end'=>true));

    	}
    	catch (Exception $e){
    		return false;
    	}
    }

    
}