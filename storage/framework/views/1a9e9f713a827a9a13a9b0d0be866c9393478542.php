<!--Add title-->
<?php $__env->startSection('title',  'Sponsorr'); ?>
<!--Main Body content-->
<?php $__env->startSection('content'); ?>
	<!-- //banner-top -->
	<!-- banner -->
	<!-- Content Header (Page header) -->

	<section class="content-header">
		<h1>
			Vouch
			<small>List</small>

		</h1>


		<ol class="breadcrumb">


			<li><a href="<?php echo e(url('admin/dashboard')); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Vouch List</li>

		</ol>
	</section>
	<style type="text/css">
		.mb20 {
			margin-bottom: 20px;
		}

		.checkbox {
			margin-top: 0px;
		}
	</style>
	<!-- Main content -->
	<section class="content">
		<div class="row">
			<!-- left column -->
			<div class="col-md-12">
				<!-- general form elements -->
				<div class="box box-primary">
					<div class="box-header with-border">
						<div class="col-md-12">
							<?php if(session()->has('success')): ?>
								<div class="alert alert-success">
									<?php echo e(session()->get('success')); ?>

								</div>
							<?php endif; ?>
							<?php if($errors->any()): ?>
								<div class="alert alert-danger">
									<ul>
										<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<li><?php echo e($error); ?></li>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</ul>
								</div>
							<?php endif; ?>
							<?php if(session('true')): ?>
								<div class="alert alert-success alert-dismissable">
									<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
									<?php echo e(session('true')); ?>

								</div>
							<?php endif; ?>
							<?php if(session('false')): ?>
								<div class="alert alert-danger alert-dismissable">
									<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
									<?php echo e(session('false')); ?>

								</div>
							<?php endif; ?>
						</div>
						<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add user')): ?>
							<div class="col-md-12">
								<a href="<?php echo e(route('user.create')); ?>" class="btn btn-primary ladda-button"
								   data-style="zoom-in">
									<span class="ladda-label"><i class="fa fa-plus"></i> Add User</span>
								</a>
							</div>
						<?php endif; ?>
					</div>

					<div class="box-body table-responsive">
						<table id="data-table" class="table table-bordered table-striped last-child-sm" width="100%"
							   data-page-length='100'>
							<thead>
							<tr>
								<th width="3%">Vouch Id</th>
								<th width="10%">Vouch User Email</th>
								<th width="20%">Vouch Value</th>
								<th width="16%">Vouch Date</th>
								<th width="10%%">Vouch Status</th>
							</tr>
							</thead>
							<tfoot>
							<tr>
								<th width="3%">Vouch Id</th>
								<th width="10%">Vouch User Email</th>
								<th width="20%">Vouch Value</th>
								<th width="16%">Vouch Date</th>
								<th width="10%%">Vouch Status</th>
							</tr>
							</tfoot>
						</table>
					</div>
					<!-- form start -->
					<div class="box-footer clearfix text-right">

					</div>
				</div>
				<!-- /.box -->
			</div>
			<!--/.col (left) -->
		</div>
	</section>

	<script type="text/javascript">
      var oTable;

      $(document).on('click', '.delete-button', function (e) {
        e.preventDefault();
        var url = $(this).data('url');

        swal({
          title: "Are you sure?",
          text: "Are you sure that you want to delete this Role?",
          icon: "warning",
          buttons: true,
          dangerMode: true
        }).then(
          function (isConfirm) {
            if (isConfirm) {
              $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                  "_token": "<?php echo e(csrf_token()); ?>"
                },
                success: function () {
                  // delete the row from the table

                  oTable.draw();
                  swal("Role Deleted", "User has been deleted successfully.", "success");
                },
                error: function () {
                  // Show an alert with the result

                  swal("Role Not Deleted", "There's been an error. Your User might not have been deleted.", "error");
                }
              });
            }
          });

      });

      $(function () {
        var url = "<?php echo e(url('controlpanel/list-vouch')); ?>" + "/<?php echo e(request()->segment(count(request()->segments()))); ?>";
        var oTable = $('#data-table').DataTable({
          // dom: "<'row'<'col-xs-12'<'col-xs-6'l><'col-xs-6'p>>r>"+
          // "<'row'<'col-xs-12't>>"+
          // "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>",
          bFilter: true,
          bLengthChange: true,
          processing: true,
          serverSide: true,
          ajax: {
            url: url,
            type: "POST",
            headers: {"X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>"},
            data: function (d) {

            }
          },
          columns: [

            {"data": "id"},
            {"data": "userEmail"},
            {"data": "vouch_value"},
             {"data": "created_at"},
             {"data": "status"},

          ], "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            $(nRow).attr("data-id", aData['id']);
            return nRow;
          },
        });

        $('#moveprofile').on('submit', function (e) {
          if ($('#admin_from').val() != '' && $('#admin_to').val() != '') {
            oTable.draw();
          } else {
            toastr.error("Admin From And To Is Required", "Error");
          }
          e.preventDefault();
        });
      });
      $('#selected_users').change(function () {
        ///$('.groupCheckBox').not(this).prop('checked', this.checked);
        // var rows = users.rows({ 'search': 'applied' }).nodes();
        $('input[type="checkbox"]').prop('checked', this.checked);
      });
      $('#data-table tbody').on('change', 'input[type="checkbox"]', function () {
        // If checkbox is not checked
        if (!this.checked) {
          var el = $('#data-table').get(0);
          // If "Select all" control is checked and has 'indeterminate' property
          if (el && el.checked) {

          }
        }
      });


	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>