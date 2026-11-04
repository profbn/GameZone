<?php
if (!defined('ABSPATH')) exit;
define('GAMEZONE_VERSION', '1.0.0');
function gamezone_setup() {
 load_theme_textdomain('gamezone', get_template_directory() . '/languages');
 add_theme_support('title-tag'); add_theme_support('post-thumbnails');
 add_theme_support('custom-logo', array('height'=>90,'width'=>260,'flex-height'=>true,'flex-width'=>true));
 add_theme_support('html5',array('search-form','comment-form','comment-list','gallery','caption','style','script'));
 add_theme_support('automatic-feed-links'); add_theme_support('responsive-embeds'); add_theme_support('align-wide');
 register_nav_menus(array('primary'=>__('Menu principal','gamezone'),'footer'=>__('Menu do rodapé','gamezone')));
 add_image_size('gamezone-card',640,420,true); add_image_size('gamezone-hero',1400,760,true);
}
add_action('after_setup_theme','gamezone_setup');
function gamezone_assets() {
 wp_enqueue_style('gamezone-main',get_template_directory_uri().'/assets/css/main.css',array(),GAMEZONE_VERSION);
 wp_enqueue_script('gamezone-main',get_template_directory_uri().'/assets/js/main.js',array(),GAMEZONE_VERSION,true);
 if(is_singular() && comments_open() && get_option('thread_comments')) wp_enqueue_script('comment-reply');
}
add_action('wp_enqueue_scripts','gamezone_assets');
function gamezone_widgets(){register_sidebar(array('name'=>__('Barra lateral','gamezone'),'id'=>'sidebar-1','before_widget'=>'<section class="widget panel">','after_widget'=>'</section>','before_title'=>'<h2 class="panel-title">','after_title'=>'</h2>'));}
add_action('widgets_init','gamezone_widgets');
function gamezone_categories(){return array('noticias'=>__('Notícias','gamezone'),'reviews'=>__('Reviews','gamezone'),'jogos'=>__('Jogos','gamezone'),'guias'=>__('Dicas e guias','gamezone'));}
function gamezone_category_link($slug){$cat=get_category_by_slug($slug);return $cat?get_category_link($cat->term_id):home_url('/?s='.rawurlencode($slug));}
function gamezone_customize($wp_customize){
 $wp_customize->add_section('gamezone_home',array('title'=>__('GameZone: página inicial','gamezone'),'priority'=>35));
 $wp_customize->add_setting('gamezone_hero_title',array('default'=>__('Seu universo gamer começa aqui','gamezone'),'sanitize_callback'=>'sanitize_text_field'));
 $wp_customize->add_control('gamezone_hero_title',array('section'=>'gamezone_home','label'=>__('Título da capa sem notícias','gamezone'),'type'=>'text'));
 $wp_customize->add_setting('gamezone_hero_description',array('default'=>__('Notícias, análises, lançamentos e guias em um só lugar.','gamezone'),'sanitize_callback'=>'sanitize_text_field'));
 $wp_customize->add_control('gamezone_hero_description',array('section'=>'gamezone_home','label'=>__('Descrição da capa','gamezone'),'type'=>'text'));
 $wp_customize->add_setting('gamezone_accent',array('default'=>'#9d4dff','sanitize_callback'=>'sanitize_hex_color'));
 $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,'gamezone_accent',array('section'=>'gamezone_home','label'=>__('Cor de destaque','gamezone'))));
}
add_action('customize_register','gamezone_customize');
function gamezone_accent(){ $c=get_theme_mod('gamezone_accent','#9d4dff'); if($c) echo '<style id="gamezone-accent">:root{--accent:'.esc_html($c).'}</style>'; }
add_action('wp_head','gamezone_accent');
function gamezone_review_box(){add_meta_box('gamezone_rating',__('Nota do review (0 a 10)','gamezone'),'gamezone_review_box_render','post','side','default');}
add_action('add_meta_boxes','gamezone_review_box');
function gamezone_review_box_render($post){wp_nonce_field('gamezone_rating_save','gamezone_rating_nonce');$v=get_post_meta($post->ID,'_gamezone_rating',true);echo '<label for="gamezone-rating">'.esc_html__('Nota opcional (ex.: 8.5)','gamezone').'</label><input id="gamezone-rating" type="number" min="0" max="10" step="0.1" name="gamezone_rating" value="'.esc_attr($v).'" style="width:100%">';}
function gamezone_save_rating($post_id){
 if(!isset($_POST['gamezone_rating_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['gamezone_rating_nonce'])),'gamezone_rating_save'))return;
 if(defined('DOING_AUTOSAVE')&&DOING_AUTOSAVE)return;
 if(!current_user_can('edit_post',$post_id))return;
 if(!isset($_POST['gamezone_rating']))return;
 $raw=sanitize_text_field(wp_unslash($_POST['gamezone_rating']));
 if($raw===''){delete_post_meta($post_id,'_gamezone_rating');return;}
 if(!is_numeric($raw))return;
 update_post_meta($post_id,'_gamezone_rating',strval(max(0,min(10,(float)$raw))));
}
add_action('save_post','gamezone_save_rating');
function gamezone_fallback_menu(){echo '<ul class="nav-list"><li><a href="'.esc_url(home_url('/')).'">'.esc_html__('Início','gamezone').'</a></li>';foreach(gamezone_categories() as $slug=>$name){echo '<li><a href="'.esc_url(gamezone_category_link($slug)).'">'.esc_html($name).'</a></li>';}echo '</ul>';}
function gamezone_excerpt_length(){return 22;}add_filter('excerpt_length','gamezone_excerpt_length',999);
function gamezone_body_classes($classes){$classes[]='gamezone-theme';return $classes;}add_filter('body_class','gamezone_body_classes');
