<?php
/**
 * Dwolla Here // PHP
 *
 * MIT LICENSE
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 * 
 * @author    Brett Neese <brett@brettneese.com>
 * @copyright Copyright (c) 2013 Brett Neese (http://www.brettneese.com)
 * @license   http://opensource.org/licenses/MIT MIT
 * @link      http://www.brettneese.com
 */


//Instatiate Slim
require 'Slim/Slim.php';
$_ENV['SLIM_MODE'] = 'production';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->add(new \Slim\Middleware\SessionCookie(array(
			'expires' => '2 days',
			'path' => '/',
			'domain' => null,
			'secure' => false,
			'httponly' => false,
			'name' => 'session',
			'secret' => '', //edit me
			'cipher' => MCRYPT_RIJNDAEL_256,
			'cipher_mode' => MCRYPT_MODE_CBC
		)));

// Include the Dwolla REST Client
require 'lib/dwolla.php';

// Include any required keys
require 'lib/keys.php';

//Instatiate Dwolla 
$redirectUri = 'http://yoururl.com/auth'; // Point back to this file/URL EDIT ME
$permissions = array("Send", "Transactions", "Balance", "Contacts", "AccountInfoFull", "Funding" );
$Dwolla = new DwollaRestClient($apiKey, $apiSecret, $redirectUri, $permissions);

$app->get('/', function () use($Dwolla, $app){
	$app->render('geo.php');
	if(isset($_GET['lat'])){
		print_r($_GET);
		$_SESSION['lat'] = $_GET['lat'];
		$_SESSION['lon'] = $_GET['lon'];
		$app->redirect('auth');
	}
});

$app->get('/geo', function () use($Dwolla, $app){
	$app->render('geo.php');
	if(isset($_GET['lat'])){
		print_r($_GET);
		$_SESSION['lat'] = $_GET['lat'];
		$_SESSION['lon'] = $_GET['lon'];

		if(!isset($_SESSION['token'])){
			$app->redirect('auth');
		} else {
			$app->redirect('list');
		}
	}
});
$app->get('/settings', function () use($Dwolla, $app){		
    if(!isset($_SESSION['token'])){
	$app->redirect('auth');
    }else{
	$app->render('settings_dialog.php');
    }
});

$app->get('/deposit', function () use($Dwolla, $app){	
	if(!isset($_SESSION['token'])){
		redirect('/auth');
	}else{
		$token = $_SESSION['token'];
		$Dwolla->setToken($token);
		if(isset($_POST['Id'])){
			print_r($_POST);
		}else{
		$fundingSources = $Dwolla->fundingSources();
		$balance = $Dwolla->balance();
		$balance = "$balance";
		$app->render('deposit.php', array('balance' => $balance, 'fundingSources' => $fundingSources));}
	}
});



$app->post('/deposit_action', function () use($Dwolla, $app){	
	if(!isset($_SESSION['token'])){
		redirect('/auth');
	}

	else{
		$token = $_SESSION['token'];
		$echo = $_POST;
		if($_POST['cents']){
			$amount = $_POST['dollars'] . "." . $_POST['cents'];
		} else {
			$amount = $_POST['dollars'];
		}
		$data = array("pin" => $_POST['pin'], "amount" => $amount, 'oauth_token' => $token );                                                                    
		$data_string = json_encode($data);                                                                                   
		$url = "https://www.dwolla.com/oauth/rest/fundingsources/" . $_POST['select-choice-0'] . '/deposit';                                                                     
		$ch = curl_init($url);                                                                      
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
				'Content-Type: application/json',                                                                                
				'Content-Length: ' . strlen($data_string))                                                                       
		);                                                                                                                   
		$rawData = curl_exec($ch);
		$response = json_decode($rawData, true);
		if (!$response['Success']) {
				$echo =  $response['Message'];
				$app->render('fail_pay.php', array('echo'=>$echo));
			}else{
				$response_success = $response['Response'];
				$clear_date = $response_success['ClearingDate'];
				$amount = $response_success['Amount'];
				$source_name = $response_success['SourceName'];
				$echo = ucfirst($response_success['Status']);
				$app->render('deposit_done.php', array('echo'=>$echo, 'amount' => $amount, 'clear_date' => $clear_date, 'source_name' => $source_name));
			}
		}	
});


$app->get('/withdraw', function () use($Dwolla, $app){	
	if(!isset($_SESSION['token'])){
		redirect('/auth');
	}else{
		$token = $_SESSION['token'];
		$Dwolla->setToken($token);
		$fundingSources = $Dwolla->fundingSources();
		$balance = $Dwolla->balance();
		$balance = "$balance";
		$app->render('wd_view.php', array('balance' => $balance, 'fundingSources' => $fundingSources));}
});

$app->post('/withdraw_action', function () use($Dwolla, $app){	
	if(!isset($_SESSION['token'])){
		redirect('/auth');
	}else{
		$token = $_SESSION['token'];

		if($_POST['cents']){
			$amount = $_POST['dollars'] . "." . $_POST['cents'];
		} else {
			$amount = $_POST['dollars'];
		}

		$data = array("pin" => $_POST['pin'], "amount" => $amount, 'oauth_token' => $token );                                                                    
		$data_string = json_encode($data);                                                                                   
		$url = "https://www.dwolla.com/oauth/rest/fundingsources/" . $_POST['select-choice-0'] . '/withdraw';                                                                     
		$ch = curl_init($url);                                                                      
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    			'Content-Type: application/json',                                                                                
    			'Content-Length: ' . strlen($data_string))                                                                       
			);                                                                                                                   
		$rawData = curl_exec($ch);
    	$response = json_decode($rawData, true);
		
		if (!$response['Success']) {
			$echo =  $response['Message'];
			$app->render('fail_pay.php', array('echo'=>$echo));
			}else{
				$response_success = $response['Response'];
				$clear_date = $response_success['ClearingDate'];
				$amount = $response_success['Amount'];
				$DestinationName = $response_success['DestinationName'];
				$echo = ucfirst($response_success['Status']);
				$app->render('wd_done.php', array('echo'=>$echo, 'amount' => $amount, 'clear_date' => $clear_date, 'DestinationName' => $DestinationName));
			}
	}			
});


$app->get('/geolocation', function () use($Dwolla, $app){
		$app->redirect('auth');
});

$app->get('/geo_fail', function () use($Dwolla, $app){
		$app->render('broken_geo.php');
});

$app->get('/logout', function () use($Dwolla, $app){
		$_SESSION = array();
		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,
				$params["path"], $params["domain"],
				$params["secure"], $params["httponly"]
			);
		}
		$app->render('logout.php');
});


$app->get('/auth', function () use($Dwolla, $app){
    if(isset($_SESSION['token'])){
        $app->redirect('list');
    }
	if(!isset($_SESSION['token']) && !isset($_GET['code']) && !isset($_GET['error'])) {
		$authUrl = $Dwolla->getAuthUrl();header("Location: {$authUrl}");
	}
	if(isset($_GET['error'])) {
		echo "There was an error. Dwolla said: {$_GET['error_description']}";
	}
	else if(isset($_GET['code'])) {
		$code = $_GET['code'];

		$token = $Dwolla->requestToken($code);
		if(!$token) { $Dwolla->getError(); } // Check for errors
		else {
			$_SESSION['token'] = $token;
			$app->redirect('list');
		} 
	}
});

$app->get('/not_logged_in', function () use($Dwolla, $app){
	$app->render('not_logged_in.php');
});

$app->get('/custom', function () use($Dwolla, $app){
	if(!isset($_SESSION['token'])){
    $app->redirect('list');}
	$app->render('custom.php');
});

$app->get('/id/:id', function ($id) use($Dwolla, $app){
  if(!isset($_SESSION['token'])){
    $app->redirect('../not_logged_in');
    }else{
	$info = $Dwolla->getUser($id);
	if(!$info) { $app->redirect('../list');}
	$name =  $info['Name'];
	$token = $_SESSION['token'];
	$Dwolla->setToken($token);
	$_SESSION['destination'] = $id;
	$balance = $Dwolla->balance();
	$balance = "$balance";
	$app->render('basic.php', array('name' => $name, 'id' => $id, 'balance' => $balance));}
});



$app->post('/pay', function () use($Dwolla, $app){
  if(!isset($_SESSION['token'])){
        $app->redirect('list');
    }else{
	$token = $_SESSION['token'];
	$Dwolla->setToken($token);
	$pin = $_POST['pin'];
	$destination = $_SESSION['destination'];
	$info = $Dwolla->getUser($id);
	$name =  $info['Name'];
	if($_POST['cents']){
		$amount = $_POST['dollars'] . "." . $_POST['cents'];
	} else {
		$amount = $_POST['dollars'];
	}
	$transactionId = $Dwolla->send($pin, $destination, $amount);
	if(!$transactionId) { $echo = "{$Dwolla->getError()} \n"; 
		$app->render('fail_pay.php', array('echo' => $echo));
	 } 
	else { 
		$details = $Dwolla->transaction($transactionId);
		print_r($details);
		$echo = "Money sent! \n"; 
		$app->render('pay.php', array('echo' => $echo, 'DestinationName' => $details['DestinationName'], 'timestamp' =>  $details['Date'], 'amount' => $details['Amount'], 'id'=>$details['DestinationId']));
		} 
	}
});

$app->get('/contacts', function () use($Dwolla, $app){
	if(!isset($_SESSION['token'])){
		$app->redirect('auth');
	}
    $token = $_SESSION['token'];
	$Dwolla->setToken($token);
	$balance = $Dwolla->balance();
	$balance = "$balance";
	$contact_array = $Dwolla->contacts();
	$_SESSION['button_to_show'] = "merchants";
	$app->render('contacts_view.php', array('contact_array' => $contact_array, 'balance' => $balance));
	
});

$app->get('/list', function () use($Dwolla, $app){
	$_SESSION['button_to_show'] = "contacts";

	if(!isset($_SESSION['lat'])){
		$app->redirect('geo');
	}

	if(!isset($_SESSION['token'])){
		$app->redirect('auth');
	}

	$nearby = $Dwolla->nearbyContacts($_SESSION['lat'], $_SESSION['lon'], '10', '200');
	
	foreach ($nearby as $location) {	
		if(isset($location['Id'])){
			$merchant_array[] = $location;
		}
	}

 	if(!is_array($merchant_array)) {
    	$app->render('no_near.php');
	}
	else{
    	$token = $_SESSION['token'];
		$Dwolla->setToken($token);
		$balance = $Dwolla->balance();
		$balance = "$balance";
		$app->render('list.php', array('merchant_array' => $merchant_array, 'balance' => $balance));
	}
});

$app->run();

?>
