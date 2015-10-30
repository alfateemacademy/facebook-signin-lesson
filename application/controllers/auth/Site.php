<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller {

	public function index()
	{
		$fb = new Facebook\Facebook([
		  'app_id' => '1537802373177371',
		  'app_secret' => '6fa5147d3d86aede88b266ba23065911',
		  'default_graph_version' => 'v2.2',
		]);

		$helper = $fb->getRedirectLoginHelper();

		$permissions = ['email'];
		$loginUrl = $helper->getLoginUrl('https://learnfacebooksignin.dev/auth/facebook/callback', $permissions);

		$data = [
			'loginUrl' => $loginUrl
		];

		$this->load->view('auth/login', $data);
	}
}
