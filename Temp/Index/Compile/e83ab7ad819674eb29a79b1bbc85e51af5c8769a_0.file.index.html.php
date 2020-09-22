<?php
/* Smarty version 3.1.34-dev-7, created on 2020-09-22 16:47:53
  from 'C:\Users\Administrator\Desktop\学习\php-mvc\app\View\Index\index.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5f69ba3965efd9_63331802',
  'has_nocache_code' => false,
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
function content_5f69ba3965efd9_63331802 (Smarty_Internal_Template $_smarty_tpl) {
?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo '<?php ';?>
echo ROOT_PUBLIC_PATH <?php echo '?>';?>
/static/js/jquery.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript">
        $(function(){
            $('from').submit(function(){
                event.preventDefault();
                $.ajax({
                    url:'<?php echo '<?php ';?>
echo __APP__ <?php echo '?>';?>
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
