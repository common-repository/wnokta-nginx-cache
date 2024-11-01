<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       wnokta.com/bb
 * @since      1.0.0
 *
 * @package    Wnokta_nginx_cache
 * @subpackage Wnokta_nginx_cache/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wnokta_nginx_cache
 * @subpackage Wnokta_nginx_cache/admin
 * @author     WNOKTA Bilişim Hizmetleri Ltd. şti. <wnokta.nginx.cache@wnokta.com>
 */
class Wnokta_nginx_cache_Admin {

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

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		
		
		/*
		 * .htaccess Dosyası Ekleme
		 *
		if(file_exists(plugin_dir_path( __FILE__ )."../../../../".'/.htaccess')){
		    $htaccess_Get = file_get_contents(plugin_dir_path( __FILE__ )."../../../../".'/.htaccess');
		    
		    preg_match('|#wnokta_nginx_cache#(.*?)\s#wnokta_nginx_cache#|ms', $htaccess_Get,$htaccess_Cikis);
		    
		    if(!isset($htaccess_Cikis['0'])){
		        $yeni_htaccess = '#wnokta_nginx_cache#'."\n".
		        //Kodlar buraya Gelecek
                                  '#wnokta_nginx_cache#';
		        $htDosyasiAc = fopen(plugin_dir_path( __FILE__ )."../../../../".'/.htaccess', w);
		        fwrite($htDosyasiAc, $yeni_htaccess."\n\n".$htaccess_Get);
		        fclose($htDosyasiAc);
            }
		}
		*/
		/**
		 * Ayarlar Menüsü Ekle
		 */

		add_action( 'admin_menu', [$this, "wnokta_nginx_cache_admin_menu"] );
		/**
		 * Admin Bar Menüsü Ekle
		 */
        add_action('admin_bar_menu', [$this, 'wnokta_nginx_cache_bar_menu'], 900);
		/*
		 * Ajax İşlemlerim
		 */
        add_action('wp_ajax_wnokta_nginx_cache_sunucu_onbellek_ayar', [$this, 'wnokta_nginx_cache_sunucu_onbellek_ayar_kayit']);
        add_action('wp_ajax_wnokta_nginx_cache_yazilim_onbellek_ayar', [$this, 'wnokta_nginx_cache_yazilim_onbellek_ayar_kayit']);
        add_action('wp_ajax_wnokta_nginx_cache_sunucu_onbellek_temizle', [$this, 'wnokta_nginx_cache_sunucu_onbellek_ayar_temizle']);
        add_action('wp_ajax_wnokta_nginx_cache_yazilim_onbellek_temizle', [$this, 'wnokta_nginx_cache_yazilim_onbellek_ayar_temizle']);
        
        /*
         * Filtre işlemleri
         */
        $yyga = !get_option('wnokta_nginx_cache_post') ? '' : get_option('wnokta_nginx_cache_post');
        $yyg = !get_option('wnokta_nginx_cache_post_update') ? '' : get_option('wnokta_nginx_cache_post_update');
        $ysga = !get_option('wnokta_nginx_cache_page') ? '' : get_option('wnokta_nginx_cache_page');
        $ysg = !get_option('wnokta_nginx_cache_page_update') ? '' : get_option('wnokta_nginx_cache_page_update');
        $cypa = !get_option('wnokta_nginx_cache_comment_push') ? '' : get_option('wnokta_nginx_cache_comment_push');
        
        $yygas = !get_option('wnokta_nginx_cache_post_snc') ? '' : get_option('wnokta_nginx_cache_post_snc');
        $yygs = !get_option('wnokta_nginx_cache_post_update_snc') ? '' : get_option('wnokta_nginx_cache_post_update_snc');
        $ysgas = !get_option('wnokta_nginx_cache_page_snc') ? '' : get_option('wnokta_nginx_cache_page_snc');
        $ysgs = !get_option('wnokta_nginx_cache_page_update_snc') ? '' : get_option('wnokta_nginx_cache_page_update_snc');
        $cypas = !get_option('wnokta_nginx_cache_comment_push_snc') ? '' : get_option('wnokta_nginx_cache_comment_push_snc');
        
        // Yazı yayınlandığında herşey kayıt olduktan sonra çağır.
        //Yazıda kategori ve Etiket seçili ise Kategori ve etiketleri temizle
        if(isset($yyg) && !empty($yyg) && $yyg == 1){
            add_action('set_object_terms', [$this, 'wnokta_nginx_cache_yeni_ve_guncellenen_yazi_temizle']);
        }
        // Yazı yayınlandığında herşey kayıt olduktan sonra çağır.
        //Yazıda kategori ve Etiket seçili ise Kategori ve etiketleri temizle Sunucu tabanlı
        if(isset($yygs) && !empty($yygs) && $yygs == 1){
            add_action('set_object_terms', [$this, 'wnokta_nginx_cache_yeni_ve_guncellenen_yazi_temizle_snc']);
        }
        //Yeni yazı yayimlandığında anasayfayı temizle
        if(isset($yyga) && !empty($yyga) && $yyga == 1){
            add_action('publish_post', [$this, 'wnokta_nginx_cache_yeni_ve_guncellenen_anasayfa_temizle']);
        }
        if(isset($ysga) && !empty($ysga) && $ysga == 1){
            add_action('publish_page', [$this, 'wnokta_nginx_cache_yeni_ve_guncellenen_anasayfa_temizle']);
        }
        //Yeni yazı yayimlandığında anasayfayı temizle sunucu tabanlı
        if(isset($yygas) && !empty($yygas) && $yygas == 1){
            add_action('publish_post', [$this, 'wnokta_nginx_cache_yeni_ve_guncellenen_anasayfa_temizle_snc']);
        }
        if(isset($ysgas) && !empty($ysgas) && $ysgas == 1){
            add_action('publish_page', [$this, 'wnokta_nginx_cache_yeni_ve_guncellenen_anasayfa_temizle_snc']);
        }
        // Sayfa yayınlandığında çağır.
        if(isset($ysg) && !empty($ysg) && $ysg == 1){
            add_action('publish_page', [$this, 'wnokta_nginx_cache_yayinlanan_sayfa_temizle']);
        }
        // Sayfa yayınlandığında çağır. sunucu tabanlı
        if(isset($ysgs) && !empty($ysgs) && $ysgs == 1){
            add_action('publish_page', [$this, 'wnokta_nginx_cache_yayinlanan_sayfa_temizle_snc']);
        }
        //Yorum onaylandığında ilgili sayfanın veya yazının önbelleğini temizle
        if(isset($cypa) && !empty($cypa) && $cypa == 1){
            add_action('transition_comment_status', [$this, 'wnokta_nginx_cache_yorum_onay_sayfa_veya_yazi_temizle'], 10, 3);
            add_action('wp_insert_comment', [$this, 'wnokta_nginx_cache_yorum_direk_sayfa_veya_yazi_temizle'], 10, 2);
        }
        //Yorum onaylandığında ilgili sayfanın veya yazının önbelleğini temizle sunucu tabanlı
        if(isset($cypas) && !empty($cypas) && $cypas == 1){
            add_action('transition_comment_status', [$this, 'wnokta_nginx_cache_yorum_onay_sayfa_veya_yazi_temizle'], 10, 3);
            add_action('wp_insert_comment', [$this, 'wnokta_nginx_cache_yorum_direk_sayfa_veya_yazi_temizle'], 10, 2);
        }
        
	}
	// Yazılar ve sayfalar güncelleme veya yayınlama ile önbellek temizlenmesi
	    
    	/*
    	 * Yeni bir yorum yayınlandığında ilgili sayfayı veya yazının ön belleğini temizle
    	 */
	function wnokta_nginx_cache_yorum_direk_sayfa_veya_yazi_temizle($yeni, $comment){
	    if(isset($comment->comment_approved) && $comment->comment_approved == 1){
	        // Önbellek silinecek sayfa veya yazıyı getir ve sil
	        $post_durumu = get_post_type($comment->comment_post_ID);
	        if($post_durumu == "post"){
	            $this->wnokta_nginx_cache_yazi_temizle_islem($comment->comment_post_ID);
	        }else{
	            $this->wnokta_nginx_cache_yayinlanan_sayfa_temizle($comment->comment_post_ID);
	        }
	    }
	}
	function wnokta_nginx_cache_yorum_direk_sayfa_veya_yazi_temizle_snc($yeni, $comment){
	    if(isset($comment->comment_approved) && $comment->comment_approved == 1){
	        // Önbellek silinecek sayfa veya yazıyı getir ve sil sunucu tabanlı
	        $post_durumu = get_post_type($comment->comment_post_ID);
	        if($post_durumu == "post"){
	            $this->wnokta_nginx_cache_yazi_temizle_islem_snc($comment->comment_post_ID);
	        }else{
	            $this->wnokta_nginx_cache_yayinlanan_sayfa_temizle_snc($comment->comment_post_ID);
	        }
	    }
	}
	function wnokta_nginx_cache_yorum_onay_sayfa_veya_yazi_temizle($yeni, $eski, $comment) {
	    if($eski != $yeni) {
	        if($yeni == 'approved') {
	            // Önbellek silinecek sayfa veya yazıyı getir ve sil
	            $post_durumu = get_post_type($comment->comment_post_ID);
	            if($post_durumu == "post"){
	                $this->wnokta_nginx_cache_yazi_temizle_islem($comment->comment_post_ID);
	            }else{
	                $this->wnokta_nginx_cache_yayinlanan_sayfa_temizle($comment->comment_post_ID);
	            }
	        }
	    }
	}
	function wnokta_nginx_cache_yorum_onay_sayfa_veya_yazi_temizle_snc($yeni, $eski, $comment) {
	    if($eski != $yeni) {
	        if($yeni == 'approved') {
	            // Önbellek silinecek sayfa veya yazıyı getir ve sil sunucu tabanlı
	            $post_durumu = get_post_type($comment->comment_post_ID);
	            if($post_durumu == "post"){
	                $this->wnokta_nginx_cache_yazi_temizle_islem_snc($comment->comment_post_ID);
	            }else{
	                $this->wnokta_nginx_cache_yayinlanan_sayfa_temizle_snc($comment->comment_post_ID);
	            }
	        }
	    }
	}
    	/*
    	 * Yazı Eklendiğinde veya güncellendiğinde Ana sayfayı temizle
    	 */
	function wnokta_nginx_cache_yeni_ve_guncellenen_anasayfa_temizle($ID) {
	    //Ana sayfayı temizle yazılım tabanlı
	    if(get_option( 'show_on_front' ) == "posts"){
	        $this->wnokta_nginx_cache_yazilim_onbellek_ayar_temizle("0.14");
	    }else{
	        $ana_sayfa_ID = "a".get_option('page_on_front');
	        $this->wnokta_nginx_cache_yazilim_onbellek_ayar_temizle($ana_sayfa_ID);
	    }
	}
	function wnokta_nginx_cache_yeni_ve_guncellenen_anasayfa_temizle_snc($ID) {
	    //Ana sayfayı temizle sunucu tabanlı
	    $urls = home_url( $path = '/', $scheme = https );
	    $this->wnokta_nginx_cache_sunucu_onbellek_ayar_temizle($urls);
	    $url = home_url( $path = '/', $scheme = http );
	    $this->wnokta_nginx_cache_sunucu_onbellek_ayar_temizle($url);
	}

	    /*
    	 * Yazı Eklendiğinde veya güncellendiğinde
    	 */
	function wnokta_nginx_cache_yeni_ve_guncellenen_yazi_temizle($ID) {
	    //global $wp,$post;
	    global $wpdb;
	    $post_info = get_post($ID);
	    if(isset($post_info->post_status) && $post_info->post_status == "publish"){
	        if ($post_info->post_date != $post_info->post_modified){
	            //Yazı Güncelleme
	            $this->wnokta_nginx_cache_yazi_temizle_islem($ID);
	        }else{
	            $this->wnokta_nginx_cache_yazi_temizle_islem($ID);
	            
	        }
	    }
	    return;
	}
	
	function wnokta_nginx_cache_yeni_ve_guncellenen_yazi_temizle_snc($ID) {
	    //global $wp,$post;
	    global $wpdb;
	    $post_info = get_post($ID);
	    if(isset($post_info->post_status) && $post_info->post_status == "publish"){
	        if ($post_info->post_date != $post_info->post_modified){
	            //Yazı Güncelleme
	            $this->wnokta_nginx_cache_yazi_temizle_islem_snc($ID);
	        }else{
	            $this->wnokta_nginx_cache_yazi_temizle_islem_snc($ID);
	        }
	    }
	    return;
	}
	
	function wnokta_nginx_cache_yazi_temizle_islem_snc($ID) {
	    global $wpdb;
	    $post_info = get_post($ID);
	    $adres = get_permalink($ID);
	    $this->wnokta_nginx_cache_sunucu_onbellek_ayar_temizle($adres."*");
	    
	    // Etiketlerin önbelleklerini sil
	    $postge = get_the_tags($ID);
	    if(isset($postge) && count($postge) > 0){
	        foreach ($postge as $keyT => $KVal) {
	            $adresTag = get_tag_link($postge[$keyT]->term_id);
	            $this->wnokta_nginx_cache_sunucu_onbellek_ayar_temizle($adresTag."*");
            }
	    }
	    
	    //Yazı Kategori temizle
	    $categori = get_the_category($ID);
	    if(isset($categori) && count($categori) > 0){
	        foreach ($categori as $ckeY => $cvaL) {
	            $adresCat = get_tag_link($categori[$ckeY]->cat_ID);
	            $this->wnokta_nginx_cache_sunucu_onbellek_ayar_temizle($adresCat."*");
	        }
	    }
	    
	    //Yazar adresi temizle
	    if(isset($post_info->post_author) && !empty($post_info->post_author)){
	       $this->wnokta_nginx_cache_sunucu_onbellek_ayar_temizle(get_author_posts_url( $post_info->post_author )."*");
	    }
	    
	    //Yazı Arşiv Temizleme
	    if(isset($post_info->post_date) && !empty($post_info->post_date)){
    	    $YIL = date_format(date_create($post_info->post_date), "Y");
    	    $AY = date_format(date_create($post_info->post_date), "m");
    	    $GUN = date_format(date_create($post_info->post_date), "d");
    	    
    	    if(isset($YIL) && isset($AY) && isset($GUN) && !empty($YIL) && !empty($AY) && !empty($GUN)){
    	        $this->wnokta_nginx_cache_sunucu_onbellek_ayar_temizle(get_day_link($YIL, $AY, $GUN)."*");
    	    }  
    	    if(isset($YIL) && isset($AY) && !empty($YIL) && !empty($AY)){
    	       $this->wnokta_nginx_cache_sunucu_onbellek_ayar_temizle(get_month_link($YIL, $AY)."*");
    	    }
    	    if(isset($YIL) && !empty($YIL)){
    	        $this->wnokta_nginx_cache_sunucu_onbellek_ayar_temizle(get_year_link($YIL)."*");
    	    }
	    }	    
	    
	}
	
	function wnokta_nginx_cache_yazi_temizle_islem($ID) {
	    global $wpdb;
	    $post_info = get_post($ID);
	    //sayfalama adet
	    $s_adet = get_option('posts_per_page');
	    //Yeni Yazı //POST	    
	    if(isset($post_info->post_type) && $post_info->post_type == "post"){
	        // Yazı önbelleğini sil
	        $this->wnokta_nginx_cache_yazilim_onbellek_ayar_temizle("po".$ID);
	        $this->wnokta_nginx_cache_yazilim_onbellek_ayar_temizle("po".$post_info->post_name);
	    }
	    
	    // Etiketlerin önbelleklerini sil
	    $postge = get_the_tags($ID);
	    $this->wnokta_nginx_cache_kategori_ve_tag_temizle($postge, "t");
	    
	    //Yazı Kategori temizle
	    $categori = get_the_category($ID);
	    $this->wnokta_nginx_cache_kategori_ve_tag_temizle($categori, "c");
	    
	    $authoR = get_the_author_meta('user_login', $post_info->post_author);
	    if(isset($authoR) && !empty($authoR)){
	        $yaza_cnt = $wpdb->get_results( "SELECT count(post_author) as yazarsay FROM {$wpdb->posts} WHERE post_author = {$post_info->post_author}" );
	        $this->wnokta_nginx_cache_yazilim_onbellek_ayar_temizle("y".$authoR);
	        $this->wnokta_nginx_cache_yazilim_onbellek_ayar_temizle("y".$post_info->post_author);
	        if(isset($yaza_cnt['0']->yazarsay) && $yaza_cnt['0']->yazarsay > $s_adet){
	            for ($i = 1; $i <= $yaza_cnt['0']->yazarsay; $i++) {
	                $this->wnokta_nginx_cache_yazilim_onbellek_ayar_temizle("y".$authoR.$i);
	                $this->wnokta_nginx_cache_yazilim_onbellek_ayar_temizle("y".$post_info->post_author.$i);
	            }
	        }
	    }

	    $YIL = date_format(date_create($post_info->post_date), "Y");
	    $AY = date_format(date_create($post_info->post_date), "m");
	    $GUN = date_format(date_create($post_info->post_date), "d");
	    
	    $yillk = $wpdb->get_results( "SELECT count(ID) as yiladet FROM {$wpdb->posts} WHERE post_date LIKE '{$YIL}-%'" );
	    $aylik = $wpdb->get_results( "SELECT count(ID) as ayadet FROM {$wpdb->posts} WHERE post_date LIKE '{$YIL}-{$AY}-%'" );
	    $gunluk = $wpdb->get_results( "SELECT count(ID) as gunluk FROM {$wpdb->posts} WHERE post_date LIKE '{$YIL}-{$AY}-{$GUN}%'" );
	    
	    //Yıllık Aylık Günlük Arşiv temizle
	    $this->wnokta_nginx_cache_yazilim_onbellek_ayar_temizle("m".$YIL);
	    $this->wnokta_nginx_cache_yazilim_onbellek_ayar_temizle("m".$YIL.$AY);
	    $this->wnokta_nginx_cache_yazilim_onbellek_ayar_temizle("m".$YIL.$AY.$GUN);
	    $sayfala = 0;
	    if(isset($yillk['0']->yiladet) && !empty($yillk['0']->yiladet)){
	        $sayfala = $yillk['0']->yiladet/$s_adet;
	    }
	    if(isset($sayfala) && $sayfala > 0){
	        for ($i = 1; $i <= $sayfala; $i++) {
	            $this->wnokta_nginx_cache_yazilim_onbellek_ayar_temizle("m".$YIL.$i);
	        }
	    }
	    $sayfalaay = 0;
	    if(isset($aylik['0']->ayadet) && !empty($aylik['0']->ayadet)){
	        $sayfalaay = $aylik['0']->ayadet/$s_adet;
	    }
	    if(isset($sayfalaay) && $sayfalaay > 0){
	        for ($i = 1; $i <= $sayfalaay; $i++) {
	            $this->wnokta_nginx_cache_yazilim_onbellek_ayar_temizle("m".$YIL.$AY.$i);
	        }
	    }
	    $sayfalagun = 0;
	    if(isset($gunluk['0']->gunluk) && !empty($gunluk['0']->gunluk)){
	        $sayfalagun = $gunluk['0']->gunluk/$s_adet;
	    }
	    if(isset($sayfalagun) && $sayfalagun > 0){
	        for ($i = 1; $i <= $sayfalagun; $i++) {
	            $this->wnokta_nginx_cache_yazilim_onbellek_ayar_temizle("m".$YIL.$AY.$GUN.$i);
	        }
	    }
	    
	}
	
	function wnokta_nginx_cache_kategori_ve_tag_temizle($arrayD ,$cttg){
	    $s_adet = get_option('posts_per_page');
	    if(isset($arrayD) && !empty($arrayD) ){
	        foreach ($arrayD as $keyC => $valC) {
	            if(isset($arrayD[$keyC]->slug) && !empty($arrayD[$keyC]->slug)){
	                $this->wnokta_nginx_cache_yazilim_onbellek_ayar_temizle($cttg.$arrayD[$keyC]->slug);
	                if(isset($s_adet) && $s_adet < $arrayD[$keyC]->count){
	                    $adet_sayfa = $arrayD[$keyC]->count/$s_adet;
	                    for ($i = 1; $i <= $adet_sayfa; $i++) {
	                        $this->wnokta_nginx_cache_yazilim_onbellek_ayar_temizle($cttg.$arrayD[$keyC]->slug.$i);
	                        $this->wnokta_nginx_cache_yazilim_onbellek_ayar_temizle($cttg.$arrayD[$keyC]->term_id.$i);
	                    }
	                }
	            }
	        }
	    }
	}
	
    	/*
    	 * Yazı Eklendiğinde veya güncellendiğinde
    	 */
	
    	/*
    	 * Sayfa eklendiğinde ve güncellendiğinde 
    	 */
	//Yazılım tabanlı
	function wnokta_nginx_cache_yayinlanan_sayfa_temizle($page_id) {
	    $pages = get_page($page_id);
	    if(isset($pages->post_name) && !empty($pages->post_name)){
	        $this->wnokta_nginx_cache_yazilim_onbellek_ayar_temizle("pa".$page_id);
	        $this->wnokta_nginx_cache_yazilim_onbellek_ayar_temizle("pa".$pages->post_name);
	    }
	    return;
	}
	//Sunucu Tabanlı
	function wnokta_nginx_cache_yayinlanan_sayfa_temizle_snc($page_id) {
	    $sayfa = get_page_link($page_id);
	    if(isset($sayfa) && !empty($sayfa)){
	        $this->wnokta_nginx_cache_sunucu_onbellek_ayar_temizle($sayfa);
	    }
	    return;
	}
    	/*
    	 * Sayfa eklendiğinde ve güncellendiğinde 
    	 */
	// Yazılar ve sayfalar güncelleme veya yayınlama ile önbellek temizlenmesi
	
	// Admin Sol Menüye Ayarlar Menüsü Ekle
	function wnokta_nginx_cache_admin_menu(){
	    //Ana menü
	   add_menu_page(
	        __( 'Sunucu Tabanlı Ayarlar Sayfası', 'wnokta_nginx_cache' ),
	        'WNOKTA NNGINX CACHE',
	        'manage_options',
	        'wnokta_nginx_cache_ayarlar_sayfasi',
	        [$this, 'wnokta_nginx_cache_ayarlar_sayfasi'],
	        plugins_url( 'wnokta_nginx_cache/admin/img/wnokta-icon.png' ),
	        75
	        );
	    add_submenu_page( 'wnokta_nginx_cache_ayarlar_sayfasi', 
	        __( 'Sunucu Tabanlı Ayarlar Sayfası', 'wnokta_nginx_cache' ), 'Sunucu Tabanlı Ayarlar',
	        'manage_options', 'wnokta_nginx_cache_ayarlar_sayfasi');
	    //ikinci menü
	    add_submenu_page( 'wnokta_nginx_cache_ayarlar_sayfasi', 
	                       'Wordpress Yazılım Tabanlı Önbellek Ayarlar Sayfasi', 'Wordpress Tabanlı Önbellek Ayarları',
	        'manage_options', 'wnokta_nginx_cache_onbellek_ayarlar_menu',[$this, 'wnokta_nginx_cache_onbellek_ayarlar_sayfasi']);
	}
	// Admin Sol Menüye Ayarlar Menüsü Ekle
	
	// Admin Üst Menü Temizleme Bağlantıları
	function wnokta_nginx_cache_bar_menu($wp_admin_bar) {
	    $wp_admin_bar->add_node([
	        'id' => 'wnokta_nginx_cache_onbellek_temizleme',
	        'title' => 'WNOKTA NGINX ÖNBELLEK TEMİZLE',
	        'meta' => ['class' => 'first-toolbar-group'],
	    ]);
	    $altMenu = [
	        [
	            'id' => 'wnokta_ngnix_cache_sunucu_tabanli_temizle',
	            'title' => 'Sunucu Tabanlı Önbelleği Temizle',
	            'href' => '#',
	            'meta' => ['class' => 'sunucu_tabanli_temizle_btn'],
	            'parent' => 'wnokta_nginx_cache_onbellek_temizleme'
	        ],
	        [
	            'id' => 'wnokta_ngnix_cache_yazilim_tabanli_temizle',
	            'title' => 'Yazılım Tabanlı Önbelleği Temizle',
	            'href' => '#',
	            'meta' => ['class' => 'yazilim_tabanli_temizle_btn'],
	            'parent' => 'wnokta_nginx_cache_onbellek_temizleme'
	        ]
	    ];
	    foreach ($altMenu as $menu){
	        $wp_admin_bar->add_node($menu);
	    }
	}
	// Admin Üst Menü Temizleme Bağlantıları
	
	//Sunucu Onbellek Ayarlarını Veritabanına Kaydet.
	function wnokta_nginx_cache_sunucu_onbellek_ayar_kayit() {
	    
	    $cPosT = (isset($_POST['wnokta_nginx_cache_post_snc']) && $_POST['wnokta_nginx_cache_post_snc']=='1') ? 1 : 0;
	    $cPosTU = (isset($_POST['wnokta_nginx_cache_post_update_snc']) && $_POST['wnokta_nginx_cache_post_update_snc']=='1') ? 1 : 0;
	    $cPagE = (isset($_POST['wnokta_nginx_cache_page_snc']) && $_POST['wnokta_nginx_cache_page_snc']=='1') ? 1 : 0;
	    $cPagEU = (isset($_POST['wnokta_nginx_cache_page_update_snc']) && $_POST['wnokta_nginx_cache_page_update_snc']=='1') ? 1 : 0;
	    $cComO = (isset($_POST['wnokta_nginx_cache_comment_push_snc']) && $_POST['wnokta_nginx_cache_comment_push_snc']=='1') ? 1 : 0;
	    
	    update_option('wnokta_nginx_cache_post_snc', $cPosT, false);
	    update_option('wnokta_nginx_cache_post_update_snc', $cPosTU, false);
	    update_option('wnokta_nginx_cache_page_snc', $cPagE, false);
	    update_option('wnokta_nginx_cache_page_update_snc', $cPagEU, false);
	    update_option('wnokta_nginx_cache_comment_push_snc', $cComO, false);
	    echo json_encode(['durum' => 'success', 'mesaj' => __('Değişiklikler başarıyla kayıt edildi.', 'wnokta_nginx_cache'), 'dismis' => __('Bu mesajı gizle.', 'wnokta_nginx_cache')]);
	    wp_die();
	}
	//Sunucu Onbellek Ayarlarını Veritabanına Kaydet.
	
	//Yazılım Onbellek Ayarlarını Veritabanına Kaydet.
	function wnokta_nginx_cache_yazilim_onbellek_ayar_kayit() {
	    
	    $htmlziP = (isset($_POST['wnokta_nginx_cache_htmlzip']) && $_POST['wnokta_nginx_cache_htmlzip']=='1') ? 1 : 0;
	    $cssziP = (isset($_POST['wnokta_nginx_cache_cssjszip']) && $_POST['wnokta_nginx_cache_cssjszip']=='1') ? 1 : 0;
	    $cPosT = (isset($_POST['wnokta_nginx_cache_post']) && $_POST['wnokta_nginx_cache_post']=='1') ? 1 : 0;
	    $cPosTU = (isset($_POST['wnokta_nginx_cache_post_update']) && $_POST['wnokta_nginx_cache_post_update']=='1') ? 1 : 0;
	    $cPagE = (isset($_POST['wnokta_nginx_cache_page']) && $_POST['wnokta_nginx_cache_page']=='1') ? 1 : 0;
	    $cPagEU = (isset($_POST['wnokta_nginx_cache_page_update']) && $_POST['wnokta_nginx_cache_page_update']=='1') ? 1 : 0;
	    $cComO = (isset($_POST['wnokta_nginx_cache_comment_push']) && $_POST['wnokta_nginx_cache_comment_push']=='1') ? 1 : 0;

	    update_option('wnokta_nginx_cache_cssjszip', $cssziP, false);
	    update_option('wnokta_nginx_cache_htmlzip', $htmlziP, false);
	    update_option('wnokta_nginx_cache_post', $cPosT, false);
	    update_option('wnokta_nginx_cache_post_update', $cPosTU, false);
	    update_option('wnokta_nginx_cache_page', $cPagE, false);
	    update_option('wnokta_nginx_cache_page_update', $cPagEU, false);
	    update_option('wnokta_nginx_cache_comment_push', $cComO, false);
	    echo json_encode(['durum' => 'success', 'mesaj' => __('Değişiklikler başarıyla kayıt edildi.', 'wnokta_nginx_cache'), 'dismis' => __('Bu mesajı gizle.', 'wnokta_nginx_cache')]);
	    wp_die();
	}
	//Yazılım Onbellek Ayarlarını Veritabanına Kaydet.
	
	//Yazılım Tabanlı Önbellek Temizle
	function wnokta_nginx_cache_yazilim_onbellek_ayar_temizle($id = "") {
	    
	    if(isset($id) && !empty($id)){
	        $dosyaAdi = md5($id);
	        $HTMLYolu = plugin_dir_path( __FILE__ ).'../cache/HTML/'.$dosyaAdi.'.html';
	        @unlink($HTMLYolu);
	    }else{
	        $HTMLYolu = plugin_dir_path( __FILE__ ).'../cache/HTML/';
	        $CSSYolu = plugin_dir_path( __FILE__ ).'../cache/css/min/';
	        $JSYolu = plugin_dir_path( __FILE__ ).'../cache/js/min/';
	        
	        foreach (glob($HTMLYolu.'*') as $Hva){
	            @unlink($Hva);
	        }
	        foreach (glob($CSSYolu.'*') as $Cva){
	            @unlink($Cva);
	        }
	        foreach (glob($JSYolu.'*') as $Jva){
	            @unlink($Jva);
	        }
	        echo json_encode(["durum" => "success", "mesaj" => __('Yazılımsal Önbellek Başarıyla Temizlendi.', 'wnokta_nginx_cache'), "dismis" => __('Bu mesajı gizle.', 'wnokta_nginx_cache')]);
	        wp_die();
	    }
	}
	//Yazılım Tabanlı Önbellek Temizle
	
	//Sunucu Tabanlı Önbellek Temizle
	function wnokta_nginx_cache_sunucu_onbellek_ayar_temizle($adres = "") {
	    if(isset($adres) && !empty($adres)){
	        $url_parca = wp_parse_url( $adres );
	        $sorgU = (isset($url_parca['query']) && !empty($url_parca['query'])) ? $url_parca['query'] : "";
	        $yoLu = (isset($url_parca['path']) && !empty($url_parca['path'])) ? $url_parca['path'] : "";
	        $response = wp_remote_get($url_parca['scheme']."://".$url_parca['host']."/purge".$yoLu.$sorgU, ['sslverify' => false]);
	        if ( $response['response']['code'] ) {
	            switch ( $response['response']['code'] ) {
	                case 200:
	                    $this->gunluk( '- - ' . $adres . ' *** TEMIZLENDI ***' );
	                    break;
	                case 412:
	                    $this->gunluk( '- - ' . $adres . ' bir önbellek yok' );
	                    break;
	                default:
	                    $this->gunluk( '- - ' . $adres . ' bulunamadı ( ' . $response['response']['code'] . ' )', 'UYARI' );  
	            }
	        }
	    }else{
            $urls = home_url( $path = '/', $scheme = https );
            $url = home_url( $path = '/', $scheme = http );
            $responses = wp_remote_get($urls."purge/*", ['sslverify' => false]);
            $response = wp_remote_get($url."purge/*", ['sslverify' => false]);
            echo json_encode(["durum" => "success", "mesaj" => __('Sunucu Önbellek Başarıyla Temizlendi.', 'wnokta_nginx_cache'), "dismis" => __('Bu mesajı gizle.', 'wnokta_nginx_cache')]);
            if ( $responses['response']['code'] ) {
                switch ( $responses['response']['code'] ) {
                    case 200:
                        $this->gunluk( '- - ' . $adres . ' *** TEMIZLENDI ***' );
                        break;
                    case 412:
                        $this->gunluk( '- - ' . $adres . ' bir önbellek yok' );
                        break;
                    default:
                        $this->gunluk( '- - ' . $adres . ' bulunamadı ( ' . $responses['response']['code'] . ' )', 'UYARI' );
                }
            }
            if ( $response['response']['code'] ) {
                switch ( $response['response']['code'] ) {
                    case 200:
                        $this->gunluk( '- - ' . $adres . ' *** TEMIZLENDI ***' );
                        break;
                    case 412:
                        $this->gunluk( '- - ' . $adres . ' bir önbellek yok' );
                        break;
                    default:
                        $this->gunluk( '- - ' . $adres . ' bulunamadı ( ' . $response['response']['code'] . ' )', 'UYARI' );
                }
            }
            wp_die();
	    }
	}
	//Sunucu Tabanlı Önbellek Temizle
	
	// Sunucu tabanlı Ayarlar sayfası
	function wnokta_nginx_cache_ayarlar_sayfasi(){
	    require_once (__DIR__).'/partials/wnokta_nginx_cache-admin-ayarlar.php';
	}
	// Sunucu tabanlı Ayarlar sayfası
	
	// Yazılım Tabanlı Önbellek Ayarlar sayfası
	function wnokta_nginx_cache_onbellek_ayarlar_sayfasi(){
	    require_once (__DIR__).'/partials/wnokta_nginx_cache-admin-onbellek-ayarlar.php';
	}
	// Yazılım Tabanlı Önbellek Ayarlar sayfası
	
	public function gunluk( $msj, $durum = "BILGI" ) {
	    $fp = fopen(plugin_dir_path( __FILE__ ).'../cache/HTML/log.txt', 'a+' );
	        if ( $fp ) {
	            fwrite( $fp, "\n" . gmdate( 'Y-m-d H:i:s ' ) . ' | ' . $durum . ' | ' . $msj );
	            fclose( $fp );
	        }
	    return true;
	}
	
	
	
	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wnokta_nginx_cache-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wnokta_nginx_cache-admin-sunucu-onbellek-ayarlari.js', array( 'jquery' ), $this->version, false );

	}

}
