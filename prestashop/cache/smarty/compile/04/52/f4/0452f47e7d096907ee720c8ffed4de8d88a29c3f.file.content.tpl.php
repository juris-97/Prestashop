<?php /* Smarty version Smarty-3.1.19, created on 2021-01-07 00:34:10
         compiled from "/var/www/html/prestashop/admin105nicae0/themes/default/template/content.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10092013795ff648f2b2fc29-75630009%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0452f47e7d096907ee720c8ffed4de8d88a29c3f' => 
    array (
      0 => '/var/www/html/prestashop/admin105nicae0/themes/default/template/content.tpl',
      1 => 1478514344,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10092013795ff648f2b2fc29-75630009',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'content' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5ff648f2b3ca35_37606682',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ff648f2b3ca35_37606682')) {function content_5ff648f2b3ca35_37606682($_smarty_tpl) {?>
<div id="ajax_confirmation" class="alert alert-success hide"></div>

<div id="ajaxBox" style="display:none"></div>


<div class="row">
	<div class="col-lg-12">
		<?php if (isset($_smarty_tpl->tpl_vars['content']->value)) {?>
			<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

		<?php }?>
	</div>
</div><?php }} ?>
