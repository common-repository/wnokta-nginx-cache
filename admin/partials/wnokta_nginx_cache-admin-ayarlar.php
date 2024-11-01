<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       wnokta.com/bb
 * @since      1.0.0
 *
 * @package    Wnokta_nginx_cache
 * @subpackage Wnokta_nginx_cache/admin/partials
 */
$GcPosT = !get_option('wnokta_nginx_cache_post_snc') ? '' : get_option('wnokta_nginx_cache_post_snc');
$GcPosTU = !get_option('wnokta_nginx_cache_post_update_snc') ? '' : get_option('wnokta_nginx_cache_post_update_snc');
$GcPagE = !get_option('wnokta_nginx_cache_page_snc') ? '' : get_option('wnokta_nginx_cache_page_snc');
$GcPagEU = !get_option('wnokta_nginx_cache_page_update_snc') ? '' : get_option('wnokta_nginx_cache_page_update_snc');
$GcComO = !get_option('wnokta_nginx_cache_comment_push_snc') ? '' : get_option('wnokta_nginx_cache_comment_push_snc');
?>
<header>
	<h2><?=__('NGINX Sunucu tabanlı önbellek temizleme ayarları.','wnokta_nginx_cache');?></h2>
</header>
	<table class="form-table" role="presentation">
		<tbody>
			<tr>
				<th scope="row"><?=__('Sunucu Tabanlı Önbellek Güncelleme Ayarları','wnokta_nginx_cache');?></th>
				<td><fieldset>
						<label for="wnokta_nginx_cache_post_snc"> <input
							name="wnokta_nginx_cache_post_snc" type="checkbox"
							id="wnokta_nginx_cache_post_snc" value="1" <?=($GcPosT==1)?'checked="checked"':'';?>> <?=__('Yeni bir yazı yayımlandığında veya güncellendiğinde Ana sayfanın önbelleğini temizle.','wnokta_nginx_cache');?>
						</label> <br> <label for="wnokta_nginx_cache_post_update_snc"> <input
							name="wnokta_nginx_cache_post_update_snc" type="checkbox"
							id="wnokta_nginx_cache_post_update_snc" value="1" <?=($GcPosTU==1)?'checked="checked"':'';?>> <?=__('Yeni bir yazı yayımlandığı veya güncellendiği sayfaya ait önbelleği temizle.','wnokta_nginx_cache');?>
						</label> <br>
					</fieldset></td>
			</tr>
			<tr>
				<th scope="row"></th>
				<td><fieldset>
						<label for="wnokta_nginx_cache_page_snc"> <input
							name="wnokta_nginx_cache_page_snc" type="checkbox"
							id="wnokta_nginx_cache_page_snc" value="1" <?=($GcPagE==1)?'checked="checked"':'';?>> <?=__('Yeni bir sayfa yayınlandığında Ana sayfanın önbelleğini temizle.','wnokta_nginx_cache');?>
						</label> <br> <label for="wnokta_nginx_cache_page_update_snc"> <input
							name="wnokta_nginx_cache_page_update_snc" type="checkbox"
							id="wnokta_nginx_cache_page_update_snc" value="1"  <?=($GcPagEU==1)?'checked="checked"':'';?>> <?=__('Yeni bir sayfa yayımlandığında veya güncellendiğinde sayfanın önbelleğini temizle.','wnokta_nginx_cache');?>
						</label> <br> <label for="wnokta_nginx_cache_comment_push_snc"> <input
							name="wnokta_nginx_cache_comment_push_snc" type="checkbox"
							id="wnokta_nginx_cache_comment_push_snc" value="1" <?=($GcComO==1)?'checked="checked"':'';?>> <?=__('Yeni bir yorum yayımlandığında ilgili yorumun bulunduğu sayfa veya yazının önbelleğini temzile.','wnokta_nginx_cache');?>
						</label> <br>
					</fieldset></td>
			</tr>
		</tbody>
	</table>

	<h2 class="title"><?=__('Dikkat!','wnokta_nginx_cache');?></h2>

	<p><?=__('Bu eklenti yalnızca WNOKTA Hosting hizmeti alan web sitelerinde çalışmaktadır.','wnokta_nginx_cache');?></p>
	<p class="submit">
		<button class="button button-primary sunucu_ayarlari_kaydet"><?=__('Değişiklikleri kaydet','wnokta_nginx_cache');?></button>
	</p>
