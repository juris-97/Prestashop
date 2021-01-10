<?php /*%%SmartyHeaderCode:18082607645ff1f6eb068f50-46168854%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '121553ed3b258ed028ec3ff9130087f5c0c85b1d' => 
    array (
      0 => '/var/www/html/prestashop/themes/default-bootstrap/modules/blocktopmenu/blocktopmenu.tpl',
      1 => 1478514348,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18082607645ff1f6eb068f50-46168854',
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5ff1ff8ad4ec77_60861757',
  'has_nocache_code' => false,
  'cache_lifetime' => 31536000,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ff1ff8ad4ec77_60861757')) {function content_5ff1ff8ad4ec77_60861757($_smarty_tpl) {?>	<!-- Menu -->
	<div id="block_top_menu" class="sf-contener clearfix col-lg-12">
		<div class="cat-title">Zakładki</div>
		<ul class="sf-menu clearfix menu-content">
			<li><a href="https://localhost/prestashop/index.php?id_category=18&amp;controller=category" title="architektura">architektura</a></li><li><a href="https://localhost/prestashop/index.php?id_category=19&amp;controller=category" title="krajobraz">krajobraz</a><ul><li><a href="https://localhost/prestashop/index.php?id_category=20&amp;controller=category" title="morze">morze</a></li><li><a href="https://localhost/prestashop/index.php?id_category=21&amp;controller=category" title="niebo">niebo</a></li></ul></li><li><a href="https://localhost/prestashop/index.php?id_category=22&amp;controller=category" title="astrofotografia">astrofotografia</a></li><li><a href="https://localhost/prestashop/index.php?id_category=23&amp;controller=category" title="makro">makro</a></li>
							<li class="sf-search noBack" style="float:right">
					<form id="searchbox" action="https://localhost/prestashop/index.php?controller=search" method="get">
						<p>
							<input type="hidden" name="controller" value="search" />
							<input type="hidden" value="position" name="orderby"/>
							<input type="hidden" value="desc" name="orderway"/>
							<input type="text" name="search_query" value="" />
						</p>
					</form>
				</li>
					</ul>
	</div>
	<!--/ Menu -->
<?php }} ?>
