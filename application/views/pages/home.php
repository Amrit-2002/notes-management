
    <div class="container text-center mt-5">
        <div class="card border-5 bg-body-secondary" style="margin-top:140px">
            <div class="card-body m-4">
                <h1 class="card-title display-3 fw-bold text-dark">Welcome to Notes App</h1>
                <p class="lead text-secondary mt-3">"Organize your thoughts, capture your ideas, and keep your life on track."</p>
                <hr class="my-4">
                <p class="text-muted">Start creating, editing, and managing your notes seamlessly.</p>
                <?php if($this->session->userdata('logged_in')) : ?>
                    <a href="<?= base_url('notes') ?>" class="btn btn-dark btn-lg mt-3">Get Started</a>
                <?php endif; ?>
                <?php if(!$this->session->userdata('logged_in')) : ?>
                    <a href="<?= base_url('users/login') ?>" class="btn btn-dark btn-lg mt-3">Get Started</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
