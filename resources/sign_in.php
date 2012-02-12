<?php
/**
 * ${PROJECT_NAME} user sign in page
 *
 * @since
 * @author
 */
?>
<div style="margin-top:50px">
    <form name="SignIn" method="post" action="<?php echo URI; ?>">
        <table width="50%" cellpadding="5" cellspacing="5" align="center">
            <tr>
                <td valign="middle" align="right" width="39%">
                    <!-- Tips: Introduction on the left -->
                    <div>
                        <span class="page-title">${PROJECT_NAME}</span>
                    </div>
                </td>
                <td width="1%" height="180" background="<?php echo IMG_DIR; ?>verticaldots.gif"></td>
                <td width="60%" valign="middle">
                    <?php echo NUCLEUS_Exceptions::showError(); ?>
                    <!-- Tips: Remove the next line when you are ready to meddle with the codings -->
                    <div align="center" class="section-title">Yes! Let's start coding</div>
                    <table width="100%" cellpadding="7" cellspacing="0" bgcolor="#b1e2f0">
                        <tr>
                            <td colspan="2" class="page-title">Sign In Here</td>
                        </tr>
                        <tr>
                            <td class="label">Username</td>
                            <td class="field"><input class="default" type="text" name="username" /></td>
                        </tr>
                        <tr>
                            <td class="label">Password</td>
                            <td class="field"><input class="default" type="password" name="pwd" /></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">
                                <?php
                                echo $element->button('sign_in', 'Sign In', true);
                                echo $element->getFormControllers('authenticate');
                                ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </form>
</div>