<?php
/* Smarty version 3.1.34-dev-7, created on 2020-09-23 17:51:20
  from 'C:\Users\Administrator\Desktop\学习\php-mvc\app\View\Index\index.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5f6b1a98e63608_17013073',
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
  'cache_lifetime' => 2,
),true)) {
function content_5f6b1a98e63608_17013073 (Smarty_Internal_Template $_smarty_tpl) {
?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script type="text/javascript" src="<?php echo '<?php ';?>
echo ROOT_PUBLIC_PATH <?php echo '?>';?>
/static/js/jquery.js"></script>
    <script type="text/javascript">
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
    </script>
</head>
<body>
1600854680
<form method="POST">
    <input type="text" name="username" id="" />
    <input type="password" name="password" />
    <input type="submit" value="提交" />
</form>
</body>
</html><?php }
}
