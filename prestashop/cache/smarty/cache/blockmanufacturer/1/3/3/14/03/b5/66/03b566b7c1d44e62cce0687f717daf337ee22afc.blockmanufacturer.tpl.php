<?php /*%%SmartyHeaderCode:20030742095ff202ffa31b93-49717062%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '03b566b7c1d44e62cce0687f717daf337ee22afc' => 
    array (
      0 => '/var/www/html/prestashop/themes/default-bootstrap/modules/blockmanufacturer/blockmanufacturer.tpl',
      1 => 1478514348,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20030742095ff202ffa31b93-49717062',
  'variables' => 
  array (
    'display_link_manufacturer' => 0,
    'link' => 0,
    'manufacturers' => 0,
    'text_list' => 0,
    'text_list_nb' => 0,
    'manufacturer' => 0,
    'form_list' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5ff202ffae94d9_72703533',
  'cache_lifetime' => 31536000,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ff202ffae94d9_72703533')) {function content_5ff202ffae94d9_72703533($_smarty_tpl) {?>
<!-- Block manufacturers module -->
<div id="manufacturers_block_left" class="block blockmanufacturer">
	<p class="title_block">
					<a href="https://localhost/prestashop/index.php?controller=manufacturer" title="Producenci">
						Producenci
					</a>
			</p>
	<div class="block_content list-block">
								<ul>
														<li class="first_item">
						<a 
						href="https://localhost/prestashop/index.php?id_manufacturer=3&amp;controller=manufacturer" title="Około FOTO STUDIO 21">
							FOTO STUDIO 21
						</a>
					</li>
																			<li class="last_item">
						<a 
						href="https://localhost/prestashop/index.php?id_manufacturer=2&amp;controller=manufacturer" title="Około ONEGOG">
							ONEGOG
						</a>
					</li>
												</ul>
										<form action="/prestashop/index.php" method="get">
					<div class="form-group selector1">
						<select class="form-control" name="manufacturer_list">
							<option value="0">Wszyscy producenci</option>
													<option value="https://localhost/prestashop/index.php?id_manufacturer=3&amp;controller=manufacturer">FOTO STUDIO 21</option>
													<option value="https://localhost/prestashop/index.php?id_manufacturer=2&amp;controller=manufacturer">ONEGOG</option>
												</select>
					</div>
				</form>
						</div>
</div>
<!-- /Block manufacturers module -->
<?php }} ?>
