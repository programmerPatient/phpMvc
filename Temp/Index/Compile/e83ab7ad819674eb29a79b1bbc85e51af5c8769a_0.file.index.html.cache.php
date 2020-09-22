<?php
/* Smarty version 3.1.34-dev-7, created on 2020-09-22 16:53:47
  from 'C:\Users\Administrator\Desktop\学习\php-mvc\app\View\Index\index.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5f69bb9bd04312_40710953',
  'has_nocache_code' => true,
  'file_dependency' => 
  array (
    'e83ab7ad819674eb29a79b1bbc85e51af5c8769a' => 
    array (
      0 => 'C:\\Users\\Administrator\\Desktop\\学习\\php-mvc\\app\\View\\Index\\index.html',
      1 => 1600764470,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f69bb9bd04312_40710953 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '13483722675f69bb9bcbbeb4_40401550';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo '/*%%SmartyNocache:13483722675f69bb9bcbbeb4_40401550%%*/<?php echo \'<?php \';?>
/*/%%SmartyNocache:13483722675f69bb9bcbbeb4_40401550%%*/';?>
echo ROOT_PUBLIC_PATH <?php echo '/*%%SmartyNocache:13483722675f69bb9bcbbeb4_40401550%%*/<?php echo \'?>\';?>
/*/%%SmartyNocache:13483722675f69bb9bcbbeb4_40401550%%*/';?>
/static/js/jquery.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript">
        $(function(){
            $('from').submit(function(){
                event.preventDefault();
                $.ajax({
                    url:'<?php echo '/*%%SmartyNocache:13483722675f69bb9bcbbeb4_40401550%%*/<?php echo \'<?php \';?>
/*/%%SmartyNocache:13483722675f69bb9bcbbeb4_40401550%%*/';?>
echo __APP__ <?php echo '/*%%SmartyNocache:13483722675f69bb9bcbbeb4_40401550%%*/<?php echo \'?>\';?>
/*/%%SmartyNocache:13483722675f69bb9bcbbeb4_40401550%%*/';?>
',
                });
            });
        });
    <?php echo '</script'; ?>
>
</head>
<body>
<?php echo $_smarty_tpl->tpl_vars['var']->value;?>

<form method="POST">
    <input type="text" name="username" id="" />
    <input type="password" name="password" />
    <input type="submit" value="提交" />
</form>
</body>
</html><?php }
}
