<?php
/**
 * Layout login
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_Form_Builder
 * @author    Softdiscover <info@softdiscover.com>
 * @copyright 2013 Softdiscover
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   CVS: $Id: layout-login.php, v2.00 2013-11-30 02:52:40 Softdiscover $
 * @link      http://php-form-builder.zigaform.com/
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo model_settings::$db_config['site_title']; ?> </title>
    <meta name="googlebot" content="noindex">
    <meta name="robots" content="noindex">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Softdiscover Company">
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/common/img/favicon.ico" type="image/x-icon"/>
    <!-- jquery ui -->
    <link href="<?php echo base_url(); ?>assets/common/js/jqueryui/1.10.3/themes/start/jquery-ui.min.css" rel="stylesheet">
    <!-- bootstrap -->
    <link href="<?php echo base_url(); ?>assets/common/js/bootstrap/3.2.0/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/common/js/bootstrap/3.2.0/bootstrap-theme.css" rel="stylesheet">
    <!-- font awesome -->
    <link href="<?php echo base_url(); ?>assets/common/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom fonts -->
    <link href="<?php echo base_url(); ?>assets/backend/css/custom/style.css" rel="stylesheet">
    <!-- animate -->
    <link href="<?php echo base_url(); ?>assets/backend/css/animate.css" rel="stylesheet">
    <!-- jasny bootstrap -->
    <link href="<?php echo base_url(); ?>assets/common/js/bjasny/jasny-bootstrap.css" rel="stylesheet">
    <!-- jscrollpane -->
    <link href="<?php echo base_url(); ?>assets/backend/js/jscrollpane/jquery.jscrollpane.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/backend/js/jscrollpane/jquery.jscrollpane.lozenge.css" rel="stylesheet">
    <!-- chosen -->
    <link href="<?php echo base_url(); ?>assets/backend/js/chosen/chosen.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/backend/js/chosen/style.css" rel="stylesheet">
    <!-- color picker -->
    <link href="<?php echo base_url(); ?>assets/backend/js/colorpicker/bootstrap-colorpicker.css" rel="stylesheet">
    <!-- bootstrap select -->
    <link href="<?php echo base_url(); ?>assets/backend/js/bselect/bootstrap-select.css" rel="stylesheet">
    <!-- bootstrap switch -->
    <link href="<?php echo base_url(); ?>assets/backend/js/bswitch/bootstrap-switch.css" rel="stylesheet">
    <!-- bootstrap slider -->
    <link href="<?php echo base_url(); ?>assets/backend/js/bslider/4.10.4/bootstrap-slider.min.css" rel="stylesheet">
    <!-- bootstrap touchspin -->
    <link href="<?php echo base_url(); ?>assets/backend/js/btouchspin/jquery.bootstrap-touchspin.css" rel="stylesheet">
    <!-- bootstrap icon picker -->
    <link href="<?php echo base_url(); ?>assets/backend/js/biconpicker/bootstrap-iconpicker.css" rel="stylesheet">
    <!-- bootstrap date time picker -->
    <link href="<?php echo base_url(); ?>assets/backend/js/bdatetime/bootstrap-datetimepicker.css" rel="stylesheet">
    <!-- star rating -->
    <link href="<?php echo base_url(); ?>assets/backend/js/bratestar/star-rating.css" rel="stylesheet">
    <!-- data tables -->
    <link href="<?php echo base_url(); ?>assets/backend/js/bdatatable/1.10.9/jquery.dataTables.css" rel="stylesheet">
    <!-- morris -->
    <link href="<?php echo base_url(); ?>assets/backend/js/graph/morris.css" rel="stylesheet">
    <!-- introjs -->
    <link href="<?php echo base_url(); ?>assets/backend/js/introjs/introjs.css" rel="stylesheet">
    <!-- blueimp gallery min -->
    <link href="<?php echo base_url(); ?>assets/common/js/blueimp/2.16.0/css/blueimp-gallery.min.css" rel="stylesheet">
    <!-- blueimp image gallery -->
    <link href="<?php echo base_url(); ?>assets/common/js/bgallery/3.1.3/css/bootstrap-image-gallery.css" rel="stylesheet">
    
    
    <link href="<?php echo base_url(); ?>assets/backend/css/admin-css.css" rel="stylesheet">
    <link rel="Favicon Icon" href="favicon.ico">
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    
    
    
    <script type="text/javascript"  src="<?php echo base_url(); ?>assets/common/js/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/common/js/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <!-- Bootstrap -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/common/js/bootstrap/3.2.0/bootstrap.min.js"></script>
    <!-- jasny bootstrap -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/common/js/bjasny/jasny-bootstrap.js"></script>
    <!-- md5 -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/backend/js/md5.js"></script>
    <!-- morris -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/backend/js/graph/morris.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/backend/js/graph/raphael-min.js"></script>
    <!-- retina -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/backend/js/retina.js"></script>
    <!-- mousewheel -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/backend/js/jscrollpane/jquery.mousewheel.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/backend/js/jscrollpane/jquery.jscrollpane.min.js"></script>
    <!-- chosen -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/backend/js/chosen/chosen.jquery.min.js"></script>
    <!-- color picker mode -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/backend/js/colorpicker/bootstrap-colorpicker-mod.js"></script>
    <!-- bootstrap select -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/backend/js/bselect/bootstrap-select.js"></script>
    <!-- bootstrap switch -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/backend/js/bswitch/bootstrap-switch.js"></script>
    <!-- bootstrap slider -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/backend/js/bslider/4.10.4/bootstrap-slider.min.js"></script>
    <!-- bootstrap touchspin -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/backend/js/btouchspin/jquery.bootstrap-touchspin.js"></script>
    <!-- date time -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/backend/js/bdatetime/moment-with-locales.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/backend/js/bdatetime/bootstrap-datetimepicker.js"></script>
    <!-- auto grow -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/backend/js/jquery.autogrow-textarea.js"></script>
    <!-- bootstrap iconpicker -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/backend/js/biconpicker/bootstrap-iconpicker.js"></script>
    <!-- star rating -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/backend/js/bratestar/star-rating.js"></script>
    <!-- data tables -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/backend/js/bdatatable/1.10.9/jquery.dataTables.js"></script>
    <!-- bootbox -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/backend/js/bootbox/bootbox.js"></script>
    <!-- intro -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/backend/js/introjs/intro.js"></script>
    <!-- blueimp gallery  -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/common/js/blueimp/2.16.0/js/blueimp-gallery.min.js"></script>
    <!-- blueimp image gallery  -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/common/js/bgallery/3.1.3/js/bootstrap-image-gallery.js"></script>
    <!-- lz string -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/backend/js/lzstring/lz-string.min.js"></script>
    <!-- tiny mce-->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/backend/js/tinymce/4.3.3/tinymce.min.js"></script>
     
    
    <script type='text/javascript'>
    var rockfm_vars={"ajaxurl":"",
        "uifm_baseurl":"<?php echo base_url(); ?>",
        "uifm_siteurl":"<?php echo site_url(); ?>",
        "uifm_sfm_baseurl":"<?php echo base_url(); ?>libs/styles-font-menu/styles-fonts/png/",
        "imagesurl":"<?php echo base_url(); ?>assets/frontend/images"};
   <?php 
   
   $file1 = base_url() . 'extensions/elfinder/elfinder.php?XSRFToken=' . getXSRFToken('elFinder');
   $file2 = base_url() . 'extensions/elfinder/elfinder2.php?XSRFToken=' . getXSRFToken('elFinder');     
   ?> 
    var uiform_vars={"url_admin":"<?php echo site_url(); ?>admin",
        "url_plugin":"",
        "url_elfinder1":"<?php echo $file1;?>",
        "url_elfinder2":"<?php echo $file2;?>",
        "app_version":"",
        "url_assets":"<?php echo base_url(); ?>assets",
        "csrf_field_name":"<?php echo $this->security->get_csrf_hash(); ?>"
        };
    </script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/backend/js/admin-js.js"></script>
  <!--- frontend -->
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/backend/js/js_global_frontend.js?<?php echo date("Ymdgis");?>"></script>
     <?php 
     elFinder_tinymce();
     ?>
    <script type="text/javascript">
 
       
       tinymce.init({
                selector: '.uifm_tinymce_obj',
                theme: "modern",
                menubar: false,
                height: 200,
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media contextmenu paste code'
                ],
                relative_urls : false,
                remove_script_host : false,
                convert_urls : true,
                browser_spellcheck : true ,
                codemirror: {
                indentOnInit: true, // Whether or not to indent code on init.
                path: 'CodeMirror'
                },
                image_advtab: true,
                toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
                toolbar2: "| image | media | link unlink anchor | forecolor backcolor | print preview code | youtube | qrcode | flickr | picasa ",
                file_browser_callback : elFinderBrowser,
                setup: function (ed) {
                        ed.on('change KeyUp', function(e) {
                            rocketform.captureEventTinyMCE(ed,e);
                        });
                    }
                });
              
       
                 
    
    </script>
   
  </head>
   <body class="tundra">
    
    <div id="wrapper">

      <!-- Sidebar -->
      <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <?php $this->load->view('header'); ?>   
      </nav>

      <div id="page-wrapper">
         <div id="rocketform-bk-dashboard" style="display:none;" >

            <div id="rocketform-bk-header">
                <?php include('header-uiform.php');?>
            </div>
            <div id="rocketform-bk-content">
                <div id="uiform-panel-loadingst">
            <div class="uifm-loader-header-wrap">
                <div class="icon-uifm-logo-black"></div>
                <div class="uifm-loader-header-1"></div>
            </div>
        </div>
                <?php echo $content;?>

            </div>
            <div id="rocketform-bk-footer">
                <?php include('footer.php');?>
            </div>
        </div>
        <?php include('captions.php');?> 

      </div><!-- /#page-wrapper -->

    </div><!-- /#wrapper -->

  </body>
</html>