<?php echo form_open('users/login'); ?>
  	<div class="container" style="margin-top:160px">
		<div class="row justify-content-center mt-4 ">
			<div class="bg-secondary-subtle col-md-4 rounded-4">
				<h1 class="text-center m-4"><?php echo $title; ?></h1>
				<div class="form-group">
					<input type="text" name="username" class="form-control" placeholder="Enter Username" required autofocus>
				</div>
				<div class="mt-3 form-group">
					<input type="password" name="password" class="form-control" placeholder="Enter Password" required autofocus>
					<?php echo form_error('password', '<div class="error">', '</div>'); ?>
				</div>
				<div class="col-12 mb-5">
					<div class="d-grid">
					<button class="my-3 btn bsb-btn-xl btn-primary" type="submit">Login</button>
					</div>
				</div>
			</div>
		</div>	
  	</div>
<?php echo form_close(); ?>