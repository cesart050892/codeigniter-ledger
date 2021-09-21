<?= $this->extend('templates/auth') ?>

<?= $this->section('content') ?>
<div class="page">
      <div class="page-single">
        <div class="container">
          <div class="row">
            <div class="col col-login mx-auto">
              <div class="text-center mb-6">
                <img src="./assets/brand/tabler.svg" class="h-6" alt="">
              </div>
              <form class="card" action="" method="post">
                <div class="card-body p-6">
                  <div class="card-title">Login to your account</div>
                  <div class="form-group">
                    <label class="form-label">Username</label>
                    <input type="" class="form-control" id="inputUser" aria-describedby="" placeholder="Username" required>
                  </div>
                  <div class="form-group">
                    <label class="form-label">
                      Password
                      <a href="./forgot-password.html" class="float-right small">I forgot password</a>
                    </label>
                    <input type="password" class="form-control" id="inputPass" placeholder="Password" required>
                  </div>
                  <div class="form-group">
                    <label class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" />
                      <span class="custom-control-label">Remember me</span>
                    </label>
                  </div>
                  <div class="form-footer">
                    <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                  </div>
                </div>
              </form>
              <div class="text-center text-muted">
                Don't have account yet? <a href="./register.html">Sign up</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
  console.log('Hello world!')
</script>
<?= $this->endSection() ?>