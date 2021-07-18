<?php

class InstaUserApi{

	public $apiUrl;
	public $authKey;
	public function __construct(){
		$this->apiUrl = "http://devapi.digitalaimz.com/find/";
		$this->authKey = 'uc3n2@r!';
	}
	function ajax_action(){
		
		add_action( "wp_ajax_my_ajax_action", array($this, "get_insta_profile" ));
		add_action( "wp_ajax_nopriv_my_ajax_action", array($this, "get_insta_profile" ));

		add_action( "wp_ajax_get_more_posts", array($this, "get_more_posts_func" ));
		add_action( "wp_ajax_nopriv_get_more_posts", array($this, "get_more_posts_func" ));

	}


	function registerScripts(){
		add_action( "wp_enqueue_scripts", array($this, "enqueue") );
	}

	function enqueue(){
		wp_enqueue_script( "jquery" );
		wp_enqueue_script( "ajax-script", plugin_dir_url( __FILE__ ). "assets/js/script.js" );
		wp_localize_script( 'ajax-script', 'my_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
		wp_enqueue_style( "custom", plugin_dir_url( __FILE__ ). "assets/css/custom.css" );
	}

	function get_more_posts_func(){
		$post_data = "";
		$response = $this->curlReq($post_data);
		// echo $response; exit;
		$more_posts = $this->more_posts($response);
		exit($more_posts);
	}

	function more_posts($response) {
		$res = array('success' => 'no', 'load_more' => 'NULL');
		// $userdata = json_decode($response);
		$moreUserData = isset($response->data) ? $response->data : '';
		$moreUserProfileData = isset($response->data->user) ? $response->data->user : '';
		if (!empty($moreUserData)) {
			$loadhtml = '';	
			foreach ($moreUserData->user_posts as $key => $post) {
				// $new_key = $key+$_POST['count'];
				$link = $post->link;
				$linkImage = $this->imgDisp_func($link);
				$loadhtml .= $this->make_html_for_insta_user($key, $linkImage, $post->id, $post->is_video);
			}
			if ($moreUserProfileData->next_page) {      // Loadmore button.
			$loadhtml .= '<div class="lmorefl">'
						.'<input type="button" id="loadmorebtn" class="loadmorebtn" data-userId="' . $moreUserProfileData->user_id . '" data-userToken="' . $moreUserProfileData->next_token . '" value="load more">' 
					.'</div>';
			}
			$res = array('success' => 'yes', 'load_more' => $loadhtml);
		}
		return json_encode($res);
	}

	function get_insta_profile() {		
		$username = $_POST['billing_insta_user'];
		$instaprofile = $this->get_insta_user($username);
		$createhtml = $this->create_profile_html($instaprofile);
	}

	function get_insta_user($username) {	
		$response = $this->curlReq($post_data);
		return $response;
	}

	function curlReq($post_data){
			$data = array();
			$data = '{"data":{"user":{"user_id":"5749255662","is_private":false,"full_name":"workout_knowledge \ud83c\uddfa\ud83c\uddf8","user_name":"workout_knowledge","profile_pic":"https:\/\/scontent-otp1-1.cdninstagram.com\/v\/t51.2885-19\/s150x150\/44705476_302749330341666_4057287675604893696_n.jpg?tp=1&_nc_ht=scontent-otp1-1.cdninstagram.com&_nc_ohc=3nYEmYCES-QAX9ocYDZ&edm=ABfd0MgBAAAA&ccb=7-4&oh=e3aadb032cc09896383e79bbcaf4f1fe&oe=60CECD1E&_nc_sid=7bff83","following":34,"followers":332182,"post_count":7661,"next_page":true,"next_token":"QVFERXI0bFF5SmliT0lLWVR5QXlfQWNwcDRPZUZnVVU2YS1KOHA0LTVVRlZuVTNaN1c3UmVvM2NFSEszbUNzT0JrbHFMdFlaMDg3R25BR3JKOU9uRWVGZA=="},"user_posts":[{"likes":211,"link":"https:\/\/scontent-otp1-1.cdninstagram.com\/v\/t51.2885-15\/e35\/c0.77.640.640a\/s150x150\/200973490_528835064918805_4978217253384098939_n.jpg?tp=1&_nc_ht=scontent-otp1-1.cdninstagram.com&_nc_cat=109&_nc_ohc=wBwQXYCEZ8cAX-STIUT&edm=ABfd0MgBAAAA&ccb=7-4&oh=8f00468432fb5a6ee5d346062de6df6b&oe=60C9485F&_nc_sid=7bff83","thumbnail":"https:\/\/scontent-otp1-1.cdninstagram.com\/v\/t51.2885-15\/e35\/c0.77.640.640a\/s320x320\/200973490_528835064918805_4978217253384098939_n.jpg?tp=1&_nc_ht=scontent-otp1-1.cdninstagram.com&_nc_cat=109&_nc_ohc=wBwQXYCEZ8cAX-STIUT&edm=ABfd0MgBAAAA&ccb=7-4&oh=7b04bad3bde57f507d674734035201a8&oe=60C90AE7&_nc_sid=7bff83","id":"CQFfWhlF-4G","is_video":false},{"likes":248,"link":"https:\/\/scontent-otp1-1.cdninstagram.com\/v\/t51.2885-15\/e35\/c3.0.1074.1074a\/s150x150\/200253645_4073225439454533_6234128696234930867_n.jpg?tp=1&_nc_ht=scontent-otp1-1.cdninstagram.com&_nc_cat=109&_nc_ohc=bmgw_YcB7c0AX_H9qJh&edm=ABfd0MgBAAAA&ccb=7-4&oh=a00093f2cb013062eb482f341d64b4a9&oe=60CD2C26&_nc_sid=7bff83","thumbnail":"https:\/\/scontent-otp1-1.cdninstagram.com\/v\/t51.2885-15\/e35\/c3.0.1074.1074a\/s320x320\/200253645_4073225439454533_6234128696234930867_n.jpg?tp=1&_nc_ht=scontent-otp1-1.cdninstagram.com&_nc_cat=109&_nc_ohc=bmgw_YcB7c0AX_H9qJh&edm=ABfd0MgBAAAA&ccb=7-4&oh=126a458be3d9efbf3b9600e197a0e03b&oe=60CD2AF3&_nc_sid=7bff83","id":"CQFMcT8FtZd","is_video":false},{"likes":120,"link":"https:\/\/scontent-otp1-1.cdninstagram.com\/v\/t51.2885-15\/e35\/s150x150\/200758948_808752933114897_5404885030341251049_n.jpg?tp=1&_nc_ht=scontent-otp1-1.cdninstagram.com&_nc_cat=109&_nc_ohc=Hfj91T1_Rh0AX_LHacd&edm=ABfd0MgBAAAA&ccb=7-4&oh=e3336f50382ebbf271ad851081f58aad&oe=60CD7412&_nc_sid=7bff83","thumbnail":"https:\/\/scontent-otp1-1.cdninstagram.com\/v\/t51.2885-15\/e35\/s320x320\/200758948_808752933114897_5404885030341251049_n.jpg?tp=1&_nc_ht=scontent-otp1-1.cdninstagram.com&_nc_cat=109&_nc_ohc=Hfj91T1_Rh0AX_LHacd&edm=ABfd0MgBAAAA&ccb=7-4&oh=3666ca0d5956f3116b5a26060014f2e3&oe=60CDA6AA&_nc_sid=7bff83","id":"CQELTB7FZon","is_video":false},{"likes":747,"link":"https:\/\/scontent-otp1-1.cdninstagram.com\/v\/t51.2885-15\/e35\/c0.135.1080.1080a\/s150x150\/199716355_291706649342154_2984773134342291061_n.jpg?tp=1&_nc_ht=scontent-otp1-1.cdninstagram.com&_nc_cat=1&_nc_ohc=1WVbJXvdptYAX9FgY-6&edm=ABfd0MgBAAAA&ccb=7-4&oh=a2595ab1a4b9ce8779774743358fdab8&oe=60CD41D4&_nc_sid=7bff83","thumbnail":"https:\/\/scontent-otp1-1.cdninstagram.com\/v\/t51.2885-15\/e35\/c0.135.1080.1080a\/s320x320\/199716355_291706649342154_2984773134342291061_n.jpg?tp=1&_nc_ht=scontent-otp1-1.cdninstagram.com&_nc_cat=1&_nc_ohc=1WVbJXvdptYAX9FgY-6&edm=ABfd0MgBAAAA&ccb=7-4&oh=eaaa9ce894a6c8cd1203c0f641e81c6e&oe=60CEBE2C&_nc_sid=7bff83","id":"CQDwyHuFUJ8","is_video":false},{"likes":365,"link":"https:\/\/scontent-otp1-1.cdninstagram.com\/v\/t51.2885-15\/e35\/c0.130.1080.1080a\/s150x150\/200288522_452987076152013_6838782642660808952_n.jpg?tp=1&_nc_ht=scontent-otp1-1.cdninstagram.com&_nc_cat=109&_nc_ohc=-hJXc_gf1mAAX_s0LVV&tn=HbeorEyeefhhNSu2&edm=ABfd0MgBAAAA&ccb=7-4&oh=c378504d39be38b887f8f25215cd0b41&oe=60CD84D3&_nc_sid=7bff83","thumbnail":"https:\/\/scontent-otp1-1.cdninstagram.com\/v\/t51.2885-15\/e35\/c0.130.1080.1080a\/s320x320\/200288522_452987076152013_6838782642660808952_n.jpg?tp=1&_nc_ht=scontent-otp1-1.cdninstagram.com&_nc_cat=109&_nc_ohc=-hJXc_gf1mAAX_s0LVV&edm=ABfd0MgBAAAA&ccb=7-4&oh=ced10ea70d94c2ffac64f705f2922285&oe=60CECEAB&_nc_sid=7bff83","id":"CQDD8g7FkUl","is_video":false},{"likes":1050,"link":"https:\/\/scontent-otp1-1.cdninstagram.com\/v\/t51.2885-15\/e35\/c0.80.640.640a\/s150x150\/200718348_654492475511711_948714759304067158_n.jpg?tp=1&_nc_ht=scontent-otp1-1.cdninstagram.com&_nc_cat=111&_nc_ohc=ehMYJKAAElcAX-IzaSP&edm=ABfd0MgBAAAA&ccb=7-4&oh=42ae40718ec70ff17d33039cbafdd352&oe=60C95C70&_nc_sid=7bff83","thumbnail":"https:\/\/scontent-otp1-1.cdninstagram.com\/v\/t51.2885-15\/e35\/c0.80.640.640a\/s320x320\/200718348_654492475511711_948714759304067158_n.jpg?tp=1&_nc_ht=scontent-otp1-1.cdninstagram.com&_nc_cat=111&_nc_ohc=ehMYJKAAElcAX-IzaSP&edm=ABfd0MgBAAAA&ccb=7-4&oh=d8ecfa56353c2799e8a85a42b15ceedd&oe=60C97520&_nc_sid=7bff83","id":"CQCriAgFsXu","is_video":false},{"likes":866,"link":"https:\/\/scontent-otp1-1.cdninstagram.com\/v\/t51.2885-15\/e35\/c0.135.1080.1080a\/s150x150\/199962007_106979278288080_6676583628159684422_n.jpg?tp=1&_nc_ht=scontent-otp1-1.cdninstagram.com&_nc_cat=100&_nc_ohc=w5usx9m6JBIAX8x3HxJ&edm=ABfd0MgBAAAA&ccb=7-4&oh=90ef420a1f3bfce90e453016ed0264f9&oe=60CE05C2&_nc_sid=7bff83","thumbnail":"https:\/\/scontent-otp1-1.cdninstagram.com\/v\/t51.2885-15\/e35\/c0.135.1080.1080a\/s320x320\/199962007_106979278288080_6676583628159684422_n.jpg?tp=1&_nc_ht=scontent-otp1-1.cdninstagram.com&_nc_cat=100&_nc_ohc=w5usx9m6JBIAX8x3HxJ&edm=ABfd0MgBAAAA&ccb=7-4&oh=10489b4eed1a9c326fb2e2a94d5fd6fe&oe=60CE97BA&_nc_sid=7bff83","id":"CQCB0XZFmts","is_video":false},{"likes":1359,"link":"https:\/\/scontent-otp1-1.cdninstagram.com\/v\/t51.2885-15\/e35\/c0.115.1077.1077a\/s150x150\/200106192_478393723453973_8755043130529868285_n.jpg?tp=1&_nc_ht=scontent-otp1-1.cdninstagram.com&_nc_cat=105&_nc_ohc=2EOjPAhBh4oAX8XCNmw&edm=ABfd0MgBAAAA&ccb=7-4&oh=606173572e841e17702181c8cbf3e8ff&oe=60CDF5AD&_nc_sid=7bff83","thumbnail":"https:\/\/scontent-otp1-1.cdninstagram.com\/v\/t51.2885-15\/e35\/c0.115.1077.1077a\/s320x320\/200106192_478393723453973_8755043130529868285_n.jpg?tp=1&_nc_ht=scontent-otp1-1.cdninstagram.com&_nc_cat=105&_nc_ohc=2EOjPAhBh4oAX8XCNmw&edm=ABfd0MgBAAAA&ccb=7-4&oh=5e9e2693c86d5f295e90d71026938cb1&oe=60CD7FD5&_nc_sid=7bff83","id":"CQBlgm0lYIF","is_video":false},{"likes":661,"link":"https:\/\/scontent-otp1-1.cdninstagram.com\/v\/t51.2885-15\/e35\/c0.80.640.640a\/s150x150\/199809746_113644904268120_2926325593605449801_n.jpg?tp=1&_nc_ht=scontent-otp1-1.cdninstagram.com&_nc_cat=100&_nc_ohc=D4Eg_84nYCMAX8tw-oR&tn=HbeorEyeefhhNSu2&edm=ABfd0MgBAAAA&ccb=7-4&oh=06151677392128bcd2bf3ab57b5772cf&oe=60C90E9D&_nc_sid=7bff83","thumbnail":"https:\/\/scontent-otp1-1.cdninstagram.com\/v\/t51.2885-15\/e35\/c0.80.640.640a\/s320x320\/199809746_113644904268120_2926325593605449801_n.jpg?tp=1&_nc_ht=scontent-otp1-1.cdninstagram.com&_nc_cat=100&_nc_ohc=D4Eg_84nYCMAX8tw-oR&tn=HbeorEyeefhhNSu2&edm=ABfd0MgBAAAA&ccb=7-4&oh=b0180d47080eb506c17efb88c3636fe9&oe=60C921E5&_nc_sid=7bff83","id":"CQBMRPVBLV5","is_video":true},{"likes":458,"link":"https:\/\/scontent-otp1-1.cdninstagram.com\/v\/t51.2885-15\/e35\/c0.80.640.640a\/s150x150\/200331044_1169299056908466_4385668732197849061_n.jpg?tp=1&_nc_ht=scontent-otp1-1.cdninstagram.com&_nc_cat=106&_nc_ohc=xPsJ1Quns7UAX-17trh&edm=ABfd0MgBAAAA&ccb=7-4&oh=0a5e7cc87ecb4ee790da0405b5816923&oe=60C91000&_nc_sid=7bff83","thumbnail":"https:\/\/scontent-otp1-1.cdninstagram.com\/v\/t51.2885-15\/e35\/c0.80.640.640a\/s320x320\/200331044_1169299056908466_4385668732197849061_n.jpg?tp=1&_nc_ht=scontent-otp1-1.cdninstagram.com&_nc_cat=106&_nc_ohc=xPsJ1Quns7UAX-17trh&edm=ABfd0MgBAAAA&ccb=7-4&oh=fa9170f6bfdd2ca486b31ba2450d6c66&oe=60C932E9&_nc_sid=7bff83","id":"CQAvtTylb2u","is_video":false},{"likes":1542,"link":"https:\/\/scontent-otp1-1.cdninstagram.com\/v\/t51.2885-15\/e35\/c0.210.540.540a\/s150x150\/199202506_481314572975673_893614047297082537_n.jpg?tp=1&_nc_ht=scontent-otp1-1.cdninstagram.com&_nc_cat=109&_nc_ohc=r_cTodKAt3MAX_e_uhw&edm=ABfd0MgBAAAA&ccb=7-4&oh=fa89f288daa7434f372f79776dfe357a&oe=60C94AF1&_nc_sid=7bff83","thumbnail":"https:\/\/scontent-otp1-1.cdninstagram.com\/v\/t51.2885-15\/e35\/c0.210.540.540a\/s320x320\/199202506_481314572975673_893614047297082537_n.jpg?tp=1&_nc_ht=scontent-otp1-1.cdninstagram.com&_nc_cat=109&_nc_ohc=r_cTodKAt3MAX_e_uhw&edm=ABfd0MgBAAAA&ccb=7-4&oh=41de6c253412d9ecd747b212500dfa96&oe=60C92141&_nc_sid=7bff83","id":"CQAnqC6BMC3","is_video":true},{"likes":711,"link":"https:\/\/scontent-otp1-1.cdninstagram.com\/v\/t51.2885-15\/e35\/c0.80.640.640a\/s150x150\/199712867_1379089455799350_5697458902564487943_n.jpg?tp=1&_nc_ht=scontent-otp1-1.cdninstagram.com&_nc_cat=106&_nc_ohc=Rh0M5Miot0MAX9-JivC&edm=ABfd0MgBAAAA&ccb=7-4&oh=74d34aa856996f3abe2026e31ad29d37&oe=60C96ED4&_nc_sid=7bff83","thumbnail":"https:\/\/scontent-otp1-1.cdninstagram.com\/v\/t51.2885-15\/e35\/c0.80.640.640a\/s320x320\/199712867_1379089455799350_5697458902564487943_n.jpg?tp=1&_nc_ht=scontent-otp1-1.cdninstagram.com&_nc_cat=106&_nc_ohc=Rh0M5Miot0MAX9-JivC&tn=HbeorEyeefhhNSu2&edm=ABfd0MgBAAAA&ccb=7-4&oh=b311eb3ac82c3604e15c3d22efe421a5&oe=60C921C5&_nc_sid=7bff83","id":"CQADCnEFray","is_video":false}]},"response_code":200,"response_desc":""}';
			$dataArray = json_decode($data);
			// $objData = arrayToObject($data);
			return $dataArray;
	}

	function getProdInfo(){
		$cart_data = WC()->session->get('cart');
		$dataArr = array();
		$product_id = $cart_data[array_keys($cart_data)[0]]['product_id'];
		$term = get_the_terms($product_id, 'product_cat');  
		$cat_name = strtolower($term[0]->name);
		$serv_id = $this->cat_service_id($cat_name);
		$cur_pkg_quantity   = get_post_meta($product_id, 'pkg_quantity', true);
		$dataArr = array($cat_name, $serv_id, $cur_pkg_quantity);
		return $dataArr;
	}

	function cat_service_id($cat_name){        
		$service= array(
			'comments'  => 1,
			'followers'  => 2,
			'likes'  => 3,
			'views'  => 4,
			'freefollowers'  => 6,
			'freelikes'  => 7,
			'autolikes'  => 8,
			'autoviews'  => 9,
			'ukfollowers'  => 10,
			'femalefollowers'  => 11,
			'igtvviews'  => 12,
			'storyviews'  => 13,
			'usfollowers'  => 14,
			'uklikes'  => 15,
			'tiktokfollowers'  => 16,
			'tiktoklikes'  => 17,
			'tiktokviews'  => 18,
			'spotifyfollowers'  => 19,
			'facebookpagelikes'  => 20,
			'facebookfollowers'  => 21
		);
		return isset($service[$cat_name])?$service[$cat_name]:'';
	}

	function create_profile_html($instaprofile) { 
		$response = json_encode(array('success' => 'no', 'profile' => 'NULL'));
		$instaData = $this->getProdInfo();
		// echo "<pre>";print_r($instaprofile);echo "</pre>";
		$data = isset($instaprofile) ? $instaprofile : '';
		$profData = $data->data->user;
		if (!empty($data)) {	
			$html = '<div class="insta_posts">';
			$html .= $this->prepProfileHtml($data);
			$postHtml = $this->prepPostsHtml($data);
			$html .= $postHtml;      
			$html .= '</div>'.
					 '<div class="selected_posts_cmts_cont da_err_warn" style="display:none"><p></p></div>';
			$response = json_encode(array('success' => 'yes', 'profile' => $html, "data"=>$profData, "instaData"=>$instaData));
		}
		exit($response);
	}

	function prepProfileHtml($data){
		$userProfile = $data->data->user;
		$profileSrc = $userProfile->profile_pic;
		$imgSrc = $this->imgDisp_func($profileSrc);
		// print_r($imgSrc);
		$profileSec = '<div class="folalpost">
						<div class="alpstor">
							<div class="profile">
								<div class="profile-image flpstcol">
									<img src="' . $imgSrc . '" alt="">
									<input type="hidden" class="profile_image" name="profile_image" value="' . $imgSrc . '">
								</div> 
								<div class="profile-stats flpstcol">
									<div class="profile-user-settings flpstcol">
										<h1 class="profile-user-name">' . $userProfile->full_name . '</h1>
										<input type="hidden" class="user_full_name"  name="user_full_name" id="user_full_name" value="' . $userProfile->full_name . '">
										<input type="hidden" class="user_profile_id"  name="user_profile_id" id="user_profile_id" value="' . $userProfile->user_id . '">
									</div>
									<ul>
										<li><span class="profile-stat-count">' . $this->get_transformed_quantity($userProfile->post_count) . '</span> posts</li>
										<li><span class="profile-stat-count">' . $this->get_transformed_quantity($userProfile->followers) . '</span> followers</li>
										<li><span class="profile-stat-count">' . $this->get_transformed_quantity($userProfile->following) . '</span> following</li>
									</ul>
								</div>
							</div>
						</div>
					   </div>';
		return $profileSec;
	}

	function prepPostsHtml($data){
		$userPostsData = $data->data->user_posts;
		$userProfile = $data->data->user;
		$html = '<div class="optfolwlikes">
					<div class="gallery">';
		foreach ($userPostsData as $key => $post) {
			$link = $post->link;
			$linkImage = $this->imgDisp_func($link);
			$html .= $this->make_html_for_insta_user($key, $linkImage, $post->id, $post->is_video);
		}
		if ($userProfile->next_page ) {      // Loadmore button.
			$html .= '<div class="lmorefl">'
						.'<input type="button" id="loadmorebtn" class="loadmorebtn" data-userId="' . $userProfile->user_id . '" data-userToken="' . $userProfile->next_token . '" value="load more">'
					.'</div>';
		}
		$html .= '  </div>
				  </div>';
	
		return $html;
	}

	function make_html_for_insta_user($key, $thumbnail, $post_id, $video = '') {
		$insta = $this->getProdInfo();
        $html = '<span class="checkSpan"><img style="width: 80px;" src="' . $thumbnail . '" class="posts-image" qtty="'.$insta[2].'" alt="insta Images" data-id="' . $post_id . '" data-test="1"></span>';
		return $html;
	}

	function imgDisp_func($url){
		$slashedUrl = stripslashes($url);
		$imageData = base64_encode(file_get_contents($slashedUrl));
		$src = 'data:image/jpg;base64,'.$imageData;
		return $src;
	}

	function get_transformed_quantity($quantity) {

		$transformedQuantity = $quantity;
		 if ($quantity >= 1000000000) {
		   $transformedQuantity = number_format($quantity / 1000000000).'b'; // billion
		 }
		 else if ($quantity >= 1000000) {
		   $transformedQuantity = number_format($quantity / 1000000).'m'; // million
		 }
		 else if ($quantity >= 10000) {
		   $transformedQuantity = number_format($quantity / 1000).'k'; //k
		 }
		 return $transformedQuantity;
		 
	 }
	function activation_hook_func(){
		//
	}
	function deactivation_hook_func(){
		//
	}

}