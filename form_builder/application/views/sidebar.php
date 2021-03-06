<?php
/**
 * Sidebar
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_Form_Builder
 * @author    Softdiscover <info@softdiscover.com>
 * @copyright 2013 Softdiscover
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   CVS: $Id: sidebar.php, v2.00 2013-11-30 02:52:40 Softdiscover $
 * @link      http://php-form-builder.zigaform.com/
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
?>
<div class="sidebar-wrap">
   <ul class="nav navbar-nav side-nav">
    <li class="nav-profile">
        <div class="user_profile clearfix">
        <img alt="" src="https://www.gravatar.com/avatar/<?php echo md5(strtolower(trim(model_settings::$db_config['admin_mail']))); ?>?s=50">
        <h5><?php echo $this->session->userdata("use_login");?></h5>
    </div>
    </li>
            <li><a href="<?php echo site_url(); ?>formbuilder/forms/list_uiforms"><i class="fa fa-th-list"></i> <?php echo __('Forms','FRocket_admin'); ?></a></li>
            <li><a href="<?php echo site_url(); ?>user/intranet/index"><i class="fa fa-user"></i> <?php echo __('Users','FRocket_admin'); ?></a></li>
            <li><a href="<?php echo site_url(); ?>default/intranet/settings"><i class="fa fa-wrench"></i> <?php echo __('Settings','FRocket_admin'); ?></a></li>
            
          </ul> 
</div>


