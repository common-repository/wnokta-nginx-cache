<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       wnokta.com/bb
 * @since      1.0.0
 *
 * @package    Wnokta_nginx_cache
 * @subpackage Wnokta_nginx_cache/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wnokta_nginx_cache
 * @subpackage Wnokta_nginx_cache/public
 * @author     WNOKTA Bilişim Hizmetleri Ltd. şti. <wnokta.nginx.cache@wnokta.com>
 */

use MatthiasMullie\Minify;

class Wnokta_nginx_cache_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;
	
	/*
	 * CSS Ve JS Dosyalarının tutulacağı array değişkenler.
	 */
	public $jsler = [];
	public $cssler = [];
	

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		
		//print_r(plugins_url( ));
		
		$GhtmlziP = !get_option('wnokta_nginx_cache_htmlzip') ? '' : get_option('wnokta_nginx_cache_htmlzip');
		$GcssziP = !get_option('wnokta_nginx_cache_cssjszip') ? '' : get_option('wnokta_nginx_cache_cssjszip');
		
		if($GcssziP == 1 && !is_admin() && !get_current_user_id()){
    		/*
    		 * CSS Dosyalarının sıkıştırılmış olanları Ekle
    		 */
    		add_action('wp_enqueue_scripts', [$this, 'wnokta_nginx_cache_ekle_minify_css']);
    		/*
    		 * CSS Dosyalarının sıkıştırılmış olanları Ekle
    		 */
    		
    		/*
    		 * CSS Dosyalarını Al ve Kaldır ve Oluştur
    		 */
    		add_action('wp_print_styles', [$this, 'wnokta_nginx_cache_al_kaldir_css']);
    		/*
    		 * CSS Dosyalarını Al ve Kaldır ve Oluştur
    		 */
    		
            /*
             * JS Dosyalarının sıkıştırılmış olanları Ekle
             */
    		add_action('wp_enqueue_scripts', [$this, 'wnokta_nginx_cache_ekle_minify_js']);
            /*
             * JS Dosyalarının sıkıştırılmış olanları Ekle
             */
    		
            /*
             * JS Dosyalarını Al ve Kaldır ve Oluştur
             */
    		add_action('wp_print_scripts', [$this, 'wnokta_nginx_cache_al_kaldir_js']);
            /*
             * JS Dosyalarını Al ve Kaldır ve Oluştur
             */
		}
		/*
		 * HTML Dosyalarını Al ve Oluştur
		 */
		if($GhtmlziP == 1 && !is_admin() && !get_current_user_id()){
		    add_action('wp_loaded', [$this, 'wnokta_nginx_cache_html_al']);
		}
		/*
		 * HTML Dosyalarını Al ve Oluştur
		 */

	}
	
	/*
	 * JS Dosyalarını Al ve Kaldır ve Oluştur
	 */
	function wnokta_nginx_cache_al_kaldir_js() {
	    global $wp_scripts;
	    
	    if(is_a($wp_scripts, 'WP_Scripts')){
	        foreach ($wp_scripts->queue as $mjsf) {

	            if(!in_array($mjsf, ['wnokta_nginx_cache','wnokta-nginx-cache-js-min','wnokta_nginx_cache-admin','admin-bar','jquery-ui-core'])){
	                wp_dequeue_script($mjsf);
	                $jsYolu = preg_replace('|http(.*?)/wp-content/(.*?)|is', '/wp-content/$2', $wp_scripts->registered[$mjsf]->src);
	                $this->jsler[] = $jsYolu;
	            }
	        }

	        if(!file_exists(plugin_dir_path( __FILE__ ).'../cache/js/min/wnokta-nginx-cache.min.js')){
	            $this->wnokta_nginx_cache_js_olustur();
	        }
	    }
	}
	/*
	 * JS Dosyalarını Al ve Kaldır ve Oluştur
	 */
	
	/*
	 * JS Sıkıştırılmış Dosyasını Oluştur
	 */
	function wnokta_nginx_cache_js_olustur() {
	    $metrobusJS = new Minify\JS();

	    foreach ($this->jsler as $jsYolcular){
	        $metrobusJS->add(plugin_dir_path( __FILE__ )."../../../../".ltrim($jsYolcular,'/'));
	    }
	    
	    if(!is_dir(plugin_dir_path( __FILE__ ).'../cache/js/min/')){
	        wp_mkdir_p(plugin_dir_path( __FILE__ ).'../cache/js/min/');
	    }
	    try {
	        $metrobusJS->minify(plugin_dir_path( __FILE__ ).'../cache/js/min/wnokta-nginx-cache.min.js');
	    } catch (Exception $e) {
	        echo __('Bir hata oluştu: ','wnokta_nginx_cache').$e->getMessage();
	    }
	    
	}
	/*
	 * JS Sıkıştırılmış Dosyasını Oluştur
	 */
	
	/*
	 * JS Dosyalarının sıkıştırılmış olanları Ekle
	 */
	function wnokta_nginx_cache_ekle_minify_js() {
	    wp_enqueue_script('wnokta-nginx-cache-js-min', plugins_url( 'cache/js/min/wnokta-nginx-cache.min.js', dirname(__FILE__) ),[],null,true);
	}
	/*
	 * JS Dosyalarının sıkıştırılmış olanları Ekle
	 */
	
	/*
	 * CSS Dosyalarını Al ve Kaldır ve Oluştur
	 */
	function wnokta_nginx_cache_al_kaldir_css() {
	    global $wp_styles;

	    if(is_a($wp_styles, 'WP_Styles')){
	        foreach ($wp_styles->queue as $mcssf) {
	            
	            if(!in_array($mcssf, ['wnokta_nginx_cache','wnokta_nginx_cache-admin', 'wnokta-nginx-cache-style-min', 'admin-bar'])){
	                wp_dequeue_style($mcssf);
	                $cssYolu = preg_replace('|http(.*?)/wp-content/(.*?)|is', '/wp-content/$2', $wp_styles->registered[$mcssf]->src);
	                $this->cssler[] = $cssYolu;
	            }
	        }
	        if(!file_exists(plugin_dir_path( __FILE__ ).'../cache/css/min/wnokta-nginx-cache.min.css')){
	            $this->wnokta_nginx_cache_css_olustur();
	        }
	         
	    }
	}
	/*
	 * CSS Dosyalarını Al ve Kaldır ve Oluştur
	 */
	
	/*
	 * Sıkıştırılmış CSS Dosyasını Oluştur
	 */
	function wnokta_nginx_cache_css_olustur() {
	    $metrobusCSS = new Minify\CSS();

	    foreach ($this->cssler as $CSSyolcuLar) {
	        $metrobusCSS->add(plugin_dir_path( __FILE__ )."../../../../".ltrim($CSSyolcuLar,'/'));
	    }	   
	    if(!is_dir(plugin_dir_path( __FILE__ ).'../cache/css/min/')){
	        wp_mkdir_p(plugin_dir_path( __FILE__ ).'../cache/css/min/');
	    }
	    try {
	        $metrobusCSS->minify(plugin_dir_path( __FILE__ ).'../cache/css/min/wnokta-nginx-cache.min.css');
	    } catch (Exception $e) {
	        echo __('Bir hata oluştu: ','wnokta_nginx_cache').$e->getMessage();
	    }
	}
	/*
	 * Sıkıştırılmış CSS Dosyasını Oluştur
	 */
	
	/*
	 * CSS Dosyalarının sıkıştırılmış olanları Ekle
	 */
	function wnokta_nginx_cache_ekle_minify_css() {
	    wp_enqueue_style('wnokta-nginx-cache-style-min',plugins_url( 'cache/css/min/wnokta-nginx-cache.min.css', dirname(__FILE__) ), [], $this->version, 'all');
	}
	/*
	 * CSS Dosyalarının sıkıştırılmış olanları Ekle
	 */
	
	/*
	 * HTML Dosyasını Al
	 */
	function wnokta_nginx_cache_html_al() {
	    if(!is_admin() && !is_user_logged_in() && !is_feed()){
	        ob_start([$this, 'wnokta_nginx_cache_html_onbellege_yukle']);
	    }
	}
	/*
	 * HTML Dosyasını Al
	 */
	
	/*
	 * HTML Önbelleğe Al
	 */
	function wnokta_nginx_cache_html_onbellege_yukle() {
        global $post,$wp;
        
        // Ana Sayfa
        if(isset($wp->query_vars) && empty($wp->query_vars) && get_option( 'show_on_front' ) == "posts"){
            $HTMLDosyaAdi = md5("0.14");
        }else{
            $HTMLDosyaAdi = md5("a".get_option('page_on_front'));
        }
        //Yazı ID 
        if(isset($wp->query_vars['p']) && !empty($wp->query_vars['p'])){
            $HTMLDosyaAdi = md5("po".$wp->query_vars['p']);
        }
        //Yazı permalink
        if(isset($wp->query_vars['name']) && !empty($wp->query_vars['name'])){
            $HTMLDosyaAdi = md5("po".$wp->query_vars['name']);
        }
        // Sayfa ID 
        if(isset($wp->query_vars['page_id']) && !empty($wp->query_vars['page_id'])){
            $HTMLDosyaAdi = md5("pa".$wp->query_vars['page_id']);
        }
        //Sayfa permalink
        if(isset($wp->query_vars['pagename']) && !empty($wp->query_vars['pagename'])){
            $HTMLDosyaAdi = md5("pa".$wp->query_vars['pagename']);
        }
        //etiket permalink veya id
        if(isset($wp->query_vars['tag']) && !empty($wp->query_vars['tag'])){
            if(isset($wp->query_vars['paged']) && !empty($wp->query_vars['paged'])){
                $HTMLDosyaAdi = md5("t".$wp->query_vars['tag'].$wp->query_vars['paged']);
            }else{
                $HTMLDosyaAdi = md5("t".$wp->query_vars['tag']);
            }
        }
        //Arşiv id
        if(isset($wp->query_vars['m']) && !empty($wp->query_vars['m'])){
            //sayfalama
            if(isset($wp->query_vars['paged']) && !empty($wp->query_vars['paged'])){
                $HTMLDosyaAdi = md5("m".$wp->query_vars['m'].$wp->query_vars['paged']);
            }else{
                $HTMLDosyaAdi = md5("m".$wp->query_vars['m']);
            }
        }
        //Arşiv permalink
        if(isset($wp->query_vars['year']) && !empty($wp->query_vars['year'])){
            if(isset($wp->query_vars['monthnum']) && !empty($wp->query_vars['monthnum'])){
                if(isset($wp->query_vars['day']) && !empty($wp->query_vars['day'])){
                    //sayfalama
                    if(isset($wp->query_vars['paged']) && !empty($wp->query_vars['paged'])){
                        $HTMLDosyaAdi = md5("m".$wp->query_vars['year'].$wp->query_vars['monthnum'].$wp->query_vars['day'].$wp->query_vars['paged']);
                    }else{
                        $HTMLDosyaAdi = md5("m".$wp->query_vars['year'].$wp->query_vars['monthnum'].$wp->query_vars['day']);
                    }
                }else{
                    //sayfalama
                    if(isset($wp->query_vars['paged']) && !empty($wp->query_vars['paged'])){
                        $HTMLDosyaAdi = md5("m".$wp->query_vars['year'].$wp->query_vars['monthnum'].$wp->query_vars['paged']);
                    }else{
                        $HTMLDosyaAdi = md5("m".$wp->query_vars['year'].$wp->query_vars['monthnum']);
                    }
                }
            }else{
                //sayfalama
                if(isset($wp->query_vars['paged']) && !empty($wp->query_vars['paged'])){
                    $HTMLDosyaAdi = md5("m".$wp->query_vars['year'].$wp->query_vars['paged']);
                }else{
                    $HTMLDosyaAdi = md5("m".$wp->query_vars['year']);
                }
            }

        }
        //Yazar ID
        if(isset($wp->query_vars['author']) && !empty($wp->query_vars['author'])){
            if(isset($wp->query_vars['paged']) && !empty($wp->query_vars['paged'])){
                $HTMLDosyaAdi = md5("y".$wp->query_vars['author'].$wp->query_vars['paged']);
            }else{
                $HTMLDosyaAdi = md5("y".$wp->query_vars['author']);
            }
        }
        //Yazar permalink
        if(isset($wp->query_vars['author_name']) && !empty($wp->query_vars['author_name'])){
            if(isset($wp->query_vars['paged']) && !empty($wp->query_vars['paged'])){
                $HTMLDosyaAdi = md5("y".$wp->query_vars['author_name'].$wp->query_vars['paged']);
            }else{
                $HTMLDosyaAdi = md5("y".$wp->query_vars['author_name']);
            }
        }
        //Kategori id
        if(isset($wp->query_vars['cat']) && !empty($wp->query_vars['cat'])){
            if(isset($wp->query_vars['paged']) && !empty($wp->query_vars['paged'])){
                $HTMLDosyaAdi = md5("c".$wp->query_vars['cat'].$wp->query_vars['paged']);
            }else{
                $HTMLDosyaAdi = md5("c".$wp->query_vars['cat']);
            }
        }
        //Kategori Permalink
        if(isset($wp->query_vars['category_name']) && !empty($wp->query_vars['category_name'])){
            if(isset($wp->query_vars['paged']) && !empty($wp->query_vars['paged'])){
                $HTMLDosyaAdi = md5("c".$wp->query_vars['category_name'].$wp->query_vars['paged']);
            }else{
                $HTMLDosyaAdi = md5("c".$wp->query_vars['category_name']);
            }
        }
        

        if(file_exists(plugin_dir_path( __FILE__ ).'../cache/HTML/'.$HTMLDosyaAdi.'.html')){
            return file_get_contents(plugin_dir_path( __FILE__ ).'../cache/HTML/'.$HTMLDosyaAdi.'.html');
        }else{
            $htmlSayfa = ob_get_contents();
            $htmlSayfa = TinyMinify::html($htmlSayfa, $secenekler = [
                'collapse_whitespace' => false,
                'disable_comments' => false,
            ]
                );
            if(!is_dir(plugin_dir_path( __FILE__ ).'../cache/HTML/')){
                wp_mkdir_p(plugin_dir_path( __FILE__ ).'../cache/HTML/');
            }
            $dosyaAc = fopen(plugin_dir_path( __FILE__ ).'../cache/HTML/'.$HTMLDosyaAdi.'.html', w);
            fwrite($dosyaAc, $htmlSayfa);
            fclose($dosyaAc);
            return $htmlSayfa;
            
        }
	}
	/*
	 * HTML Önbelleğe Al
	 */
    
	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wnokta_nginx_cache_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wnokta_nginx_cache_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		//wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wnokta_nginx_cache-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wnokta_nginx_cache_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wnokta_nginx_cache_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
	    // Yönetici girişi yapılmış ise admin bar üzerindeki sunucu ve yazılım önbelleği temizleme düğmelerinin çalışmasına izin ver
	    if(current_user_can('manage_options')){
		  wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wnokta_nginx_cache-public.js', array( 'jquery' ), $this->version, false );	    
		
		  wp_localize_script( $this->plugin_name, 'benim_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	    }

	}

}
