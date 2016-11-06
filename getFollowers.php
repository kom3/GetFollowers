<?php

$get = new getFollowers();
$get->id = "15448877";
$get->atok = "15448877.fsa58dd.c22651d64afc49809f0f508898a24b86";
$get->session = "";
$get->mid = "1549999";

/*

Example : 

echo $get->signup("6020d5fe89b94cb0bd9dd389d618fc8f");
foreach($get->getContents()['data']['followings'] as $dfid){
	$fid = $dfid['fid'];
	$action = $get->startTask($fid);
	echo $action['data']['credits'] . "<br />";
}
*/

class getFollowers {


	/*
		Developer : Galih Akbar Moerbayaksa
		Team : Kome-Ine Creative
		License : Open Source (GPL v3)
		Github Source : https://github.com/komeine/get-followers
		Github User : https://github.com/komeine/
	*/

	public $mid;
	public $session;
	public $atok;
	public $id;

	public function __construct(){

	}
	public function getContents(){
		$content = '{"app_id":302,"associate_id":"'.$this->id.'","mid":"'.$this->mid.'","fetch_count":2,"sesn_id":"'.$this->session.'"}';
		$base = 'https://socialstar.api-alliance.com/follows/getfollowers/fetch?content='.$content.'&signature='.HASH::hmac($content).'&sig_kv=3';
		return json_decode(@file_get_contents($base), true);
	}
	public function orderCheck(){
	    $content = '{"sesn_id":"'.$this->session.'","app_id":302,"associate_id":"'.$this->id.'","mid":"'.$this->mid.'"}';
	    $base = 'https://socialstar.api-alliance.com/follows/getfollowers/task/status?content='.$content.'&signature='.HASH::hmac($content).'&sig_kv=3';
	    return json_decode(@file_get_contents($base), true);
	}
	public function addOrder($total, $targetid, $targetUsername){
		$content = '{"credits":'.($total*2).',"quantity":'.$total.',"tobefollow":{"fid":"'.$targetid.'","portrait":"https:\/\/scontent.cdninstagram.com\/t51.2885-19\/11906329_960233084022564_1448528159_a.jpg","username":"'.$targetUsername.'","private":0},"app_id":302,"associate_id":"'.$this->id.'","mid":"'.$this->mid.'","sesn_id":"'.$this->session.'"}';
		$base = "https://socialstar.api-alliance.com/follows/getfollowers/task/submit";

		$data = $this->http($base, $this->buildQuery($content));
		return $data;
	}
	public function startTask($fid){
		$content = '{"associate_id":"'.$this->id.'","app_id":302,"following_result":{"fid":"'.$fid.'","status":"success"},"mid":"'.$this->mid.'","sesn_id":"'.$this->session.'"}';
		$base = "https://socialstar.api-alliance.com/follows/getfollowers/follow";
		$data = $this->http($base, $this->buildQuery($content));
		return $data;
	}
	public function signup($token){
		$content = '{"assets":{"basic":[]},"account_info":{"refrl":"google"},"tp_info":{"auth_code":"'.$token.'","acnt_typ":"instagram","client_verified":0,"auth_client_id":"c6384efb582f486980a4bc34debee3fa"},"app_id":302,"device_info":{"dvc_id":"'.UUID::get(true).'","enbl_ftur":"EnabledFeatures001Test","app_vrsn":"1.0.3","dvc_tkn":"","dvc_typ":"android","app_grp":"nuunnnnnnnnnnnnnnu","tst_usr":-1,"restrct_usr":false,"locl":"ID","dvc_os_vrsn":"4.4.2","dvc_tzone":25200}}';

		$base = "https://socialstar.api-alliance.com/follows/getfollowers/account/signup";

		$data = $this->http($base, $this->buildQuery($content));
		$sessionid = $data['data']['main_account']['sesn_id'];
	    $accesstoken = $data['data']['auth_info']['access_token'];
	    $id = $data['data']['auth_info']['user']['id'];
	    $mid = $data['data']['main_account']['mid'];
	    
	    return $sessionid . ":" . $accesstoken . ":" . $id . ":" . $mid;
	}

	private function buildQuery($content){
		$postdata = http_build_query(
	        array(
	            'content' => $content,
	            'signature' => HASH::hmac($content),
	            'sig_kv' => 3,
	            'cten' => 'p'
	        )
	    );
	    return $postdata;
	}
	private function http($base, $content){
		$opts = array('http' =>
	        array(
	            'method'  => 'POST',
	            'header'  => 'Content-type: application/x-www-form-urlencoded',
	            'content' => $content
	        )
	    );
	    $context  = stream_context_create($opts);
	    $result = @file_get_contents($base, false, $context);
	    $result = json_decode($result, true);
	    return $result;
	}
}

class HASH {
	
	public $key = 'GU}ST90CA*>AsZyX;+81BtVR:!k $Q`6';

	static function hmac($data){
		$h = new HASH();
		return hash_hmac('sha256', $data, $h->key);
	}

}

class UUID {
	static function get($type){
		$uuid = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
          mt_rand(0, 0xffff), mt_rand(0, 0xffff),
          mt_rand(0, 0xffff),
          mt_rand(0, 0x0fff) | 0x4000,
          mt_rand(0, 0x3fff) | 0x8000,
          mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
        return $type ? $uuid : str_replace('-', '', $uuid);
	}
}
