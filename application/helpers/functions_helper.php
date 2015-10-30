<?php

function getFacebookInstance()
{
	$fb = new Facebook\Facebook([
	  'app_id' => '1537802373177371',
	  'app_secret' => '6fa5147d3d86aede88b266ba23065911',
	  'default_graph_version' => 'v2.2',
	]);

	return $fb;
}