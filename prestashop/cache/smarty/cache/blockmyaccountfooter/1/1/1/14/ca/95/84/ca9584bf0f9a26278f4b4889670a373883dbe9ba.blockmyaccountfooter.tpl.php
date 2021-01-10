<?php /*%%SmartyHeaderCode:19390183955ff1f6eb8c98b2-05730110%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ca9584bf0f9a26278f4b4889670a373883dbe9ba' => 
    array (
      0 => '/var/www/html/prestashop/themes/default-bootstrap/modules/blockmyaccountfooter/blockmyaccountfooter.tpl',
      1 => 1478514348,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19390183955ff1f6eb8c98b2-05730110',
  'variables' => 
  array (
    'link' => 0,
    'returnAllowed' => 0,
    'voucherAllowed' => 0,
    'HOOK_BLOCK_MY_ACCOUNT' => 0,
    'is_logged' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5ff1f6eb9404e0_08172314',
  'cache_lifetime' => 31536000,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ff1f6eb9404e0_08172314')) {function content_5ff1f6eb9404e0_08172314($_smarty_tpl) {?>
<!-- Block myaccount module -->
<section class="footer-block col-xs-12 col-sm-4">
	<h4><a href="https://localhost/prestashop/index.php?controller=my-account" title="Zarządzaj moim kontem klienta" rel="nofollow">Moje konto</a></h4>
	<div class="block_content toggle-footer">
		<ul class="bullet">
			<li><a href="https://localhost/prestashop/index.php?controller=history" title="Moje zamówienia" rel="nofollow">Moje zamówienia</a></li>
						<li><a href="https://localhost/prestashop/index.php?controller=order-slip" title="Moje rachunki" rel="nofollow">Moje rachunki</a></li>
			<li><a href="https://localhost/prestashop/index.php?controller=addresses" title="Moje adresy" rel="nofollow">Moje adresy</a></li>
			<li><a href="https://localhost/prestashop/index.php?controller=identity" title="Zarządzaj moimi informacjami osobistymi" rel="nofollow">Moje informacje osobiste</a></li>
						
            		</ul>
	</div>
</section>
<!-- /Block myaccount module -->
<?php }} ?>
