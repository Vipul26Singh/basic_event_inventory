<?php
if (!defined('BASEPATH')) {exit('No direct script access allowed');}
ob_start();
?>
<!-- begin zigaform code -->
<div id="uifm_container_<?php echo $id_form ;?>" class="uiform-wrap"><img src="<?php echo $base_url;?>assets/frontend/images/loader-form.gif"></div>
<script type="text/javascript">
    var UIFORM_WWW = "<?php echo $site_url;?>";
    var UIFORM_SRC = "<?php echo $base_url;?>";
    var _uifmvar = _uifmvar || {};
    _uifmvar.fm_ids = _uifmvar.fm_ids || [];
    _uifmvar.fm_ids.push(['<?php echo $id_form;?>']);
    
    <?php 
    
       if(isset($lmode) && $lmode!=''){
                switch (intval($lmode)) {
                        case 1:
                            /*iframe*/
                            ?>
                             _uifmvar.fm_loadmode = "iframe";   
                                <?php
                            break;
                    }
            }
    ?>
    
    
    <?php 
     if(intval($onload_scroll)===1){
    ?>
        _uifmvar.fm_onload_scroll = "1";
     <?php } ?>   
     <?php if(intval($preload_noconflict)===1){
             ?>
       _uifmvar.fm_preload_noconflict = "1";         
     <?php }?>
         
         
    (function(){var uiform = document.createElement('script');
        uiform.type = 'text/javascript';
        uiform.async = true;
        uiform.src = ('https:' == document.location.protocol ? UIFORM_SRC : UIFORM_SRC) + 'assets/frontend/js/init.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(uiform, s);})();
</script>
<noscript>
       Powered by <a href="http://zigaform.com/?uifm_v=<?php echo model_settings::$db_config['version']; ?>&uifm_source=wpzphpfb&uifm_medium=widget" title="PHP Form Builder & Contact " >ZigaForm version <?php echo model_settings::$db_config['version']; ?></a>
</noscript>
<!-- end zigaform code -->
<?php
$cntACmp = ob_get_contents();
$cntACmp = str_replace("\n", '', $cntACmp);
$cntACmp = str_replace("\t", '', $cntACmp);
$cntACmp = str_replace("\r", '', $cntACmp);
$cntACmp = str_replace("//-->", ' ', $cntACmp);
$cntACmp = str_replace("//<!--", ' ', $cntACmp);
$cntACmp = Uiform_Form_Helper::sanitize_output($cntACmp);
ob_end_clean();
echo $cntACmp;
?>