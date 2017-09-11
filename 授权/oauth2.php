<?php
/*
本文件位置
$redirect_url= "http://apps.homed.me/weixin/oauth.php";

URL
https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxd3d4a5f6acf157c4&redirect_uri=http://apps.homed.me/weixin/oauth.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect

https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxd3d4a5f6acf157c4&redirect_uri=http%3a%2f%2fapps.homed.me%2fweixin%2foauth2.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect
*/

if(isset($_GET["code"])){
	$code = $_GET["code"];
    echo $code;
	$userinfo = getUserInfo($code);
    echo $userinfo;
}else{
	echo "No code";
}

function getUserInfo($code)
{
	$appid = "wxd3d4a5f6acf157c4";
	$appsecret = "dee256a9978094b70a71a3e448b72cef";

    //oauth2的方式获得openid
	$access_token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$appsecret&code=$code&grant_type=authorization_code";
	$access_token_json = https_request($access_token_url);
	$access_token_array = json_decode($access_token_json, true);
	$access_token = $access_token_array["access_token"];
	$openid = $access_token_array['openid'];

	// 验证token是否可用
	$token_is_used_url = "https://api.weixin.qq.com/sns/auth?access_token=$access_token&openid=$openid";
	$token_is_used_json = https_request($token_is_used_url);   

    // 全局access token获得用户基本信息
    $userinfo_url = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
	$userinfo_json = https_request($userinfo_url);
	$userinfo_array = json_decode($userinfo_json, true);
	return $userinfo_array;
}

function https_request($url)
{
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$data = curl_exec($curl);
	if (curl_errno($curl)) {return 'ERROR '.curl_error($curl);}
	curl_close($curl);
	return $data;
}
?> 

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta id="viewport" name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,initial-scale=1.0,user-scalable=no">
    <title>CA卡关联</title>
    <link rel="stylesheet" type="text/css" href="http://apps.homed.me/pubFile/plugin/jquery-mobile/jquery.mobile-1.4.5.css">
    <script src="http://apps.homed.me/pubFile/commjs/dnsConfig.js"></script>
    <script src="http://apps.homed.me/pubFile/plugin/jquery-mobile/demos/js/jquery.min.js"></script>
    <script src="http://apps.homed.me/pubFile/plugin/jquery-mobile/jquery.mobile-1.4.5.js"></script>
    <script src="scripts/jquery.md5.js"></script>
    <script src="scripts/jquery.cookie.js"></script>
</head>

<body>
    <script type="text/javascript">
    // 隐藏右上角三个点按钮
    document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
        WeixinJSBridge.call('hideOptionMenu');
    });
    // /隐藏右下面工具栏
    document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
        WeixinJSBridge.call('hideToolbar');
    });

    var OpenID = '<?php echo $userinfo["openid"];?>',
        nickName = '<?php echo $userinfo["nickname"];?>',
        sex = '<?php echo $userinfo["sex"];?>',
        imgURL = '<?php echo $userinfo["headimgurl"];?>',
        address = '<?php echo $userinfo["province"];?>' + '<?php echo $userinfo["city"];?>',
        userName = 'wx_' + OpenID;

    console.log(OpenID + " " + nickName + " " + sex + " " + address);
 
    </script>
</body>

</html>
