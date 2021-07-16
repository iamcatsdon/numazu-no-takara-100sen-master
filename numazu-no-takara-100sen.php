<?php
/*
  Plugin Name: ぬまづの宝100選
  Plugin URI: 
  Description: 当プログラムは、静岡県沼津市が主催している企画「ぬまづの宝100選」の写真を登録し、写真の取得、点数の取得、認定ランクの取得、認定証の取得を行う事ができるWordPress用のプラグインです。
  Version: 0.1.1
  Author: かっつ丼
  Author URI: https://numazudon.net/
  License: GPLv2 or later
 */

add_action('init', 'NumazuTakara100Sen::init');

class NumazuTakara100Sen
{
    const PLUGIN_ID         = 'numazu-no-takara-100sen';
    const PLUGIN_VERSION    = '0.1.1';
    const PLUGIN_DOMAIN     = self::PLUGIN_ID;
    const PLUGIN_DB_PREFIX  = self::PLUGIN_ID . '_';
    
    const MENU_SLUG_HOME  = self::PLUGIN_ID . '-home';
    const CREDENTIAL_ACTION_HOME 	= self::PLUGIN_ID . '-nonce-action';
    const CREDENTIAL_NAME_HOME   	= self::PLUGIN_ID . '-nonce-key';
    
    const MENU_SLUG_CONFIG  = self::PLUGIN_ID . '-config';
    const CREDENTIAL_ACTION_CONFIG 	= self::MENU_SLUG_CONFIG . '-nonce-action';
    const CREDENTIAL_NAME_CONFIG   	= self::MENU_SLUG_CONFIG . '-nonce-key';
    
    const MENU_SLUG_ABOUT  = self::PLUGIN_ID . '-about';
	
    const CERTIFIED_IMGS = array (
	    1 => array(
			'name' => 'Master',
			'postname' => 'certified_img_master'
		),
		2 => array(
			'name' => 'Meijin',
			'postname' => 'certified_img_meijin'
		),
		3 => array(
			'name' => 'Sensei',
			'postname' => 'certified_img_sensei'
		),
	);
	
    const PLACES = array (
		1 => array(
			'name' => 'ダルマ夕日',
			'point' => 10
		),
		2 => array(
			'name' => '沼津から見る富士山',
			'point' => 1
		),
		3 => array(
			'name' => '千本松原',
			'point' => 1
		),
		4 => array(
			'name' => '淡島',
			'point' => 1
		),
		5 => array(
			'name' => '狩野川',
			'point' => 1
		),
		6 => array(
			'name' => '井田の菜の花畑',
			'point' => 5
		),
		7 => array(
			'name' => '煌めきの丘',
			'point' => 1
		),
		8 => array(
			'name' => '大瀬崎',
			'point' => 1
		),
		9 => array(
			'name' => '大瀬崎のビャクシン樹林',
			'point' => 1
		),
		10 => array(
			'name' => '御浜岬',
			'point' => 1
		),
		11 => array(
			'name' => '出逢い岬',
			'point' => 1
		),
		12 => array(
			'name' => '牛臥山公園',
			'point' => 1
		),
		13 => array(
			'name' => '三浦地区のリアス式海岸',
			'point' => 1
		),
		14 => array(
			'name' => '大瀬崎の神池',
			'point' => 1
		),
		15 => array(
			'name' => '河内の大スギ',
			'point' => 3
		),
		16 => array(
			'name' => '大平の石神・石仏群',
			'point' => 1
		),
		17 => array(
			'name' => '鮎壺の滝',
			'point' => 1
		),
		18 => array(
			'name' => '岡宮浅間神社のクス',
			'point' => 1
		),
		19 => array(
			'name' => '八畳石',
			'point' => 1
		),
		20 => array(
			'name' => '金冠山',
			'point' => 3
		),
		21 => array(
			'name' => '発端丈山',
			'point' => 3
		),
		22 => array(
			'name' => '沼津アルプス',
			'point' => 10
		),
		23 => array(
			'name' => '門池',
			'point' => 1
		),
		24 => array(
			'name' => '門池公園の桜',
			'point' => 5
		),
		25 => array(
			'name' => '香貫山',
			'point' => 1
		),
		26 => array(
			'name' => '香貫山香陵台の桜',
			'point' => 5
		),
		27 => array(
			'name' => '愛鷹山',
			'point' => 1
		),
		28 => array(
			'name' => '愛鷹広域公園の桜',
			'point' => 5
		),
		29 => array(
			'name' => '浮島の湧水',
			'point' => 1
		),
		30 => array(
			'name' => 'アクアプラザ遊水地',
			'point' => 1
		),
		31 => array(
			'name' => '沼川の桜',
			'point' => 5
		),
		32 => array(
			'name' => 'せせらぎの径',
			'point' => 1
		),
		33 => array(
			'name' => 'はかま滝',
			'point' => 1
		),
		34 => array(
			'name' => '北山の棚田',
			'point' => 1
		),
		35 => array(
			'name' => '長浜城跡',
			'point' => 1
		),
		36 => array(
			'name' => '浜の観音さん（長谷寺）',
			'point' => 5
		),
		37 => array(
			'name' => '江原素六',
			'point' => 1
		),
		38 => array(
			'name' => '明治史料館',
			'point' => 1
		),
		39 => array(
			'name' => '沼津御用邸記念公園',
			'point' => 1
		),
		40 => array(
			'name' => '赤野観音堂',
			'point' => 1
		),
		41 => array(
			'name' => '松城家住宅',
			'point' => 3
		),
		42 => array(
			'name' => '高沢公園のＳＬ',
			'point' => 1
		),
		43 => array(
			'name' => '光長寺',
			'point' => 1
		),
		44 => array(
			'name' => '松蔭寺と白隠禅師',
			'point' => 1
		),
		45 => array(
			'name' => '興国寺城跡',
			'point' => 1
		),
		46 => array(
			'name' => '大中寺恩香殿と鐘楼門',
			'point' => 1
		),
		47 => array(
			'name' => '三枚橋城・沼津城',
			'point' => 1
		),
		48 => array(
			'name' => '沼津兵学校',
			'point' => 1
		),
		49 => array(
			'name' => '御成橋',
			'point' => 1
		),
		50 => array(
			'name' => '沼津方式（ごみの分別収集）',
			'point' => 1
		),
		51 => array(
			'name' => '蛇松緑道',
			'point' => 1
		),
		52 => array(
			'name' => '海軍技研址の碑',
			'point' => 1
		),
		53 => array(
			'name' => '興農学園農場',
			'point' => 1
		),
		54 => array(
			'name' => '狩野川放水路',
			'point' => 1
		),
		55 => array(
			'name' => '旧三津坂隧道',
			'point' => 1
		),
		56 => array(
			'name' => '安田屋旅館松棟・月棟',
			'point' => 1
		),
		57 => array(
			'name' => '禅長寺',
			'point' => 1
		),
		58 => array(
			'name' => '洋式帆船建造地跡',
			'point' => 1
		),
		59 => array(
			'name' => '若山牧水（若山牧水記念館）',
			'point' => 1
		),
		60 => array(
			'name' => '井上靖',
			'point' => 1
		),
		61 => array(
			'name' => '芹沢光治良（芹沢光治良記念館）',
			'point' => 1
		),
		62 => array(
			'name' => '我入道の渡し船',
			'point' => 5
		),
		63 => array(
			'name' => '沼津垣',
			'point' => 3
		),
		64 => array(
			'name' => '潮の音プロムナードと文学碑',
			'point' => 1
		),
		65 => array(
			'name' => '吟道の碑',
			'point' => 3
		),
		66 => array(
			'name' => '沼津内浦･静浦及び周辺地域の漁撈用具',
			'point' => 1
		),
		67 => array(
			'name' => '海中みそぎ',
			'point' => 5
		),
		68 => array(
			'name' => '大瀬まつり・内浦漁港祭',
			'point' => 5
		),
		69 => array(
			'name' => 'タカアシガニの甲羅のお面',
			'point' => 3
		),
		70 => array(
			'name' => 'おんべこんべ',
			'point' => 5
		),
		71 => array(
			'name' => '高尾山祭典',
			'point' => 5
		),
		72 => array(
			'name' => 'モン ミュゼ沼津',
			'point' => 1
		),
		73 => array(
			'name' => '沼津の歌',
			'point' => 1
		),
		74 => array(
			'name' => '江浦水祝儀と裸参り',
			'point' => 5
		),
		75 => array(
			'name' => '天王祭',
			'point' => 5
		),
		76 => array(
			'name' => 'ごぜ芸能まつり',
			'point' => 5
		),
		77 => array(
			'name' => '戸田の漁師踊・漁師唄',
			'point' => 1
		),
		78 => array(
			'name' => '沼津の寿司',
			'point' => 3
		),
		79 => array(
			'name' => 'ひもの',
			'point' => 3
		),
		80 => array(
			'name' => '深海魚料理',
			'point' => 3
		),
		81 => array(
			'name' => 'タカアシガニ',
			'point' => 3
		),
		82 => array(
			'name' => 'あしたか牛',
			'point' => 3
		),
		83 => array(
			'name' => '沼津茶（ぬまづ茶）',
			'point' => 3
		),
		84 => array(
			'name' => '泉水源地',
			'point' => 3
		),
		85 => array(
			'name' => '西浦みかん',
			'point' => 3
		),
		86 => array(
			'name' => '戸田の塩',
			'point' => 3
		),
		87 => array(
			'name' => 'へだトロはんぺん',
			'point' => 3
		),
		88 => array(
			'name' => '戸田たちばな',
			'point' => 3
		),
		89 => array(
			'name' => 'こいのぼりフェスティバル',
			'point' => 5
		),
		90 => array(
			'name' => '戸田港まつり',
			'point' => 5
		),
		91 => array(
			'name' => '江ノ浦湾花火大会',
			'point' => 10
		),
		92 => array(
			'name' => 'よさこい東海道',
			'point' => 5
		),
		93 => array(
			'name' => '沼津夏まつり・狩野川花火大会',
			'point' => 5
		),
		94 => array(
			'name' => '沼津港',
			'point' => 1
		),
		95 => array(
			'name' => '沼津港大型展望水門「びゅうお」',
			'point' => 1
		),
		96 => array(
			'name' => 'らららサンビーチ',
			'point' => 1
		),
		97 => array(
			'name' => 'ぬまづ七夕まつり',
			'point' => 5
		),
		98 => array(
			'name' => '沼津ホタルまつり',
			'point' => 5
		),
		99 => array(
			'name' => '奥駿河湾海浜祭',
			'point' => 5
		),
		100 => array(
			'name' => '駿河湾深海生物館',
			'point' => 1
		)
	);
	
    static function init()
    {
        return new self();
    }
    
    function __construct()
    {
        if (is_admin() && is_user_logged_in()) {
	        add_action('admin_menu', [$this, 'set_plugin_menu']);
            add_action('admin_menu', [$this, 'set_plugin_sub_menu']);
            add_action('admin_init', [$this, 'save_config']);
            add_action('admin_enqueue_scripts', [$this, 'numazu_no_takara_100sen_admin_enqueue_scripts']);
        }
        add_action('wp_enqueue_scripts', [$this, 'numazu_no_takara_100sen_enqueue_scripts']);
        load_plugin_textdomain( self::PLUGIN_DOMAIN, false, basename( dirname( __FILE__ ) ).'/languages/' );
    }
    
    function numazu_no_takara_100sen_admin_enqueue_scripts()
    {
		wp_register_style( self::PLUGIN_ID . '-admin', plugins_url( 'css/admin.css', __FILE__ ), array(), '', 'all');
		wp_enqueue_style( self::PLUGIN_ID . '-admin' );
		wp_register_style( self::PLUGIN_ID . '-jquery-ui-1-12-1', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css', array(), '', 'all');
		wp_enqueue_style( self::PLUGIN_ID . '-jquery-ui-1-12-1' );
		wp_register_script( self::PLUGIN_ID . '-jquery-1-12-4', 'https://code.jquery.com/jquery-1.12.4.js', array(), '', true);
		wp_enqueue_script( self::PLUGIN_ID . '-jquery-1-12-4' );
		wp_register_script( self::PLUGIN_ID . '-jquery-ui-1-12-1', 'https://code.jquery.com/ui/1.12.1/jquery-ui.js', array(), '', true);
		wp_enqueue_script( self::PLUGIN_ID . '-jquery-ui-1-12-1' );
		wp_register_script( self::PLUGIN_ID . '-media_upload', plugins_url( 'js/media_upload.js', __FILE__ ), array( self::PLUGIN_ID . '-jquery-1-12-4', self::PLUGIN_ID . '-jquery-ui-1-12-1'), '', true);
		wp_enqueue_script( self::PLUGIN_ID . '-media_upload' );
		
		if ( ! did_action( 'wp_enqueue_media' ) ) wp_enqueue_media();
		
		wp_set_script_translations(
			self::PLUGIN_ID . '-media_upload',
			self::PLUGIN_ID,
			dirname( __FILE__ ) . '/languages'
		);
	}
	
	function numazu_no_takara_100sen_enqueue_scripts()  
	{
		wp_register_style( self::PLUGIN_ID . '-style', plugins_url( 'css/style.css', __FILE__ ), '', 'all');
		wp_enqueue_style( self::PLUGIN_ID . '-style' );
	}
    
    function set_plugin_menu()
    {
        add_menu_page(
	        __('NUMAZU 100 TREASURES', self::PLUGIN_DOMAIN ),
	        __('NUMAZU 100 TREASURES', self::PLUGIN_DOMAIN ),
            'edit_published_posts',
            self::MENU_SLUG_HOME,
            [$this, 'add_numazu_no_takara_100sen_page'],
            'dashicons-format-gallery',
            50
        );
    }
    
    function set_plugin_sub_menu()
    {
        add_submenu_page(
			self::MENU_SLUG_HOME,
			__('Settings', self::PLUGIN_DOMAIN ),
			__('Settings', self::PLUGIN_DOMAIN ),
			'edit_published_posts',
			self::MENU_SLUG_CONFIG,
			[$this, 'add_numazu_no_takara_100sen_page_config'],
			10
		);
		
		add_submenu_page(
			self::MENU_SLUG_HOME,
			__('About this Plugin', self::PLUGIN_DOMAIN ),
			__('About this Plugin', self::PLUGIN_DOMAIN ),
			'edit_published_posts',
			self::MENU_SLUG_ABOUT,
			[$this, 'add_numazu_no_takara_100sen_page_about'],
			10
		);
    }
    
    function getPoint() {
		$total = 0;
		foreach ( self::PLACES as $key => $value ) :
			$bite16_name = bin2hex($value['name']);
			if ( ! empty( get_option(self::PLUGIN_DB_PREFIX . $bite16_name) ) ) :
				$total += $value['point'];
			endif;
		endforeach;
		return $total;
    }
    
    function getRank() {
	    $point = self::getPoint();
		if ( $point >= 201  ) :
			$rank = __('Master', self::PLUGIN_DOMAIN );
		elseif ( $point >= 151  ) :
			$rank = __('Meijin', self::PLUGIN_DOMAIN );
		elseif ( $point >= 100  ) :
			$rank = __('Sensei', self::PLUGIN_DOMAIN );
		else :
			$rank = '-';
		endif;
		return $rank;
    }
    
    function get_template_point_and_rank() {
	    $html = '';
	    $html .= '<div class="point_and_rank">';
		$html .= '<div class="point_wrapper"><div class="point">' . __('Point', self::PLUGIN_DOMAIN ) . '<span class="num"><strong>' . self::getPoint() . '</strong></span>' . __('points', self::PLUGIN_DOMAIN ) . '</div></div>';
		$html .= '<div class="rank_wrapper"><div class="rank">' . __('Rank', self::PLUGIN_DOMAIN ) . '<span class="num"><strong>' . self::getRank() . '</strong></span></div></div>';
		$html .= '</div>';
		return $html;
    }
    
    function add_numazu_no_takara_100sen_page()
	{
		?>
		<div class="wrap">
			<div class="title_flex">
		    	<h1><?php _e('NUMAZU 100 TREASURES', self::PLUGIN_DOMAIN ) ?></h1>
			    <?php echo self::get_template_point_and_rank() ?>
			</div>
		    <div class="metabox-holder">
			    <form action="" method="POST" id="numazu_no_takara_100sen_page_form">
				    <div class="postbox">
					    <div class="inside">
					    	<div class="main">
					            <?php wp_nonce_field(self::CREDENTIAL_ACTION_HOME, self::CREDENTIAL_NAME_HOME) ?>
								<?php
									echo '<div class="nmz_no_takara_items">';
									foreach ( self::PLACES as $key => $value ) :
										$bite16_name = bin2hex($value['name']);
										echo '<fieldset class="nmz_no_takara_item">';
										echo '<div class="nmz_no_takara_item_body">';
										$get_img_url = get_option(self::PLUGIN_DB_PREFIX . $bite16_name);
										$img_url = $get_img_url ? $get_img_url : '';
										$attachment_id = attachment_url_to_postid( $img_url );
										if ( $attachment_id !== 0 ):
											$attachment_id = attachment_url_to_postid( $img_url );
											$img_url = wp_get_attachment_image_src( $attachment_id , 'medium' )[0];
										endif;
										$style = empty ($img_url ) ? ' noimage' : '' ;
							    		echo '<div class="nmz_no_takara_item_body_img_wrapper"><div class="nmz_no_takara_item_body_img' . $style . '"><img class="'.$bite16_name.'_media_image custom_media_image" src="' . $img_url . '" /></div></div>';
							    		echo '<input type="hidden" name="'.$bite16_name.'" id="'.$bite16_name.'_media_url" value="' . esc_html( $img_url ) . '" class="components-text-control__input '.$bite16_name.'_media_url"  />';
										echo '<div>';
										echo '<div class="nmz_no_takara_item_num_and_title_and_point"><div class="nmz_no_takara_item_num">' .$key . '</div><div class="nmz_no_takara_item_title">' . __( $value['name'], self::PLUGIN_DOMAIN ) . '</div><div class="nmz_no_takara_item_point">' . $value['point'] . '</div></div>';
										echo '<div class="nmz_no_takara_item_buttons">';
										echo '<input type="button" id="'.$bite16_name.'" value="'.__('Choose Image', self::PLUGIN_DOMAIN).'" class="button kn_custom_media_upload">';
										$style = empty ($img_url ) ? 'style="display:none"' : '' ;
							    		echo '<input type="button" id="'.$bite16_name.'_delete" value="'.__('Delete', self::PLUGIN_DOMAIN).'" class="button button_delete kn_custom_media_delete '.$bite16_name.'_delete" '.$style.'>';
							    		echo '</div>';
							    		echo '<div id="'.$bite16_name.'_delete_message" class="'.$bite16_name.'_delete_message nmz_no_takara_item_delete_message" style="display:none">'.__('Press the refresh button to save the post to complete the image deletion.', self::PLUGIN_DOMAIN).'</div>';
							    		echo '</div>';
							    		echo '</div>';
							    		echo '</fieldset>';
									endforeach;
									echo '</div>';
								?>
							</div>
					    </div>
				    </div>
					<p><input type="submit" value="<?php _e('Save', self::PLUGIN_DOMAIN) ?>" class="button button-primary button-large"></p>
	        	</form>
		    </div>
		</div>
		<?php
	}
	
	function add_numazu_no_takara_100sen_page_config()
    {
	    ?>
		<div class="wrap">
			<div class="title_flex">
		    	<h1><?php _e('Settings', self::PLUGIN_DOMAIN ) ?></h1>
		    	<?php echo self::get_template_point_and_rank() ?>
			</div>
		    <div class="metabox-holder">
			    <form action="" method="POST" id="numazu_no_takara_100sen_page_config_form">
				    <div class="postbox">
					    <div class="inside">
					    	<div class="main">
					            <?php wp_nonce_field(self::CREDENTIAL_ACTION_CONFIG, self::CREDENTIAL_NAME_CONFIG) ?>
					            <h2><?php _e('Certificate registration', self::PLUGIN_DOMAIN ) ?></h2>
								<?php
									echo '<div class="nmz_no_takara_items nmz_no_takara_items_config">';
									foreach( self::CERTIFIED_IMGS as $key => $value ) :
										$name = $value['name'];
										$post_name = $value['postname'];
										$get_img_url = get_option(self::PLUGIN_DB_PREFIX . $post_name);
										$img_url = $get_img_url ? $get_img_url : '';
										$attachment_id = attachment_url_to_postid( $img_url );
										if ( $attachment_id !== 0 ):
											$attachment_id = attachment_url_to_postid( $img_url );
											$img_url = wp_get_attachment_image_src( $attachment_id , 'medium' )[0];
										endif;
										echo '<fieldset class="nmz_no_takara_item">';
										echo '<div class="nmz_no_takara_item_body">';
										$style = empty ($img_url ) ? ' noimage' : '' ;
										echo '<div class="nmz_no_takara_item_body_img_wrapper"><div class="nmz_no_takara_item_body_img' . $style . '"><img class="'.$post_name.'_media_image custom_media_image" src="'.$img_url.'" /></div></div>';
							    		echo '<input type="hidden" name="'.$post_name.'" id="'.$post_name.'_media_url" value="' . esc_html( $img_url ) . '" class="components-text-control__input '.$post_name.'_media_url"  />';
							    		echo '<div>';
							    		echo '<div class="nmz_no_takara_item_num_and_title_and_point"><div class="nmz_no_takara_item_title">' . __( $name, self::PLUGIN_DOMAIN ) . '</div></div>';
										echo '<div class="nmz_no_takara_item_buttons">';
										echo '<input type="button" id="'.$post_name.'" value="'.__('Choose Image', self::PLUGIN_DOMAIN).'" class="button kn_custom_media_upload">';
										$style = empty ($img_url ) ? 'style="display:none"' : '' ;
							    		echo '<input type="button" id="'.$post_name.'_delete" value="'.__('Delete', self::PLUGIN_DOMAIN).'" class="button button_delete kn_custom_media_delete '.$post_name.'_delete" '.$style.'></input>';
							    		echo '</div>';
							    		echo '<div id="'.$post_name.'_delete_message" class="'.$post_name.'_delete_message nmz_no_takara_item_delete_message" style="display:none">'.__('Press the refresh button to save the post to complete the image deletion.', self::PLUGIN_DOMAIN).'</div>';
							    		echo '</div>';
							    		echo '</div>';
							    		echo '</fieldset>';
						    		endforeach;
						    		echo '</div>';
								?>
					    	</div>
					    </div>
				    </div>
				    <p><input type="submit" value="<?php _e('Save', self::PLUGIN_DOMAIN) ?>" class="button button-primary button-large"></p>
	        	</form>
		    </div>
		</div>
		<?php
    }
    
    function add_numazu_no_takara_100sen_page_about()
    {
	    ?>
		<div class="wrap">
			<div class="title_flex">
		    	<h1><?php _e('About this Plugin', self::PLUGIN_DOMAIN ) ?></h1>
		    	<?php echo self::get_template_point_and_rank() ?>
			</div>
		    <div class="metabox-holder">
			    <div class="postbox">
				    <div class="inside">
				    	<div class="main">
					    	<p>
				            	<?php _e('Nice to meet you. The creator of this plugin is iamCatsdon.', self::PLUGIN_DOMAIN ) ?><br>
				            	<?php _e('Thank you for downloading, installing and using the plug-in.', self::PLUGIN_DOMAIN ) ?>
			            	</p>
			            	<p>
				            	<?php _e('If you notice any bugs, please report them from the following inquiry page.', self::PLUGIN_DOMAIN ) ?><br>
				            	<?php _e('If you are satisfied and want to support iamCatsdon, We also accept donations.', self::PLUGIN_DOMAIN ) ?>
			            	</p>
			            	<div>
				            	<a href="https://numazudon.net/weblog/contact" target="_blank" class="button"><?php _e('Contact', self::PLUGIN_DOMAIN ) ?></a>
				            	<a href="https://www.amazon.co.jp/hz/wishlist/genericItemsPage/3EY8VEQ1INXQP?type=wishlist&tag=associateskfa-22&_encoding=UTF8" target="_blank" class="button"><?php _e('Donation', self::PLUGIN_DOMAIN ) ?></a>
			            	</div>
				    	</div>
				    </div>
			    </div>
		    </div>
		</div>
		<?php
    }
    
    function save_config()
    {
        if (isset($_POST[self::CREDENTIAL_NAME_HOME]) && $_POST[self::CREDENTIAL_NAME_HOME]) {
            if (check_admin_referer(self::CREDENTIAL_ACTION_HOME, self::CREDENTIAL_NAME_HOME)) {
				
                foreach ( self::PLACES as $key => $value ) :
                	$bite16_name = bin2hex($value['name']);
					if ( ! empty($bite16_name) ) :
                		update_option(self::PLUGIN_DB_PREFIX . $bite16_name, $_POST[$bite16_name]);
                	else :
                		delete_option(self::PLUGIN_DB_PREFIX . $bite16_name);
                	endif;
                endforeach;
            }
        }
        
        if (isset($_POST[self::CREDENTIAL_NAME_CONFIG]) && $_POST[self::CREDENTIAL_NAME_CONFIG]) {
            if (check_admin_referer(self::CREDENTIAL_ACTION_CONFIG, self::CREDENTIAL_NAME_CONFIG)) {
	            
				foreach( self::CERTIFIED_IMGS as $key => $value ) :
					$post_name = $value['postname'];
					if ( ! empty($_POST[$post_name]) ) :
	            		update_option(self::PLUGIN_DB_PREFIX . $post_name, $_POST[$post_name]);
	            	else :
	            		delete_option(self::PLUGIN_DB_PREFIX . $post_name);
	            	endif;
            	endforeach;
	        }
        }
    }
    
    public static function create_shortcode_numazu_no_takara_point( $atts, $content = "" ) {
	    $point = self::getPoint();
	    return $point;
	}
	
    public static function create_shortcode_numazu_no_takara_rank( $atts, $content = "" ) {
	    $rank = self::getRank();
	    return $rank;
	}
	
	public static function create_shortcode_numazu_no_takara_photos( $atts, $content = "" ) {
		$atts = shortcode_atts( array(
			'column' => 1,
			'sp_column' => 1,
			'tab_column' => 1,
			'pc_column' => 1,
		), $atts, 'numazu_no_takara_photos' );
		
		$class = '';
		if ( (int) $atts['column'] !== 1 ) $class .= ' nmz_no_takara_items_' . $atts['column'];
		if ( (int) $atts['sp_column'] !== 1 ) $class .= ' sp_nmz_no_takara_items_' . $atts['sp_column'];
		if ( (int) $atts['tab_column'] !== 1 ) $class .= ' tab_nmz_no_takara_items_' . $atts['tab_column'];
		if ( (int) $atts['pc_column'] !== 1 ) $class .= ' pc_nmz_no_takara_items_' . $atts['pc_column'];
		
		$html = '';
		$html .= '<div class="nmz_no_takara_items' . $class . '">';
	    foreach ( self::PLACES as $key => $value ) :
			$bite16_name = bin2hex($value['name']);
			$get_img_url = get_option(self::PLUGIN_DB_PREFIX . $bite16_name);
			$img_url = $get_img_url ? $get_img_url : '';
			$attachment_id = attachment_url_to_postid( $img_url );
			if ( $attachment_id !== 0 ):
				$attachment_id = attachment_url_to_postid( $img_url );
				$img_url = wp_get_attachment_image_src( $attachment_id , 'large' )[0];
			endif;
			if ( ! empty ($img_url ) ) :
				$html .= '<div class="nmz_no_takara_item">';
				$html .= '<div class="nmz_no_takara_item_body">';
				$html .= '<div class="nmz_no_takara_item_body_img_wrapper"><div class="nmz_no_takara_item_body_img"><img class="' . $bite16_name . '_media_image custom_media_image" src="' . $img_url . '" /></div></div>';
				$html .= '</div>';
	    		$html .= '<div class="nmz_no_takara_item_num_and_title_and_point"><div class="nmz_no_takara_item_num">' . $key . '</div><div class="nmz_no_takara_item_title">' . __( $value['name'], self::PLUGIN_DOMAIN ) . '</div><div class="nmz_no_takara_item_point">' . $value['point'] . '</div></div>';
	    		$html .= '</div>';
	    	endif;
		endforeach;
		$html .= '</div>';
	    return $html;
	}
	
	public static function create_shortcode_numazu_no_takara_certified_imgs( $atts, $content = "" ) {
	    $atts = shortcode_atts( array(
		    'column' => 1,
			'sp_column' => 1,
			'tab_column' => 1,
			'pc_column' => 1,
			'rank' => 0,
		), $atts, 'numazu_no_takara_certified_imgs' );
		
		$class = '';
		if ( (int) $atts['column'] !== 1 ) $class .= ' nmz_no_takara_items_' . $atts['column'];
		if ( (int) $atts['sp_column'] !== 1 ) $class .= ' sp_nmz_no_takara_items_' . $atts['sp_column'];
		if ( (int) $atts['tab_column'] !== 1 ) $class .= ' tab_nmz_no_takara_items_' . $atts['tab_column'];
		if ( (int) $atts['pc_column'] !== 1 ) $class .= ' pc_nmz_no_takara_items_' . $atts['pc_column'];
		
		$certified_img_arr = array();
		if ( (int) $atts['rank'] === 1 ) :
			$certified_img_master = get_option(self::PLUGIN_DB_PREFIX . self::CERTIFIED_IMGS[1]['postname']);
			if ( ! empty ($certified_img_master ) ) :
				$certified_img_arr[1]['name'] = self::CERTIFIED_IMGS[1]['name'];
				$certified_img_arr[1]['img_url'] = $certified_img_master;
			endif;
		elseif ( (int) $atts['rank'] === 2 ) :
			$certified_img_meijin = get_option(self::PLUGIN_DB_PREFIX . self::CERTIFIED_IMGS[2]['postname']);
			if ( ! empty ($certified_img_meijin ) ) :
				$certified_img_arr[2]['name'] = self::CERTIFIED_IMGS[2]['name'];
				$certified_img_arr[2]['img_url'] = $certified_img_meijin;
			endif;
		elseif ( (int) $atts['rank'] === 3 ) :
			$certified_img_sensei = get_option(self::PLUGIN_DB_PREFIX . self::CERTIFIED_IMGS[3]['postname']);
			if ( ! empty ($certified_img_sensei ) ) :
				$certified_img_arr[3]['name'] = self::CERTIFIED_IMGS[3]['name'];
				$certified_img_arr[3]['img_url'] = $certified_img_sensei;
			endif;
		else :
			$certified_img_master = get_option(self::PLUGIN_DB_PREFIX . self::CERTIFIED_IMGS[1]['postname']);
			if ( ! empty ($certified_img_master ) ) :
				$certified_img_arr[1]['name'] = self::CERTIFIED_IMGS[1]['name'];
				$certified_img_arr[1]['img_url'] = $certified_img_master;
			endif;
			$certified_img_meijin = get_option(self::PLUGIN_DB_PREFIX . self::CERTIFIED_IMGS[2]['postname']);
			if ( ! empty ($certified_img_meijin ) ) :
				$certified_img_arr[2]['name'] = self::CERTIFIED_IMGS[2]['name'];
				$certified_img_arr[2]['img_url'] = $certified_img_meijin;
			endif;
			$certified_img_sensei = get_option(self::PLUGIN_DB_PREFIX . self::CERTIFIED_IMGS[3]['postname']);
			if ( ! empty ($certified_img_sensei ) ) :
				$certified_img_arr[3]['name'] = self::CERTIFIED_IMGS[3]['name'];
				$certified_img_arr[3]['img_url'] = $certified_img_sensei;
			endif;
		endif;
		$html = '';
		$html .= '<div class="nmz_no_takara_items ' . $class . '">';
		foreach( $certified_img_arr as $key => $value ) :
			$name = $value['name'];
			$img_url = $value['img_url'];
			$attachment_id = attachment_url_to_postid( $img_url );
			if ( $attachment_id !== 0 ):
				$attachment_id = attachment_url_to_postid( $img_url );
				$img_url = wp_get_attachment_image_src( $attachment_id , 'large' )[0];
			endif;
			$html .= '<div class="nmz_no_takara_item">';
			$html .= '<div class="nmz_no_takara_item_body">';
			$html .= '<div class="nmz_no_takara_item_body_img_wrapper"><div class="nmz_no_takara_item_body_img"><img class="" src="' . $img_url . '" /></div></div>';
			$html .= '</div>';
    		$html .= '<div class="nmz_no_takara_item_num_and_title_and_point"><div class="nmz_no_takara_item_title">' . __( $name, self::PLUGIN_DOMAIN ) . '</div></div>';
    		$html .= '</div>';
		endforeach;
		$html .= '</div>';
		return $html;
	}
}

add_shortcode('numazu_no_takara_point', array( 'NumazuTakara100Sen', 'create_shortcode_numazu_no_takara_point' ));
add_shortcode('numazu_no_takara_rank', array( 'NumazuTakara100Sen', 'create_shortcode_numazu_no_takara_rank' ));
add_shortcode('numazu_no_takara_photos', array( 'NumazuTakara100Sen', 'create_shortcode_numazu_no_takara_photos' ));
add_shortcode('numazu_no_takara_certified_imgs', array( 'NumazuTakara100Sen', 'create_shortcode_numazu_no_takara_certified_imgs' ));