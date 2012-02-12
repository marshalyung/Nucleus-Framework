<?php
/**
 * ${PROJECT_NAME} application main controller
 *
 * @since
 * @author
 */

require_once 'config/bootstrap.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>${PROJECT_NAME}</title>
<link type="text/css" rel="stylesheet" href="<?php echo CSS_DIR; ?>default.css" />
<script type="text/javascript" src="<?php echo JS_DIR; ?>modernizr-1.7.min.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo JS_DIR; ?>jquery-ui-1.8.11.custom/css/smoothness/jquery-ui-1.8.11.custom.css" />
<script type="text/javascript" src="<?php echo JS_DIR; ?>jquery-ui-1.8.11.custom/js/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="<?php echo JS_DIR; ?>jquery-ui-1.8.11.custom/js/jquery-ui-1.8.11.custom.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_DIR; ?>common.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_DIR; ?>validation.js"></script>
</head>
<body class="body-wrapper">
    <table width="100%" cellpadding="0" cellspacing="0" background="<?php echo IMG_DIR; ?>header_bg.jpg">
        <tr valign="top">
            <td height="50">
                <div style="float:left; padding:5px"><span class="page-title" style="color:#ffffff">${PROJECT_NAME}</span></div>
                <?php if ($auth->isAuthenticated()) : ?>
                <div class="normal" align="right" style="margin:5px; color:#ffffff">
                    <!-- Tips: Put administrative links here. These links would appear on the top right hand corner -->
                </div>
                <?php endif; ?>
            </td>
        </tr>
        <?php if ($auth->isAuthenticated()) : ?>
        <tr>
            <td>
                <!-- Tips: Put module tabs here as main menus. -->
            </td>
        </tr>
        <tr>
            <td class="submenu-horizontal">
                <!-- Tips: Put module submenus here as secondary menus. -->
            </td>
        </tr>
        <?php endif; ?>
    </table>
    <table width="100%" cellpadding="10" cellspacing="0">
        <tr valign="top">
            <?php if ($auth->isAuthenticated()) : ?>
            <td style="border-right:1px solid #cccccc">
                <div id="show_error"></div>
                <!-- Tips: This is here the respective module's page view is loaded -->
                <?php include NUCLEUS_Core::loadModuleController(); ?>
            </td>
            <?php else : ?>
            <td align="center">
                <!-- Tips: The sign in page -->
                <?php include 'sign_in.php'; ?>
            </td>
            <?php endif; ?>
        </tr>
    </table>
    <div class="footer-wrapper" align="center">
        <!-- Tips: Put footer statement here -->
    </div>
</body>
<script type="text/javascript" language="javascript">
document.getElementById("show_error").innerHTML = '<?php echo NUCLEUS_Exceptions::showError(); ?>';
</script>
</html>