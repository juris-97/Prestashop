<?php /*%%SmartyHeaderCode:14455824485ff202ffed3b09-29869085%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2aad7d87069119770077c5842d98a121e15e5433' => 
    array (
      0 => '/var/www/html/prestashop/themes/default-bootstrap/modules/blocksupplier/blocksupplier.tpl',
      1 => 1478514348,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14455824485ff202ffed3b09-29869085',
  'variables' => 
  array (
    'display_link_supplier' => 0,
    'link' => 0,
    'suppliers' => 0,
    'text_list' => 0,
    'text_list_nb' => 0,
    'supplier' => 0,
    'form_list' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5ff203000194c0_39753848',
  'cache_lifetime' => 31536000,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ff203000194c0_39753848')) {function content_5ff203000194c0_39753848($_smarty_tpl) {?>
<!-- Block suppliers module -->
<div id="suppliers_block_left" class="block blocksupplier">
	<p class="title_block">
					<a href="https://localhost/prestashop/index.php?controller=supplier" title="Dostawcy">
					Dostawcy
					</a>
			</p>
	<div class="block_content list-block">
								<ul>
											<li class="first_item">
                					<a 
					href="https://localhost/prestashop/index.php?id_supplier=3&amp;controller=supplier" 
					title="Więcej o DHL">
				                DHL
                					</a>
                				</li>
															<li class="last_item">
                					<a 
					href="https://localhost/prestashop/index.php?id_supplier=2&amp;controller=supplier" 
					title="Więcej o Poczta Polska">
				                Poczta Polska
                					</a>
                				</li>
										</ul>
										<form action="/prestashop/index.php" method="get">
					<div class="form-group selector1">
						<select class="form-control" name="supplier_list">
							<option value="0">Wszyscy dostawcy</option>
													<option value="https://localhost/prestashop/index.php?id_supplier=3&amp;controller=supplier">DHL</option>
													<option value="https://localhost/prestashop/index.php?id_supplier=2&amp;controller=supplier">Poczta Polska</option>
												</select>
					</div>
				</form>
						</div>
</div>
<!-- /Block suppliers module -->
<?php }} ?>
