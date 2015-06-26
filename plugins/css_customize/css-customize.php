<?php
$wp_theme = wp_get_theme();

$customize = new biz_vektor_css_customize();


class biz_vektor_css_customize{

	public function __construct(){
		$this->set_hook();
	}


	public  function set_hook(){
		add_filter( 'biz_vektor_is_css_customize_widgets', array($this, 'biz_vektor_css_custom_beacon'), 10, 1 );
		add_action( 'admin_footer',  array($this, 'css_customize_page_js_and_css'));
		add_action( 'wp_head',       array($this, 'biz_vektor_css_customize_push_css'), 200);
		add_action( 'admin_menu',    array($this, 'biz_vektor_css_customize_menu'));
	}


	public function biz_vektor_css_custom_beacon($flag){
		$flag = true;
		return $flag;
	}

	/*-------------------------------------------*/
	/*	CSSカスタマイズ」のメニュー
	/*-------------------------------------------*/
	public function biz_vektor_css_customize_menu() 
	{
		$capability_required = add_filter( 'vkExUnit_ga_page_capability', vkExUnit_get_capability_required() );
		add_submenu_page(
			'vkExUnit_setting_page',
			__( 'CSS Customize', 'biz-vektor' ),
			__( 'CSS Customize', 'biz-vektor' ),
			$capability_required,
			'vkExUnit_css_customize',
			array($this, 'biz_vektor_css_customize_render_page')
		);
	}


	public function biz_vektor_css_customize_render_page()
	{
		$data = $this->biz_vektor_css_customize_valid_form();

		include('css-customize-edit.php');
	}


	/*-------------------------------------------*/
	/*	設定画面のCSSとJS
	/*-------------------------------------------*/
	public function css_customize_page_js_and_css( $hook_suffix ) {
		global $hook_suffix;
		if (
			$hook_suffix == 'appearance_page_theme-css-customize' ||
			$hook_suffix == 'appearance_page_bv_grid_unit_options'
			){
		?>
	 <script type="text/javascript">
	jQuery(document).ready(function($){
		jQuery("#tipsBody dl").each(function(){
			var targetId = jQuery(this).attr("id");
			var targetTxt = jQuery(this).find("dt").text();
			var listItem = '<li><a href="#'+ targetId +'">'+ targetTxt +'</a></li>'
			jQuery('#tipsList ul').append(listItem);
		});
	});
	</script>


		<?php
		}
	}


	public function biz_vektor_css_customize_valid_form()
	{
		$data = array(
			'mess' => '',
			'customCss' => ''
		);

		if( isset($_POST['bv-css-submit']) && !empty($_POST['bv-css-submit'])
			&& isset($_POST['bv-css-css']) 
			&& isset($_POST['biz-vektor-css-nonce']) && wp_verify_nonce( $_POST['biz-vektor-css-nonce'], 'biz-vektor-css-submit' ) )
		{
			$cleanCSS = strip_tags(stripslashes(trim($_POST['bv-css-css'])));

			if( update_option('vkExUnit_css_customize', $cleanCSS) )
				$data['mess'] = '<div id="message" class="updated"><p>' . __( 'Your custom CSS was saved.', 'biz-vektor') . '</p></div>';
		}
		else
		{
			if( isset($_POST['bv-css-submit']) && !empty($_POST['bv-css-submit']) )
				$data['mess'] = '<div id="message" class="error"><p>' . __( 'Error occured. Please try again.', 'biz-vektor') . '</p></div>';
		}

		$data['customCss'] = $this->biz_vektor_css_customize_get_css();

		return $data;
	}


	public function biz_vektor_css_customize_get_css()
	{
		if( get_option('vkExUnit_css_customize') )
			return get_option('vkExUnit_css_customize');
		else
			return '';
	}


	public function biz_vektor_css_customize_push_css(){

		if( get_option('vkExUnit_css_customize') ){
		?>
	<style type="text/css">
	<?php echo get_option('vkExUnit_css_customize') ?>
	</style>
		<?php
		}
	}
}