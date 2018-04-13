<?php
/*
Plugin Name: LeTarget
Plugin URI: http://testLeTarget.com
Description: плагін добавляє до кожного заголовку поста ( post_type = 'post' ) надпис LeTarget.
Version: 1.0
Author: Роман
Author URI: http://kusmirchuk.kl.com.ua
*/
add_filter( 'the_post', 'add_to_tiile_post' );
function add_to_tiile_post(){
	$post = get_post( $post );
	$arr=get_option('option_name');
	$text_name=$arr['input_text'];
	if ($arr['checkbox_show']){
		if ($arr['checkbox_left']){
			return  $post->post_title=$text_name.' '.$post->post_title;
		}else { return  $post->post_title=$post->post_title.' '.$text_name;}
		
	}
	
}
add_action('admin_menu', 'add_plugin_page');
function add_plugin_page(){
	add_menu_page('LeTarget', 'LeTarget', 8, __FILE__, 'primer_options_page_output');
	
}
function primer_options_page_output(){
?>
<div class="wrap">
	<h2><?php echo get_admin_page_title() ?></h2>
	<form action="options.php" method="POST">
		<?php
			settings_fields( 'option_group' );
			do_settings_sections( 'primer_page' );
			submit_button();
		?>
	</form>
</div>
<?php
}
add_action('admin_init', 'plugin_settings');
function plugin_settings(){

register_setting( 'option_group', 'option_name', 'sanitize_callback' );
add_settings_section( 'section_id', 'Налаштування', '', 'primer_page' );
add_settings_field('primer_field1', 'Текст', 'fill_primer_field1', 'primer_page', 'section_id' );
add_settings_field('primer_field2', 'Показувати текст', 'fill_primer_field2', 'primer_page', 'section_id' );
add_settings_field('primer_field3', 'Показувати слово<br>(включено-зліва, виключено-справа)', 'fill_primer_field3', 'primer_page', 'section_id' );

}
function fill_primer_field1(){
$val = get_option('option_name');
$val = $val ? $val['input_text'] :"LeTarget";

?>
<input type="text" name="option_name[input_text]" value="<?php echo  esc_attr( $val ) ?>" />
<?php
}
function fill_primer_field2(){
$val = get_option('option_name');
$val = $val ? $val['checkbox_show'] : null;
?>
<label><input type="checkbox" name="option_name[checkbox_show]" value="1" <?php checked( 1, $val ) ?> /> </label>
<?php
}
function fill_primer_field3(){
$val = get_option('option_name');
$val = $val ? $val['checkbox_left'] : null;
?>
<label><input type="checkbox" name="option_name[checkbox_left]" value="1" <?php checked( 1, $val ) ?> /> </label>
<?php
}
?>