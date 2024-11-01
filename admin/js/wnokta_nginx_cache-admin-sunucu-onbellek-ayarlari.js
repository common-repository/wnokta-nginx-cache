jQuery(function( $ ) {
	'use strict';
	
	$('.sunucu_tabanli_temizle_btn').on('click',function(){
		
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
	$('.sunucu_ayarlari_kaydet').on('click',function(){
		
		var wnokta_nginx_cache_post_snc = $('#wnokta_nginx_cache_post_snc:checkbox:checked').val();
		var wnokta_nginx_cache_post_update_snc = $('#wnokta_nginx_cache_post_update_snc:checkbox:checked').val();
		var wnokta_nginx_cache_page_snc = $('#wnokta_nginx_cache_page_snc:checkbox:checked').val();
		var wnokta_nginx_cache_page_update_snc = $('#wnokta_nginx_cache_page_update_snc:checkbox:checked').val();
		var wnokta_nginx_cache_comment_push_snc = $('#wnokta_nginx_cache_comment_push_snc:checkbox:checked').val();

		jQuery.post(
				ajaxurl, 
				{
					'action': 'wnokta_nginx_cache_sunucu_onbellek_ayar',
					'wnokta_nginx_cache_post_snc':   wnokta_nginx_cache_post_snc,
					'wnokta_nginx_cache_post_update_snc':   wnokta_nginx_cache_post_update_snc,
					'wnokta_nginx_cache_page_snc':   wnokta_nginx_cache_page_snc,
					'wnokta_nginx_cache_page_update_snc':   wnokta_nginx_cache_page_update_snc,
					'wnokta_nginx_cache_comment_push_snc':   wnokta_nginx_cache_comment_push_snc,
				}, 
				function(response) {
					var returnedData = JSON.parse(response);
					if(returnedData.durum == 'success'){
						jQuery('#wpbody-content').prepend('<div id="message" class="updated notice is-dismissible basarili"><p>'+returnedData.mesaj+'</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">'+returnedData.dismis+'</span></button></div>');
						$('.notice-dismiss').on('click',function(){
							$('.basarili').hide();
						});
					}
					console.log('The server responded: ', response);
				}
		);
		
	});
	$('.yazilim_ayarlari_kaydet').on('click',function(){
		
		var wnokta_nginx_cache_cssjszip = $('#wnokta_nginx_cache_cssjszip:checkbox:checked').val();
		var wnokta_nginx_cache_htmlzip = $('#wnokta_nginx_cache_htmlzip:checkbox:checked').val();
		var wnokta_nginx_cache_post = $('#wnokta_nginx_cache_post:checkbox:checked').val();
		var wnokta_nginx_cache_post_update = $('#wnokta_nginx_cache_post_update:checkbox:checked').val();
		var wnokta_nginx_cache_page = $('#wnokta_nginx_cache_page:checkbox:checked').val();
		var wnokta_nginx_cache_page_update = $('#wnokta_nginx_cache_page_update:checkbox:checked').val();
		var wnokta_nginx_cache_comment_push = $('#wnokta_nginx_cache_comment_push:checkbox:checked').val();
		
		jQuery.post(
				ajaxurl, 
				{
					'action': 'wnokta_nginx_cache_yazilim_onbellek_ayar',
					'wnokta_nginx_cache_htmlzip':   wnokta_nginx_cache_htmlzip,
					'wnokta_nginx_cache_cssjszip':   wnokta_nginx_cache_cssjszip,
					'wnokta_nginx_cache_post':   wnokta_nginx_cache_post,
					'wnokta_nginx_cache_post_update':   wnokta_nginx_cache_post_update,
					'wnokta_nginx_cache_page':   wnokta_nginx_cache_page,
					'wnokta_nginx_cache_page_update':   wnokta_nginx_cache_page_update,
					'wnokta_nginx_cache_comment_push':   wnokta_nginx_cache_comment_push,
				}, 
				function(response) {
					var returnedData = JSON.parse(response);
					if(returnedData.durum == 'success'){
						jQuery('#wpbody-content').prepend('<div id="message" class="updated notice is-dismissible basarili"><p>'+returnedData.mesaj+'</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">'+returnedData.dismis+'</span></button></div>');
						$('.notice-dismiss').on('click',function(){
							$('.basarili').hide();
						});
					}
					console.log('The server responded: ', response);
				}
		);
		
	});



});
