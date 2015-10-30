<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->model('user_m', 'user');

		$accessToken = $this->session->userdata('facebook_access_token');

		/*$fb = new Facebook\Facebook([
		  'app_id' => '1537802373177371',
		  'app_secret' => '6fa5147d3d86aede88b266ba23065911',
		  'default_graph_version' => 'v2.2',
		]);*/

		$fb = getFacebookInstance();

		$fb->setDefaultAccessToken($accessToken);

		try {
		  $response = $fb->get('/me?fields=id,name,email,first_name,last_name,link,gender,picture');
		  $userNode = $response->getGraphObject();

		  $this->session->set_userdata('uid', $userNode['id']);

		  $now = date('Y-m-d H:i:s');

		  $newUser = $this->user->create([
		  	'uid' => $userNode['id'],
		  	'name' => $userNode['name'],
		  	'email' => $userNode['email'],
		  	'gender' => $userNode['gender'],
		  	'link' => $userNode['link'],
		  	'picture' => 'https://graph.facebook.com/v2.5/'. $userNode['id'] .'/picture',
		  	'source' => 'Facebook',
		  	'active' => 1,
		  	'created_at' => $now,
		  	'updated_at' => $now
		  ]);

		  $user = $this->user->getUserByUid($userNode['uid']);
		  if(!$user->password)
		  {
		  	redirect('auth/facebook/password', 'refresh');
		  }
		  // redirect to dashboard

		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		  // When Graph returns an error
		  echo 'Graph returned an error: ' . $e->getMessage();
		  exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		  // When validation fails or other local issues
		  echo 'Facebook SDK returned an error: ' . $e->getMessage();
		  exit;
		}

	}
}
