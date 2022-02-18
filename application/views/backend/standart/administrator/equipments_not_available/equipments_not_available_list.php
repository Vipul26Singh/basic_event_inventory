<style>
.chosen-container
{
    width: 100% !important;
}
</style>

<script src="<?= BASE_ASSET; ?>/js/jquery.hotkeys.js"></script>

<script type="text/javascript">
//This page is a result of an autogenerated content made by running test.html with firefox.
function domo(){
 
	// Binding keys

   $('*').bind('keydown', 'Ctrl+f', function assets() {
       $('#sbtn').trigger('click');
       return false;
   });

   $('*').bind('keydown', 'Ctrl+x', function assets() {
       $('#reset').trigger('click');
       return false;
   });

   $('*').bind('keydown', 'Ctrl+b', function assets() {

       $('#reset').trigger('click');
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
      Equipments Not Available<small><?= cclang('list_all'); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Equipments Not Available</li>
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
		     <div class="row pull-right">
						<?php 
				$get_params = '';
				foreach ($_GET as $name => $value) {
   	 				$get_params .= $name . '=' . $value . '&amp;';
				}

				if(!empty($get_params)) {
					$get_params = rtrim($get_params, "&amp;");
				}
			?>
						 <?php is_allowed('equipments_not_available_export', function() use ($get_params) {?>
                        <a class="btn btn-flat btn-success" title="<?= cclang('export'); ?> Equipments Not Available" href="<?= site_url('administrator/equipments_not_available/export?'.$get_params); ?>"><i class="fa fa-file-excel-o" ></i> <?= cclang('export'); ?> XLS</a>
                        <?php }) ?>
                        <?php is_allowed('equipments_not_available_export', function() use ($get_params) {?>
                        <a class="btn btn-flat btn-success" title="<?= cclang('export'); ?> pdf Equipments Not Available" href="<?= site_url('administrator/equipments_not_available/export_pdf?'.$get_params); ?>"><i class="fa fa-file-pdf-o" ></i> <?= cclang('export'); ?> PDF</a>
			<?php }) ?>
			                     </div>
                     <div class="widget-user-image">
                        <img class="img-circle" src="<?= BASE_ASSET; ?>/img/list.png" alt="User Avatar">
                     </div>
                     <!-- /.widget-user-image -->
                     <h3 class="widget-user-username">Equipments Not Available</h3>
                     <h5 class="widget-user-desc"><?= cclang('list_all', ['Equipments Not Available']); ?>  <i class="label bg-yellow"><?= $equipments_not_available_counts; ?>  <?= cclang('items'); ?></i></h5>
                  </div>

		<div class="widget-user-header " >
			<button class="btn btn-sm btn-danger btn-raised show_form_filter" id="has_form_filter" style="display: none;"> <i class="fa fa-plus"> </i> Show Filter</button>		
			<button class="btn btn-sm btn-success btn-raised show_form_filter" style="display: none;"> <i class="fa fa-minus"> </i> Hide Filter</button>
		</div>

		<div class="widget-user-header " id="advance_form_filter" style="display: none;">
			<form name="form_filter_equipments_not_available" id="form_filter_equipments_not_available" action="<?= base_url('administrator/equipments_not_available/index'); ?>" method="get">
				<div class="col-sm-12">
																					<div class="col-sm-6">
                                                			<div class="form-group ">
									<label class="col-sm-4 control-label">Equipment Name</label>
                                                        		<div class="col-sm-8">
									<input type="text" class="form-control" name="equipment_name" value="<?= !empty($_GET['equipment_name']) ? $_GET['equipment_name']:' ' ?>"></input>
									</div>
									</div>
									</div>
																													<div class="col-sm-6">
                                                			<div class="form-group ">
									<label class="col-sm-4 control-label">Equipment Condition</label>
                                                        		<div class="col-sm-8">
									<input type="text" class="form-control" name="equipment_condition" value="<?= !empty($_GET['equipment_condition']) ? $_GET['equipment_condition']:' ' ?>"></input>
									</div>
									</div>
									</div>
																													<div class="col-sm-6">
                                                			<div class="form-group ">
									<label class="col-sm-4 control-label">Equipment Size</label>
                                                        		<div class="col-sm-8">
									<input type="text" class="form-control" name="equipment_size" value="<?= !empty($_GET['equipment_size']) ? $_GET['equipment_size']:' ' ?>"></input>
									</div>
									</div>
									</div>
																													<div class="col-sm-6">
                                                			<div class="form-group ">
									<label class="col-sm-4 control-label">Equipment Description</label>
                                                        		<div class="col-sm-8">
									<input type="text" class="form-control" name="equipment_description" value="<?= !empty($_GET['equipment_description']) ? $_GET['equipment_description']:' ' ?>"></input>
									</div>
									</div>
									</div>
																													<div class="col-sm-6">
                                                			<div class="form-group ">
									<label class="col-sm-4 control-label">Equipment Barcode</label>
                                                        		<div class="col-sm-8">
									<input type="text" class="form-control" name="equipment_barcode" value="<?= !empty($_GET['equipment_barcode']) ? $_GET['equipment_barcode']:' ' ?>"></input>
									</div>
									</div>
									</div>
																				<div class="col-sm-6">
                                                                        <div class="form-group ">
                                                                        <label class="col-sm-4 control-label">Equipment Category Id</label>
                                                                        <div class="col-sm-8">
                                                                        <input type="number" class="form-control" name="equipment_category_id" value="<?= !empty($_GET['equipment_category_id']) ? $_GET['equipment_category_id']:' ' ?>"></input>
                                                                        </div>
                                                                        </div>
                                                                        </div>

																												</div>


				<br>
								<div class="col-sm-12">
                                	<div class="col-sm-4">
                                		<button type="submit" class="btn btn-block btn-md btn-success btn-raised pull-left" value="Apply" title="Refining Search"> <i class="fa fa-filter"></i> Filter</button>
                                	</div>
					<div class="col-sm-4"></div>
					<div class="col-sm-4">
						<a class="btn btn-danger btn-block btn-md btn-raised pull-right" value="Reset" href="<?= base_url('administrator/equipments_not_available');?>" title="<?= cclang('reset_filter'); ?>">
                        				<i class="fa fa-undo"></i> Reset Filter 
                        			</a>
					</div>

                        	</div>
							</form>

		</div>

		 <div class="widget-user-header ">
                                <ul class="nav nav-pills">
		
                                
                				<?php if(!empty($_GET['go_back'])) { ?>
					<a class="btn btn-sm btn-success" href="#" onclick="goBack()"><?= $_GET['go_back']; ?></a>
				<?php } ?>
				 </ul>
                        </div>


                  <form name="form_equipments_not_available" id="form_equipments_not_available" action="<?= base_url('administrator/equipments_not_available/index'); ?>">
                  

                  <div class="table-responsive"> 
                  <table class="table table-bordered table-striped dataTable">
                     <thead>
			<tr class="">
				                           <th>Equipment Name</th>
			   <th>Equipment Condition</th>
			   <th>Equipment Size</th>
			   <th>Equipment Description</th>
			   <th>Equipment Barcode</th>
			   <th>Equipment Category Id</th>
			   <th>Equipment Image</th>
			   				                        </tr>
                     </thead>
                     <tbody id="tbody_equipments_not_available">
                     <?php foreach($equipments_not_availables as $equipments_not_available): ?>
			<tr>

				                           
                           <td><?= _ent($equipments_not_available->equipment_name); ?></td> 
                           <td><?= _ent($equipments_not_available->equipment_condition); ?></td> 
                           <td><?= _ent($equipments_not_available->equipment_size); ?></td> 
                           <td><?= _ent($equipments_not_available->equipment_description); ?></td> 
                           <td><?= _ent($equipments_not_available->equipment_barcode); ?></td> 
                           <td><?= _ent($equipments_not_available->equipment_category_id); ?></td> 
                           <td>
                              <?php if (!empty($equipments_not_available->equipment_image)): ?>
                                <?php if (is_image($equipments_not_available->equipment_image)): ?>
                                <a class="fancybox" rel="group" href="<?= BASE_URL . 'uploads/equipments/' . $equipments_not_available->equipment_image; ?>">
                                  <img src="<?= BASE_URL . 'uploads/equipments/' . $equipments_not_available->equipment_image; ?>" class="image-responsive" alt="image equipments_not_available" title="equipment_image equipments_not_available" width="40px">
                                </a>
                                <?php else: ?>
                                  <a href="<?= BASE_URL . 'administrator/file/download/equipments/' . $equipments_not_available->equipment_image; ?>">
                                   <img src="<?= get_icon_file($equipments_not_available->equipment_image); ?>" class="image-responsive image-icon" alt="image equipments_not_available" title="equipment_image <?= $equipments_not_available->equipment_image; ?>" width="40px"> 
                                 </a>
                                <?php endif; ?>
                              <?php endif; ?>
                           </td>
                            
                           			                        </tr>
                      <?php endforeach; ?>
                      <?php if ($equipments_not_available_counts == 0) :?>
                         <tr>
                           <td colspan="100">
                           Equipments Not Available data is not available
                           </td>
                         </tr>
                      <?php endif; ?>
                     </tbody>
                  </table>
                  </div>
               </div>
               <hr>
               <!-- /.widget-user -->
               <div class="row">
		  <div class="col-md-8">
			                  </div>
                  </form>                  <div class="col-md-4">
                     <div class="dataTables_paginate paging_simple_numbers pull-right" id="example2_paginate" >
                        <?= $pagination; ?>
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

<!-- Page script -->
<script>
  $(document).ready(function(){

			$('#has_form_filter').show();
    		$('.show_form_filter').click(function(){
			$('.show_form_filter').toggle();
			$('#advance_form_filter').slideToggle();
		});
	   
    $('.remove-data').click(function(){

      var url = $(this).attr('data-href');

      swal({
          title: "<?= cclang('are_you_sure'); ?>",
          text: "<?= cclang('data_to_be_deleted_can_not_be_restored'); ?>",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "<?= cclang('yes_delete_it'); ?>",
          cancelButtonText: "<?= cclang('no_cancel_plx'); ?>",
          closeOnConfirm: true,
          closeOnCancel: true
        },
        function(isConfirm){
          if (isConfirm) {
            document.location.href = url;            
          }
        });

      return false;
    });


	$('#sbtn').click(function(){
                var q = $('#filter').val();
                var f = $('#field').val();
                window.location.replace(BASE_URL + '/administrator/equipments_not_available/index?q=' + q + '&f=' + f);
                return false; 
        });


    $('#apply').click(function(){

      var bulk = $('#bulk');
      var serialize_bulk = $('#form_equipments_not_available').serialize();

      if (bulk.val() == 'delete') {
         swal({
            title: "<?= cclang('are_you_sure'); ?>",
            text: "<?= cclang('data_to_be_deleted_can_not_be_restored'); ?>",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "<?= cclang('yes_delete_it'); ?>",
            cancelButtonText: "<?= cclang('no_cancel_plx'); ?>",
            closeOnConfirm: true,
            closeOnCancel: true
          },
          function(isConfirm){
            if (isConfirm) {
               document.location.href = BASE_URL + '/administrator/equipments_not_available/delete?' + serialize_bulk;      
            }
          });

        return false;

      } else if(bulk.val() == '')  {
          swal({
            title: "Upss",
            text: "<?= cclang('please_choose_bulk_action_first'); ?>",
            type: "warning",
            showCancelButton: false,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Okay!",
            closeOnConfirm: true,
            closeOnCancel: true
          });

        return false;
      }

      return false;

    });/*end appliy click*/


    //check all
    var checkAll = $('#check_all');
    var checkboxes = $('input.check');

    checkAll.on('ifChecked ifUnchecked', function(event) {   
        if (event.type == 'ifChecked') {
            checkboxes.iCheck('check');
        } else {
            checkboxes.iCheck('uncheck');
        }
    });

    checkboxes.on('ifChanged', function(event){
        if(checkboxes.filter(':checked').length == checkboxes.length) {
            checkAll.prop('checked', 'checked');
        } else {
            checkAll.removeProp('checked');
        }
        checkAll.iCheck('update');
    });

  }); /*end doc ready*/
</script>