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
$GhtmlziP = !get_option('wnokta_nginx_cache_htmlzip') ? '' : get_option('wnokta_nginx_cache_htmlzip');
$GcssziP = !get_option('wnokta_nginx_cache_cssjszip') ? '' : get_option('wnokta_nginx_cache_cssjszip');
$GcPosT = !get_option('wnokta_nginx_cache_post') ? '' : get_option('wnokta_nginx_cache_post');
$GcPosTU = !get_option('wnokta_nginx_cache_post_update') ? '' : get_option('wnokta_nginx_cache_post_update');
$GcPagE = !get_option('wnokta_nginx_cache_page') ? '' : get_option('wnokta_nginx_cache_page');
$GcPagEU = !get_option('wnokta_nginx_cache_page_update') ? '' : get_option('wnokta_nginx_cache_page_update');
$GcComO = !get_option('wnokta_nginx_cache_comment_push') ? '' : get_option('wnokta_nginx_cache_comment_push');
?>
<header>
	<h2><?=__('Wordpress HTML ve CSS Sıkıştırma ve Birleştirme Ayarları','wnokta_nginx_cache');?></h2>
</header>
	<table class="form-table" role="presentation">
		<tbody>
			<tr>
				<th scope="row"><?=__('Yazılımsal Önbellek Ayarları','wnokta_nginx_cache');?></th>
				<td><fieldset>
						<label for="wnokta_nginx_cache_cssjszip"> <input
							name="wnokta_nginx_cache_cssjszip" type="checkbox"
							id="wnokta_nginx_cache_cssjszip" value="1" <?=($GcssziP==1)?'checked="checked"':'';?>> <?=__('CSS ve JS Dosyalarını Birleştir ve Sıkıştır.','wnokta_nginx_cache');?>
						</label> <br> <label for="wnokta_nginx_cache_htmlzip"> <input
							name="wnokta_nginx_cache_htmlzip" type="checkbox"
							id="wnokta_nginx_cache_htmlzip" value="1" <?=($GhtmlziP==1)?'checked="checked"':'';?>> <?=__('HTML Kodlarını sıkıştır ve Önbelleğe Al (Kullanıcı ve Yönetici girişi yapmış kullanıcılar için uygulanmaz.)','wnokta_nginx_cache');?>
						</label> <br>
						<p class="description"><?=__('(Bu ayarlar sitenizde görünüm bozukluklarına neden olabilir. Özellikleri devre dışı bırakıp önbelleği temizleyeerek bu sorunu aşabilirsiniz.)','wnokta_nginx_cache');?></p>
					</fieldset></td>
			</tr>
			<tr>
				<th scope="row"><?=__('Önbellek Güncelleme Ayarları','wnokta_nginx_cache');?></th>
				<td><fieldset>
						<label for="wnokta_nginx_cache_post"> <input
							name="wnokta_nginx_cache_post" type="checkbox"
							id="wnokta_nginx_cache_post" value="1" <?=($GcPosT==1)?'checked="checked"':'';?>> <?=__('Yeni bir yazı yayımlandığında veya güncellendiğinde Ana sayfanın önbelleğini temizle.','wnokta_nginx_cache');?>
						</label> <br> <label for="wnokta_nginx_cache_post_update"> <input
							name="wnokta_nginx_cache_post_update" type="checkbox"
							id="wnokta_nginx_cache_post_update" value="1" <?=($GcPosTU==1)?'checked="checked"':'';?>> <?=__('Yeni bir yazı yayımlandığı veya güncellendiği sayfaya ait önbelleği temizle.','wnokta_nginx_cache');?>
						</label> <br>
					</fieldset></td>
			</tr>
			<tr>
				<th scope="row"></th>
				<td><fieldset>
						<label for="wnokta_nginx_cache_page"> <input
							name="wnokta_nginx_cache_page" type="checkbox"
							id="wnokta_nginx_cache_page" value="1" <?=($GcPagE==1)?'checked="checked"':'';?>> <?=__('Yeni bir sayfa yayınlandığında Ana sayfanın önbelleğini temizle.','wnokta_nginx_cache');?>
						</label> <br> <label for="wnokta_nginx_cache_page_update"> <input
							name="wnokta_nginx_cache_page_update" type="checkbox"
							id="wnokta_nginx_cache_page_update" value="1"  <?=($GcPagEU==1)?'checked="checked"':'';?>> <?=__('Yeni bir sayfa yayımlandığında veya güncellendiğinde sayfanın önbelleğini temizle.','wnokta_nginx_cache');?>
						</label> <br> <label for="wnokta_nginx_cache_comment_push"> <input
							name="wnokta_nginx_cache_comment_push" type="checkbox"
							id="wnokta_nginx_cache_comment_push" value="1" <?=($GcComO==1)?'checked="checked"':'';?>> <?=__('Yeni bir yorum yayımlandığında ilgili yorumun bulunduğu sayfa veya yazının önbelleğini temzile.','wnokta_nginx_cache');?>
						</label> <br>
					</fieldset></td>
			</tr>
		</tbody>
	</table>

	<h2 class="title"><?=__('Dikkat!','wnokta_nginx_cache');?></h2>

	<p><?=__('Eklentimiz şu an için deneysel olup diğer önbellekleme eklentileri ile birlikte kullanımlarda sorunlara neden olabilir.','wnokta_nginx_cache');?></p>
	<p class="submit">
		<button class="button button-primary yazilim_ayarlari_kaydet"><?=__('Değişiklikleri kaydet','wnokta_nginx_cache');?></button>
	</p>

