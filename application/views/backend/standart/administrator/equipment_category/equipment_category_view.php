<?php
        $query_string = $_SERVER['QUERY_STRING'];
?>


<script src="<?= BASE_ASSET; ?>/js/jquery.hotkeys.js"></script>
<script type="text/javascript">
//This page is a result of an autogenerated content made by running test.html with firefox.
function domo(){
 
   // Binding keys
   $('*').bind('keydown', 'Ctrl+e', function assets() {
      $('#btn_edit').trigger('click');
       return false;
   });

   $('*').bind('keydown', 'Ctrl+x', function assets() {
      $('#btn_back').trigger('click');
       return false;
   });
    
}


jQuery(document).ready(domo);

function goBack() {
    window.history.back();
}


</script>
<!-- Content Header (Page header) -->
<section class="content-header">
   <h1>
      Equipment Category      <small><?= cclang('detail', ['Equipment Category']); ?> </small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class=""><a  href="<?= site_url('administrator/equipment_category?'.$query_string); ?>">Equipment Category</a></li>
      <li class="active"><?= cclang('detail'); ?></li>
   </ol>
</section>
<!-- Main content -->
<section class="content">
   <div class="row" >
     
      <div class="col-md-12">
         <div class="box box-warning">
            <div class="box-body ">

               <!-- Widget: user widget style 1 -->
               <div class="box box-widget widget-user-2">
                  <!-- Add the bg color to the header using any of the bg-* classes -->
                  <div class="widget-user-header ">
                    
                     <div class="widget-user-image">
                        <img class="img-circle" src="<?= BASE_ASSET; ?>/img/view.png" alt="User Avatar">
                     </div>
                     <!-- /.widget-user-image -->
                     <h3 class="widget-user-username">Equipment Category</h3>
                     <h5 class="widget-user-desc">Detail Equipment Category</h5>
                     <hr>
                  </div>


		<div class="widget-user-header ">
                                <ul class="nav nav-pills">
		
				
					<?php if(!empty($_GET['go_back'])) { ?>
                                        <a class="btn btn-sm btn-success" href="#" onclick="goBack()"><?= $_GET['go_back']; ?></a>
                                <?php } ?>
                                 </ul>
                        </div>




                 
                  <div class="form-horizontal" name="form_equipment_category" id="form_equipment_category" >
                   
                    <div class="form-group ">
                        <label for="content" class="col-sm-2">Id </label>

                        <div class="col-sm-8">
                           <?= _ent($equipment_category->id); ?>
                        </div>
                    </div>
                                         
                    <div class="form-group ">
                        <label for="content" class="col-sm-2"> Image </label>
                        <div class="col-sm-8">
                             <?php if (is_image($equipment_category->image)): ?>
                              <a class="fancybox" rel="group" href="<?= BASE_URL . 'uploads/equipment_category/' . $equipment_category->image; ?>">
                                <img src="<?= BASE_URL . 'uploads/equipment_category/' . $equipment_category->image; ?>" class="image-responsive" alt="image equipment_category" title="image equipment_category" width="40px">
                              </a>
                              <?php else: ?>
                              <label>
                                <a href="<?= BASE_URL . 'administrator/file/download/equipment_category/' . $equipment_category->image; ?>">
                                 <img src="<?= get_icon_file($equipment_category->image); ?>" class="image-responsive" alt="image equipment_category" title="image <?= $equipment_category->image; ?>" width="40px"> 
                               <?= $equipment_category->image ?>
                               </a>
                               </label>
                              <?php endif; ?>
                        </div>
                    </div>
                                       
                    <div class="form-group ">
                        <label for="content" class="col-sm-2">Name </label>

                        <div class="col-sm-8">
                           <?= _ent($equipment_category->name); ?>
                        </div>
                    </div>
                                        
                    <br>
                    <br>

                    <div class="view-nav">
                        <?php is_allowed('equipment_category_update', function() use ($equipment_category){?>
                        <a class="btn btn-flat btn-info btn_edit btn_action" id="btn_edit" data-stype='back' title="edit equipment_category (Ctrl+e)" href="<?= site_url('administrator/equipment_category/edit/'.$equipment_category->id); ?>"><i class="fa fa-edit" ></i> <?= cclang('update'); ?> </a>
                        <?php }) ?>
                        <a class="btn btn-flat btn-default btn_action" id="btn_back" title="back (Ctrl+x)" href="<?= site_url('administrator/equipment_category/'); ?>"><i class="fa fa-undo" ></i> <?= cclang('go_back_button'); ?></a>
                     </div>
                    
                  </div>
               </div>
            </div>
            <!--/box body -->
         </div>
         <!--/box -->

      </div>
   </div>
</section>
<!-- /.content -->
