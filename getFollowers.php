<?php

// Tutorial or Example doko ita no ?? :)

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

	public function __construct($id = false){
		if($id && is_numeric($id)){
			$this->id = $id;
		}
		return $this;
	}
	public function addAccount($new_id){
		$time = date("U") * 1000;
		$content = '{"associate_id":"'.$new_id.'","app_id":302,"client_time":"'.$time.'","mid":"'.$this->mid.'","type":"instagram","sesn_id":"'.$this->session.'","signature":"'.HASH::hmac("302|4140957785|1478764336424|3a25e63c", "ad6edf5e4112445f95d9f94fcbd74e85").'"}';
		$base = 'https://ssafollow.api-alliance.com/follows/ssafollows/associate/client_add';
		$data = $this->http($base, $this->buildQuery($content));
		return $data;
	}
	public function addLikes($media_id, $target_id, $total){
		$content = '{"media_url":{"standard":"http:\/\/scontent-sit4-1.cdninstagram.com\/t51.2885-15\/e35\/14733179_644578785722220_7549668795372011520_n.jpg","low":"http:\/\/scontent-sit4-1.cdninstagram.com\/t51.2885-15\/s320x320\/e35\/14733179_644578785722220_7549668795372011520_n.jpg","thumbnail":"http:\/\/scontent-sit4-1.cdninstagram.com\/t51.2885-15\/s150x150\/e35\/14733179_644578785722220_7549668795372011520_n.jpg"},"media_id":"'.$media_id.'","credits":'.($total).',"quantity":'.$total.',"app_id":302,"mid":"'.$this->mid.'","sesn_id":"'.$this->session.'","usermeta":{"uid":"'.$target_id.'","fullname":"galihs123","username":"galihs123"}}';
		$base = 'https://ssafollow.api-alliance.com/follows/getfollowers/like/submit';
		$data = $this->http($base, $this->buildQuery($content));
		return $data;
	}
	public function getContents(){
		$content = '{"associate_id":"'.$this->id.'","app_id":302,"mid":"'.$this->mid.'","fetch_count":1,"sesn_id":"'.$this->session.'"}';
		$base = 'https://ssafollow.api-alliance.com/follows/getfollowers/fetch?content='.$content.'&signature='.HASH::hmac($content).'&sig_kv=5';
		return json_decode(@file_get_contents($base), true);
	}
	public function orderCheck(){
	    	$content = '{"sesn_id":"'.$this->session.'","app_id":302,"associate_id":"'.$this->id.'","mid":"'.$this->mid.'"}';
	   	$base = 'https://ssafollow.api-alliance.com/follows/getfollowers/task/status?content='.$content.'&signature='.HASH::hmac($content).'&sig_kv=5';
	    	return json_decode(@file_get_contents($base), true);
	}
	public function addOrder($total, $targetid, $targetUsername){
		$content = '{"credits":'.($total*2).',"quantity":'.$total.',"tobefollow":{"fid":"'.$targetid.'","portrait":"https:\/\/scontent.cdninstagram.com\/t51.2885-19\/11906329_960233084022564_1448528159_a.jpg","username":"'.$targetUsername.'","private":0},"app_id":302,"associate_id":"'.$this->id.'","mid":"'.$this->mid.'","sesn_id":"'.$this->session.'"}';
		$base = "https://ssafollow.api-alliance.com/follows/getfollowers/task/submit";

		$data = $this->http($base, $this->buildQuery($content));
		return $data;
	}
	public function startTask($fid){
		$content = '{"associate_id":"'.$this->id.'","app_id":302,"following_result":{"fid":"'.$fid.'","status":"success"},"mid":"'.$this->mid.'","sesn_id":"'.$this->session.'"}';
		$base = "https://ssafollow.api-alliance.com/follows/getfollowers/follow";
		$data = $this->http($base, $this->buildQuery($content));
		return $data;
	}
	public function updateRelay(){
		$content = '{"assets":{"basic":["credits"]},"sesn_id":"'.$this->session.'","app_id":302,"mid":"'.$this->mid.'"}';
		$base = "https://ssafollow.api-alliance.com/follows/ssafollows/asset/v1/query";
		$data = $this->http($base, $this->buildQuery($content));
		return $data;
	}
	public function signup($id_ig = false){
		if(!empty($this->id)){
			$id_ig = $this->id;
		}
		$content = '{"assets":{"path":"\/asset\/v1\/query","basic":[]},"get_followers":{"unfollowed":0},"account_info":{"refrl":"Amazon"},"tp_info":{"acnt_typ":"instagram","sid":"'.$id_ig.'","client_verified":1},"app_id":302,"device_info":{"dvc_id":"'.UUID::get(true).'","enbl_ftur":"EnabledFeatures001Test","app_vrsn":"1.0.8","dvc_tkn":"APA91bFxd-6IdRSysefy5caXeMEVk4EHUX2Jpgildi7bTyULZmDPmmrfRIrCfD2tWcuQ3Qc7HdeQS_G-w2NvfWxUmJ5Jw7GYUCf48sg5vRqs_oMFQy-5c6EWPC2Z7JRU3mjHzJX5tJu-","dvc_typ":"android","usr_seg":"","app_grp":"nuunnnnnnnnnnnnnnu","dvc_lctn_set":0,"restrct_usr":false,"locl":"in_ID","dvc_os_vrsn":"4.4.2","dvc_tzone":25200},"associates":{}}';
		$base = "https://ssafollow.api-alliance.com/follows/ssafollows/account/v1/signup";

		$data = $this->http($base, $this->buildQuery($content));
		$sessionid = $data['data']['main_account']['sesn_id'];
	    	$accesstoken = $data['data']['associates'][0]['access_token'];
	    	$id = $data['data']['associates'][0]['id'];
	    	$mid = $data['data']['main_account']['mid'];
	    	if(!empty($this->id)){
			$this->mid = $mid;
			$this->atok = $accesstoken;
			$this->session = $sessionid;
			return $this;
		} else {
			return $sessionid . ":" . $accesstoken . ":" . $id . ":" . $mid;
		}
	}

	private function buildQuery($content){
		$postdata = http_build_query(
	        array(
	            'content' => $content,
	            'signature' => HASH::hmac($content),
	            'sig_kv' => 5,
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
	
	public $key = 'Z^`)t(OdE{|w2{`U.O=e.hVX&1[kX@iH';

	static function hmac($data, $key = false){
		$h = new HASH();
		if(!empty($key)) $h->key = $key;
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
