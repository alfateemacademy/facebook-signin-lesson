<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Facebook extends CI_Controller {

	public function index()
	{
		$fb = getFacebookInstance();

		$helper = $fb->getRedirectLoginHelper();

		/*$permissions = ['email'];
		$loginUrl = $helper->getLoginUrl('https://learnfacebooksignin.dev/index.php/auth/facebook/callback', $permissions);

		redirect($loginUrl, 'location');*/

		//echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
	}

	public function callback()
	{
		$fb = getFacebookInstance();

		$helper = $fb->getRedirectLoginHelper();

		try {
		  $accessToken = $helper->getAccessToken();
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		  // When Graph returns an error
		  //echo 'Graph returned an error: ' . $e->getMessage();
			redirect('auth/facebook');
		  //exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		  // When validation fails or other local issues
		  echo 'Facebook SDK returned an error: ' . $e->getMessage();
		  exit;
		}

		if (isset($accessToken)) {
		  // Logged in!
			$this->session->set_userdata('facebook_access_token', (string) $accessToken);
		 // $_SESSION['facebook_access_token'] = (string) $accessToken;
		  //echo $accessToken;

		  // either he is new user or not

		  /*$fb->setDefaultAccessToken($accessToken);

		  try {
			  $response = $fb->get('/me?fields=id,name,email,first_name,last_name,link,gender');
			  $userNode = $response->getGraphObject();
			  print_r($userNode);
			} catch(Facebook\Exceptions\FacebookResponseException $e) {
			  // When Graph returns an error
			  echo 'Graph returned an error: ' . $e->getMessage();
			  exit;
			} catch(Facebook\Exceptions\FacebookSDKException $e) {
			  // When validation fails or other local issues
			  echo 'Facebook SDK returned an error: ' . $e->getMessage();
			  exit;
			}*/


		  // Now you can redirect to another page and use the
		  // access token from $_SESSION['facebook_access_token']

			redirect('/', 'refresh');
		}

		//print_r($this->input->get());
	}

	public function password()
	{
		echo "password pagep";
	}
}
