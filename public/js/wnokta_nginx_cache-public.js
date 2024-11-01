jQuery(function( $ ) {
	'use strict';
	
	$('.sunucu_tabanli_temizle_btn').on('click',function(){
		var ajaxurl = benim_ajax_object.ajax_url;
		jQuery.post(
				ajaxurl, 
				{
					'action': 'wnokta_nginx_cache_sunucu_onbellek_temizle',
				}, 
				function(response) {
					var returnedData = JSON.parse(response);
					if(returnedData.durum == 'success'){
						jQuery('#wpbody-content').prepend('<div id="message" class="updated notice is-dismissible basariliC"><p>'+returnedData.mesaj+'</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">'+returnedData.dismis+'</span></button></div>');
						$('.notice-dismiss').on('click',function(){
							$('.basariliC').hide();
						});
					}
					console.log('The server responded: ', response);
				}
		);
		
	});
	$('.yazilim_tabanli_temizle_btn').on('click',function(){
		var ajaxurl = benim_ajax_object.ajax_url;
		jQuery.post(
				ajaxurl, 
				{
					'action': 'wnokta_nginx_cache_yazilim_onbellek_temizle',
				}, 
				function(response) {
					var returnedData = JSON.parse(response);
					if(returnedData.durum == 'success'){
						jQuery('#wpbody-content').prepend('<div id="message" class="updated notice is-dismissible basariliC"><p>'+returnedData.mesaj+'</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">'+returnedData.dismis+'</span></button></div>');
						$('.notice-dismiss').on('click',function(){
							$('.basariliC').hide();
						});
					}
					console.log('The server responded: ', response);
				}
		);
		
	});
});