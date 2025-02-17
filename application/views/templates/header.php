<html>
	<head>
		<title>Notes App</title>
		<link rel="stylesheet" href="https://bootswatch.com/5/flatly/bootstrap.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    </head>

	<body>

        <nav class="navbar navbar-expand-sm bg-dark" data-bs-theme="dark" style="position: fixed;top: 0;width: 100%;">
            <div class="container">
                <div class="collapse navbar-collapse" id="navbarColor01">
                    <ul class="navbar-nav me-auto">
                        <?php if(!$this->session->userdata('logged_in')) : ?>
                            <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>">Home</a></li>
                        <?php endif; ?>
                        <?php if($this->session->userdata('logged_in')) : ?>
                            <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>notes">Notes</a></li>
                        <?php endif; ?>
                    </ul>


                    <ul class="nav navbar-nav navbar-right">
                        <?php if(!$this->session->userdata('logged_in')) : ?>
                            <li class="nav-item"><a class="nav-link " href="<?php echo base_url(); ?>users/login">Login</a></li>
                            <li class="nav-item"><a class="nav-link " href="<?php echo base_url(); ?>users/register">Register</a></li>
                        <?php endif; ?>

                        <?php if($this->session->userdata('logged_in')) : ?>
                            <!-- Dropdown for logged-in user -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <!-- User icon -->
                                    <i class="bi bi-person-circle me-2" style="font-size: 1.25rem;"></i> 
                                    <h6 class="mb-0"><?php echo $this->session->userdata('username'); ?></h6>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="<?php echo base_url(); ?>users/logout">Logout</a></li>
                                </ul>
                            </li>
                        <?php endif; ?>
                    </ul>



                </div>
            </div>
        </nav>

    <!-- Flash messages -->

        <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" style="margin-top:56px;" role="alert">
            <?= $this->session->flashdata('error'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('user_loggedout')): ?>
        <div class="alert alert-success alert-dismissible fade show" style="margin-top:56px;"  role="alert">
            <?= $this->session->flashdata('user_loggedout'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>
        
        <?php if ($this->session->flashdata('user_registered')): ?>
        <div class="alert alert-success alert-dismissible fade show" style="margin-top:56px;"  role="alert">
            <?= $this->session->flashdata('user_registered'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('user_loggedin')): ?>
        <div class="alert alert-success alert-dismissible fade show" style="margin-top:56px;"  role="alert">
            <?= $this->session->flashdata('user_loggedin'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('login_failed')): ?>
        <div class="alert alert-danger alert-dismissible fade show" style="margin-top:56px;"  role="alert">
            <?= $this->session->flashdata('login_failed'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('collaborators')): ?>
        <div class="alert alert-success alert-dismissible fade show" style="margin-top:56px;"  role="alert">
            <?= $this->session->flashdata('collaborators'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('collaborators_error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" style="margin-top:56px;"  role="alert">
            <?= $this->session->flashdata('collaborators_error'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('permissions_success')): ?>
        <div class="alert alert-success alert-dismissible fade show" style="margin-top:56px;"  role="alert">
            <?= $this->session->flashdata('permissions_success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('permissions_error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" style="margin-top:56px;"  role="alert">
            <?= $this->session->flashdata('permissions_error'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>
        

       
