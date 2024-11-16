<?php
include_once  'config.php';

if(isset($_GET['total']))
{
	
	$total= $_GET['total'];
	echo $total;
// 1- insert new order
// 2- insert order datails
// 3- define the order for how many shops and based on that insert into shop_order
// 4- finally insert into shop_payment based on items belong to which shop get the total price for all
// items in order for this shop and then in into shop_payment.
// -->

	$name=isset($_GET['name']) ? $_GET['name'] : ''; //Customer Name
	$email=isset($_GET['email']) ? $_GET['email'] : ''; //Customer Email
	$mobile=isset($_GET['mobile']) ? $_GET['mobile'] : ''; //Customer Mobile
	// $gender=isset($_POST['gender']) ? $_POST['gender'] : ''; //Customer Gender [M/F]
	// $country=isset($_POST['country']) ? $_POST['country'] : ''; //Customer Country
	// $city=isset($_POST['city']) ? $_POST['city'] : ''; //Customer City
	$address=isset($_GET['address']) ? $_GET['address'] : ''; //Customer address
	// $note=isset($_POST['note']) ? $_POST['note'] : ''; //Customer Note
	// $send_address=isset($_POST['send_address']) ? $_POST['send_address'] : ''; //Send Customer Address [YES/NO]
	
	/* Here you can calculate amount (from order, from you system ..etc) and set value for an optional & extra fields (username, user id, order id ... etc) */
	$amount=$total; //Amount
	$field1=""; //(Required Hash)
	$field2=""; //(Required Hash)
	$field3=""; //(Required Hash)
	$field4=""; //(Required Hash)
	$field5=""; //(Required Hash)
	$field5=""; //(Required Hash)
	$extra_field=""; //Extra field
	$required_fields=""; //Required fields [email,name,mobile,gender,address]
	$redirect_to_gateway=""; //Redirect to Gateway
	
	
	$data['api_type']=$gatee['api_type']; //Change in config
	$data['action']=$gatee['action']; //Change in config
	$data['amount']=$amount;
	$data['unique_id']=$gatee['unique_id']; //Change in config
	$data['payment_gateways_id']=""; // Payment Gateways ID
	$data['description']="Order # 1";
	$data['callback_url']=$gatee['callback_url']; //Change in config
	$data['show_callback']=$gatee['show_callback']; //Change in config
	$data['field1']=$field1;
	$data['field2']=$field2;
	$data['field3']=$field3;
	$data['field4']=$field4;
	$data['field5']=$field5;
	$data['extra_field']=$extra_field;
	$data['required_fields']=$required_fields;
	$data['redirect_to_gateway']=$redirect_to_gateway;
	$data['name']=$name;
	$data['email']=$email;
	$data['mobile']=$mobile;
	// $data['gender']=$gender;
	// $data['country']=$country;
	// $data['city']=$city;
	$data['address']=$address;
	// $data['note']=$note;
	// $data['send_address']=$send_address;
	$data['locale']=$gatee['locale']; //Change in config
	
	// Calculate Hash
	$calculate_hash=calculateHash($gatee['hash'], $data);
	
	$data['calculated_hash']=$calculate_hash['calculated_hash'];
	$gatee_url=$gatee['test'] ? "http://test.gate-e.com" : "https://www.gate-e.com";
	$url = dataUrl("$gatee_url/api/process.php", $data);
	
	// Process payment data normally - Redirect to Gate-e
	if($gatee['action'] == "normal")
		header('Location:' .$url['data_url']);
	// Process payment data in background
	elseif($gatee['action'] == "background")
	{
		$response = openURL($url['data_url']);
		
		// Decode data
		$payment=json_decode($response, true);
		
		if(isset($payment['status']) && $payment['status'] == "success")
		{
			// The payment was generated successfully, and your can write your code here
			print("Your Payment ID: ". $payment['payment_id']);
			print("\n<br>\n");
			print("Your Payment URL: <a href='". $payment['payment_url'] ."'>". $payment['payment_url'] ."</a>");
		}
		elseif(isset($payment['status']) && $payment['status'] == "failure")
		{
			// The payment was NOT generated successfully, and your can write your code here
			print("Error Code: ". $payment['code']);
			print("\n<br>\n");
			print("Error Message: ". $payment['error']);
		}
		else
			print("Please validate your API setting, and your integration code.");
	}
}

?>