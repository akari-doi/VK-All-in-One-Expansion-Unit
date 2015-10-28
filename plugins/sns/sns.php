<?php
/*-------------------------------------------*/
/*  Options Init
/*-------------------------------------------*/
/*  Add facebook aprication id
/*-------------------------------------------*/
/*  Add setting page
/*-------------------------------------------*/
/*  Options Init
/*-------------------------------------------*/


function vkExUnit_sns_options_init() {
	if ( false === vkExUnit_get_sns_options() ) {
		add_option( 'vkExUnit_sns_options', vkExUnit_get_sns_options_default() ); }
	vkExUnit_register_setting(
		__( 'SNS', 'vkExUnit' ), 	// tab label.
		'vkExUnit_sns_options',			// name attr
		'vkExUnit_sns_options_validate', // sanitaise function name
		'vkExUnit_add_sns_options_page'  // setting_page function name
	);
}
add_action( 'admin_init', 'vkExUnit_sns_options_init' );

function vkExUnit_get_sns_options() {
	$options			= get_option( 'vkExUnit_sns_options', vkExUnit_get_sns_options_default() );
	$options_dafault	= vkExUnit_get_sns_options_default();
	foreach ( $options_dafault as $key => $value ) {
		$options[ $key ] = (isset( $options[ $key ] )) ? $options[ $key ] : $options_dafault[ $key ];
	}
	return apply_filters( 'vkExUnit_sns_options', $options );
}

function vkExUnit_get_sns_options_default() {
	$default_options = array(
		'fbAppId' 				=> '',
		'fbPageUrl' 			=> '',
		'ogImage' 				=> '',
		'twitterId' 			=> '',
		'enableOGTags' 			=> true,
		'enableTwitterCardTags' => true,
		'enableSnsBtns' 		=> true,
		'enableFollowMe' 		=> true,
		'followMe_title'		=> 'Follow me!',
		'SnsBtn_enable_posttype'=> array(),
	);
	return apply_filters( 'vkExUnit_sns_options_default', $default_options );
}

/*-------------------------------------------*/
/*  validate
/*-------------------------------------------*/

function vkExUnit_sns_options_validate( $input ) {
	$output = $defaults = vkExUnit_get_sns_options_default();

	$output['fbAppId']					= $input['fbAppId'];
	$output['fbPageUrl']				= $input['fbPageUrl'];
	$output['ogImage']					= $input['ogImage'];
	$output['twitterId']				= $input['twitterId'];
	$output['enableOGTags']  			= ( isset( $input['enableOGTags'] ) && isset( $input['enableOGTags'] ) == 'true' )? true: false;
	$output['enableTwitterCardTags']  	= ( isset( $input['enableTwitterCardTags'] ) && isset( $input['enableTwitterCardTags'] ) == 'true' )? true: false;
	$output['enableSnsBtns']   			= ( isset( $input['enableSnsBtns'] ) && isset( $input['enableSnsBtns'] ) == 'true' )? true: false;
	$output['enableFollowMe']  			= ( isset( $input['enableFollowMe'] ) && isset( $input['enableFollowMe'] ) == 'true' )? true: false;
	$output['followMe_title']			= $input['followMe_title'];

	$output['SnsBtn_enable_posttype'] = array();
	$post_types = vkExUnit_sns_get_post_types();
	foreach( $post_types as $post_type ){
		$output['SnsBtn_enable_posttype'][$post_type] = ( isset( $input['SnsBtn_enable_posttype'][$post_type] ) && $input['SnsBtn_enable_posttype'][$post_type] == 'true' )? true : false;
	}
	return apply_filters( 'vkExUnit_sns_options_validate', $output, $input, $defaults );
}



function vkExUnit_sns_get_post_types() {
	return array_merge( array( 'post' => 'post', 'page' => 'page' ), get_post_types( array( '_builtin' => false, 'public' => true ) ) );
}



add_action( 'admin_menu', 'vkExUnit_sns_set_meta_box' );
function vkExUnit_sns_set_meta_box() {
	foreach ( vkExUnit_sns_get_post_types() as $post_type ) {
		add_meta_box( 'vkExUnit_sns', __( 'SNS buttons', 'vkExUnit' ), 'vkExUnit_sns_render_meta_box' , $post_type, 'normal', 'nomral' );
	}
}



function vkExUnit_sns_render_meta_box() {
	$disable_sns = get_post_meta( get_the_id(), 'vkExUnit_sns_disable', true );

	echo '<input type="hidden" name="_nonce_vkExUnit_custom_sns_disable" id="_nonce_vkExUnit__custom_sns_disable_noonce" value="'.wp_create_nonce( 'vkExUnit_sns' ).'" />';
	echo '<label><input type="checkbox" name="vkExUnit_sns_disable" value="true" ' . ( ($disable_sns)? 'checked' : '' ) . ' />'.__( 'Do not set SNS bar.', 'vkExUnit' ).'</label>';
}



add_action( 'save_post', 'vkExUnit_sns_save_customfield' );
function vkExUnit_sns_save_customfield( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id; }

	$noonce = isset( $_POST['_nonce_vkExUnit_custom_sns_disable'] ) ? htmlspecialchars( $_POST['_nonce_vkExUnit_custom_sns_disable'] ) : null;
	if ( ! wp_verify_nonce( $noonce, 'vkExUnit_sns' ) ) {
		return $post_id;
	}

	if ( isset( $_POST['vkExUnit_sns_disable'] ) && $_POST['vkExUnit_sns_disable'] == 'true' ){
		update_post_meta( $post_id, 'vkExUnit_sns_disable', true );
	} else {
		delete_post_meta( $post_id, 'vkExUnit_sns_disable' );
	}
}


/*-------------------------------------------*/
/*  set global
/*-------------------------------------------*/
add_action( 'wp_head', 'vkExUnit_set_sns_options',1 );
function vkExUnit_set_sns_options() {
	global $vkExUnit_sns_options;
	$vkExUnit_sns_options = vkExUnit_get_sns_options();
}

/*-------------------------------------------*/
/*  Add facebook aprication id
/*-------------------------------------------*/
add_action( 'wp_footer', 'exUnit_print_fbId_script' );
function exUnit_print_fbId_script() {
?>
<div id="fb-root"></div>
<?php
$options = vkExUnit_get_sns_options();
$fbAppId = (isset( $options['fbAppId'] )) ? $options['fbAppId'] : '';
?>
<script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.3&appId=<?php echo esc_html( $fbAppId );?>";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
	<?php //endif;
}

$vkExUnit_sns_options = vkExUnit_get_sns_options();

require vkExUnit_get_directory() . '/plugins/sns/function_fbPagePlugin.php';

if ( $vkExUnit_sns_options['enableOGTags'] == true ) {
	require vkExUnit_get_directory() . '/plugins/sns/function_og.php'; }
if ( $vkExUnit_sns_options['enableSnsBtns'] == true ) {
	require vkExUnit_get_directory() . '/plugins/sns/function_snsBtns.php'; }
if ( $vkExUnit_sns_options['enableTwitterCardTags'] == true ) {
	require vkExUnit_get_directory() . '/plugins/sns/function_twitterCard.php'; }
if ( $vkExUnit_sns_options['enableFollowMe'] == true ) {
	require vkExUnit_get_directory() . '/plugins/sns/function_follow.php'; }

require vkExUnit_get_directory() . '/plugins/sns/function_meta_box.php';

/*-------------------------------------------*/
/*  Add setting page
/*-------------------------------------------*/

function vkExUnit_add_sns_options_page() {
	require dirname( __FILE__ ) . '/sns_admin.php';
	?>
	<?php
}
