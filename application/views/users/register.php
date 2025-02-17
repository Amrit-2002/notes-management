<!-- <?php if (validation_errors()): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= validation_errors(); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?> -->



<?php echo form_open('users/register'); ?>
	<div class="container" style="margin-top:160px">
		<div class="row justify-content-center mt-4">
			<div class="bg-secondary-subtle col-md-4 rounded-4">
				<h1 class="text-center mt-4"><?= $title; ?></h1>
				<div class="form-group mb-3">
					<!-- <label>Name</label> -->
					<input type="text" class="form-control" name="name" placeholder="Name">
					<?php echo form_error('name', '<div class="error">', '</div>'); ?>
				</div>
				<div class="form-group mb-3">
					<!-- <label>Username</label> -->
					<input type="text" class="form-control" name="username" placeholder="Username">
					<?php echo form_error('username', '<div class="error">', '</div>'); ?>
				</div>
				<div class="form-group mb-3">
					<!-- <label>Email</label> -->
					<input type="email" class="form-control" name="email" placeholder="Email">
					<?php echo form_error('email', '<div class="error">', '</div>'); ?>
				</div>
				<div class="form-group mb-3">
					<!-- <label>Password</label> -->
					<input type="password" class="form-control" name="password" placeholder="Password">
					<?php echo form_error('password', '<div class="error">', '</div>'); ?>
				</div>
				<div class="form-group mb-3">
					<!-- <label>Confirm Password</label> -->
					<input type="password" class="form-control" name="password2" placeholder="Confirm Password">
					<?php echo form_error('password2', '<div class="error">', '</div>'); ?>
				</div>
				<div class="col-12 mb-5">
					<div class="d-grid">
					<button class="mt-3 btn bsb-btn-xl btn-primary" type="submit">Submit</button>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php echo form_close(); ?>
