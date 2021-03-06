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
   $('*').bind('keydown', 'Ctrl+a', function assets() {
       window.location.href = BASE_URL + '/administrator/Equipment_category/add';
       return false;
   });

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
      Equipment Category<small><?= cclang('list_all'); ?></small>
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Equipment Category</li>
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
			                        <?php is_allowed('equipment_category_add', function(){?>
                        <a class="btn btn-flat btn-success btn_add_new" id="btn_add_new" title="<?= cclang('add_new_button', ['Equipment Category']); ?>  (Ctrl+a)" href="<?=  site_url('administrator/equipment_category/add'); ?>"><i class="fa fa-plus-square-o" ></i> <?= cclang('add_button'); ?></a>
                        <?php }) ?>
									<?php 
				$get_params = '';
				foreach ($_GET as $name => $value) {
   	 				$get_params .= $name . '=' . $value . '&amp;';
				}

				if(!empty($get_params)) {
					$get_params = rtrim($get_params, "&amp;");
				}
			?>
						 <?php is_allowed('equipment_category_export', function() use ($get_params) {?>
                        <a class="btn btn-flat btn-success" title="<?= cclang('export'); ?> Equipment Category" href="<?= site_url('administrator/equipment_category/export?'.$get_params); ?>"><i class="fa fa-file-excel-o" ></i> <?= cclang('export'); ?> XLS</a>
                        <?php }) ?>
                        <?php is_allowed('equipment_category_export', function() use ($get_params) {?>
                        <a class="btn btn-flat btn-success" title="<?= cclang('export'); ?> pdf Equipment Category" href="<?= site_url('administrator/equipment_category/export_pdf?'.$get_params); ?>"><i class="fa fa-file-pdf-o" ></i> <?= cclang('export'); ?> PDF</a>
			<?php }) ?>
			                     </div>
                     <div class="widget-user-image">
                        <img class="img-circle" src="<?= BASE_ASSET; ?>/img/list.png" alt="User Avatar">
                     </div>
                     <!-- /.widget-user-image -->
                     <h3 class="widget-user-username">Equipment Category</h3>
                     <h5 class="widget-user-desc"><?= cclang('list_all', ['Equipment Category']); ?>  <i class="label bg-yellow"><?= $equipment_category_counts; ?>  <?= cclang('items'); ?></i></h5>
                  </div>

		<div class="widget-user-header " >
			<button class="btn btn-sm btn-danger btn-raised show_form_filter" id="has_form_filter" style="display: none;"> <i class="fa fa-plus"> </i> Show Filter</button>		
			<button class="btn btn-sm btn-success btn-raised show_form_filter" style="display: none;"> <i class="fa fa-minus"> </i> Hide Filter</button>
		</div>

		<div class="widget-user-header " id="advance_form_filter" style="display: none;">
			<form name="form_filter_equipment_category" id="form_filter_equipment_category" action="<?= base_url('administrator/equipment_category/index'); ?>" method="get">
				<div class="col-sm-12">
																					<div class="col-sm-6">
                                                			<div class="form-group ">
									<label class="col-sm-4 control-label">Name</label>
                                                        		<div class="col-sm-8">
									<input type="text" class="form-control" name="name" value="<?= !empty($_GET['name']) ? $_GET['name']:' ' ?>"></input>
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
						<a class="btn btn-danger btn-block btn-md btn-raised pull-right" value="Reset" href="<?= base_url('administrator/equipment_category');?>" title="<?= cclang('reset_filter'); ?>">
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


                  <form name="form_equipment_category" id="form_equipment_category" action="<?= base_url('administrator/equipment_category/index'); ?>">
                  

                  <div class="table-responsive"> 
                  <table class="table table-bordered table-striped dataTable">
                     <thead>
			<tr class="">
				                           <th>
                            <input type="checkbox" class="flat-red toltip" id="check_all" name="check_all" title="check all">
			   </th>
				                           <th>Image</th>
			   <th>Name</th>
			   								<th>Action</th>
				                        </tr>
                     </thead>
                     <tbody id="tbody_equipment_category">
                     <?php foreach($equipment_categorys as $equipment_category): ?>
			<tr>

				                           <td width="5">
                              <input type="checkbox" class="flat-red check" name="id[]" value="<?= $equipment_category->id; ?>">
			   </td>
				                           
                           <td>
                              <?php if (!empty($equipment_category->image)): ?>
                                <?php if (is_image($equipment_category->image)): ?>
                                <a class="fancybox" rel="group" href="<?= BASE_URL . 'uploads/equipment_category/' . $equipment_category->image; ?>">
                                  <img src="<?= BASE_URL . 'uploads/equipment_category/' . $equipment_category->image; ?>" class="image-responsive" alt="image equipment_category" title="image equipment_category" width="40px">
                                </a>
                                <?php else: ?>
                                  <a href="<?= BASE_URL . 'administrator/file/download/equipment_category/' . $equipment_category->image; ?>">
                                   <img src="<?= get_icon_file($equipment_category->image); ?>" class="image-responsive image-icon" alt="image equipment_category" title="image <?= $equipment_category->image; ?>" width="40px"> 
                                 </a>
                                <?php endif; ?>
                              <?php endif; ?>
                           </td>
                            
                           <td><?= _ent($equipment_category->name); ?></td> 
                           						<td width="200">
                              <?php is_allowed('equipment_category_view', function() use ($equipment_category){?>
                              <a href="<?= site_url('administrator/equipment_category/view/' . $equipment_category->id); ?>" class="label-default"><i class="fa fa-newspaper-o"></i> <?= cclang('view_button'); ?>
                              <?php }) ?>
                              <?php is_allowed('equipment_category_update', function() use ($equipment_category){?>
                              <a href="<?= site_url('administrator/equipment_category/edit/' . $equipment_category->id); ?>" class="label-default"><i class="fa fa-edit "></i> <?= cclang('update_button'); ?></a>
                              <?php }) ?>
                              <?php is_allowed('equipment_category_delete', function() use ($equipment_category){?>
                              <a href="javascript:void(0);" data-href="<?= site_url('administrator/equipment_category/delete/' . $equipment_category->id); ?>" class="label-default remove-data"><i class="fa fa-close"></i> <?= cclang('remove_button'); ?></a>
                               <?php }) ?>
			   </td>
				                        </tr>
                      <?php endforeach; ?>
                      <?php if ($equipment_category_counts == 0) :?>
                         <tr>
                           <td colspan="100">
                           Equipment Category data is not available
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
					     <div class="col-sm-2 padd-left-0 " >
                        <select type="text" class="form-control chosen chosen-select" name="bulk" id="bulk" placeholder="Site Email" >
                           <option value="">Bulk</option>
                           <option value="delete">Delete</option>
			</select>
                     </div>
                     <div class="col-sm-2 padd-left-0 ">
                        <button type="button" class="form-group btn btn-sm btn-success btn-raised" name="apply" id="apply" title="<?= cclang('apply_bulk_action'); ?>"><?= cclang('apply_button'); ?></button>
		     </div>
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
                window.location.replace(BASE_URL + '/administrator/equipment_category/index?q=' + q + '&f=' + f);
                return false; 
        });


    $('#apply').click(function(){

      var bulk = $('#bulk');
      var serialize_bulk = $('#form_equipment_category').serialize();

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
               document.location.href = BASE_URL + '/administrator/equipment_category/delete?' + serialize_bulk;      
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
