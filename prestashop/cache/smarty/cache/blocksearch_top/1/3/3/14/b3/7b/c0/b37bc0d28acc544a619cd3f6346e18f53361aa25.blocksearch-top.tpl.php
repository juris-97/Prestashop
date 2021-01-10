<?php /*%%SmartyHeaderCode:13972959385ff1f6eabf2956-60904324%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b37bc0d28acc544a619cd3f6346e18f53361aa25' => 
    array (
      0 => '/var/www/html/prestashop/themes/default-bootstrap/modules/blocksearch/blocksearch-top.tpl',
      1 => 1478514348,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13972959385ff1f6eabf2956-60904324',
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5ff1ff8ac87eb2_71074610',
  'has_nocache_code' => false,
  'cache_lifetime' => 31536000,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ff1ff8ac87eb2_71074610')) {function content_5ff1ff8ac87eb2_71074610($_smarty_tpl) {?><!-- Block search module TOP -->
<div id="search_block_top" class="col-sm-4 clearfix">
	<form id="searchbox" method="get" action="//localhost/prestashop/index.php?controller=search" >
		<input type="hidden" name="controller" value="search" />
		<input type="hidden" name="orderby" value="position" />
		<input type="hidden" name="orderway" value="desc" />
		<input class="search_query form-control" type="text" id="search_query_top" name="search_query" placeholder="Szukaj" value="" />
		<button type="submit" name="submit_search" class="btn btn-default button-search">
			<span>Szukaj</span>
		</button>
	</form>
</div>
<!-- /Block search module TOP --><?php }} ?>
