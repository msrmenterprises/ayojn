<div class="modal" id="topindustriesForm">
	<div class="modal-dialog">
		<div class="modal-content">

			<!-- Modal Header -->
			<!--   <div class="modal-header">
				   <h4 class="modal-title">Modal Heading</h4>
				   <button type="button" class="close" data-dismiss="modal">&times;</button>
			   </div>-->

			<!-- Modal body -->
			<div class="modal-body">

				<div class="row">
                    <?php
                    $color_array = array('progress-bar-info', 'progress-bar-warning', 'progress-bar-danger','progress-bar-success');
                    $x=0;
                    ?>
					<?php if(!empty($resultArray)): ?>
						<?php $__currentLoopData = $resultArray; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php  $x++;
                                $class = $color_array[$x%4];
                                ?>
							<div class="col-md-12 col-lg-12 align-self-center">
								<p class="text-muted font-13 mb-1">
									<i class="mdi mdi-checkbox-blank-circle mr-2 text-success"></i><?php echo e($result[0]['specifyName'].' (based on '.$result['count'].' inputs)'); ?>   <span class="float-right">  </span>
								</p>
								<div class="progress" >
									<div class="progress-bar <?= $class ?> progress-bar-striped" role="progressbar" aria-valuenow="<?php echo e($result['count']); ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo e($result['count']); ?>%">

									</div>
								</div><br>


							</div>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<?php else: ?>
						<div class="col-md-12 col-lg-12 align-self-center">
							No data Found For this Country
						</div>
				<?php endif; ?>
				<!--<div id="bardiv"></div>-->
				</div>

			</div>


			<!-- Modal footer -->
			<div class="modal-footer">
				<button type="button" onclick="closePopup()" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>

		</div>
	</div>
</div>