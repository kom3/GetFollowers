<?php
$kke = "d&L:>DEtw]7oS.a}F_gRyhoL8j]jC=!F"; // Private key, important!

$session = "kIYOTwHI8lmr8qtzzgi6hzpju1a31qmxkwym89ua"; // Session
$atok = "3973759919.c6384ef.038912a7b15347419da7c8c68352fc66"; // Access token
$id = "3973759919"; // ID
$mid = "12761362"; // MID


function getContents($id, $session){
    global $mid;
    $content = '{"app_id":302,"associate_id":"'.$id.'","mid":"'.$mid.'","fetch_count":2,"sesn_id":"'.$session.'"}';
    $ps = 'https://socialstar.api-alliance.com/follows/getfollowers/fetch?content='.$content.'&signature='.getsig($content).'&sig_kv=1';
    return json_decode(@file_get_contents($ps), true);
}
function signup($token){
    global $mid;
    $content = '{"assets":{"basic":[]},"account_info":{"refrl":"google"},"tp_info":{"auth_code":"'.$token.'","acnt_typ":"instagram","client_verified":0,"auth_client_id":"c6384efb582f486980a4bc34debee3fa"},"app_id":302,"device_info":{"dvc_id":"'.generateUUID(true).'","enbl_ftur":"EnabledFeatures001Test","app_vrsn":"1.0.3","dvc_tkn":"","dvc_typ":"android","app_grp":"nuunnnnnnnnnnnnnnu","tst_usr":-1,"restrct_usr":false,"locl":"ID","dvc_os_vrsn":"4.4.2","dvc_tzone":25200}}';
    $postdata = http_build_query(
        array(
            'content' => $content,
            'signature' => getsig($content),
            'sig_kv' => 1
        )
    );
    
    $opts = array('http' =>
        array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => $postdata
        )
    );
    
    $context  = stream_context_create($opts);
    $result = @file_get_contents('https://socialstar.api-alliance.com/follows/getfollowers/account/signup', false, $context);
    
    $result = json_decode($result, true);
    
    $sessionid = $result['data']['main_account']['sesn_id'];
    $accesstoken = $result['data']['auth_info']['access_token'];
    $id = $result['data']['auth_info']['user']['id'];
    
    return $sessionid . ":" . $accesstoken . ":" . $id;
    
}
function update($seskey){
    global $mid;
    $content = '{"sesn_id":"'.$seskey.'","app_id":302,"mid":"'.$mid.'"}';
    echo $content;
    $postdata = http_build_query(
        array(
            'content' => $content,
            'signature' => getsig($content),
            'sig_kv' => 1
        )
    );
    
    $opts = array('http' =>
        array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => $postdata
        )
    );
    
    $context  = stream_context_create($opts);
    $result = @file_get_contents('https://socialstar.api-alliance.com/follows/getfollowers/associate/query', false, $context);
    
    $x = json_decode($result, true);
    var_dump($x);
}
function orderchcek($id, $session){
    global $mid;
    $content = '{"sesn_id":"'.$session.'","app_id":302,"associate_id":"'.$id.'","mid":"'.$mid.'"}';
    $ps = 'https://socialstar.api-alliance.com/follows/getfollowers/task/status?content='.$content.'&signature='.getsig($content).'&sig_kv=1';
    return json_decode(@file_get_contents($ps), true);
}
function addOrder($total, $targetid, $targetusername, $session){
    global $id, $mid;
    $content = '{"credits":'.($total*2).',"quantity":'.$total.',"tobefollow":{"fid":"'.$targetid.'","portrait":"https:\/\/scontent.cdninstagram.com\/t51.2885-19\/11906329_960233084022564_1448528159_a.jpg","username":"'.$targetusername.'","private":0},"app_id":302,"associate_id":"'.$id.'","mid":"'.$mid.'","sesn_id":"'.$session.'"}';
    $postdata = http_build_query(
        array(
            'content' => $content,
            'signature' => getsig($content),
            'sig_kv' => 1
        )
    );
    
    $opts = array('http' =>
        array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => $postdata
        )
    );
    
    $context  = stream_context_create($opts);
    $result = @file_get_contents('https://socialstar.api-alliance.com/follows/getfollowers/task/submit', false, $context);
    return json_decode($result, true);
}
function follow($fid, $session, $token){
    global $mid, $id;
    $content = '{"app_id":302,"associate_id":"'.$id.'","following_result":{"fid":"'.$fid.'","status":"success"},"mid":"'.$mid.'","sesn_id":"'.$session.'","access_token":"'.$token.'"}';
    $postdata = http_build_query(
        array(
            'content' => $content,
            'signature' => getsig($content),
            'sig_kv' => 1
        )
    );
    
    $opts = array('http' =>
        array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => $postdata
        )
    );
    
    $context  = stream_context_create($opts);
    $result = @file_get_contents('https://socialstar.api-alliance.com/follows/getfollowers/follow', false, $context);
    return json_decode($result, true);
}
function getsig($g){
    global $kke;
    return hash_hmac('sha256', $g, $kke);
}
function generateUUID($type)
    {
        $uuid = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
          mt_rand(0, 0xffff), mt_rand(0, 0xffff),
          mt_rand(0, 0xffff),
          mt_rand(0, 0x0fff) | 0x4000,
          mt_rand(0, 0x3fff) | 0x8000,
          mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
        return $type ? $uuid : str_replace('-', '', $uuid);
    }
?>