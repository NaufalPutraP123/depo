<!doctype html>
<html lang="en">

<head>
    <title>Login</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/bootstrap/css/bootstrap.min.css');?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/login.css?v='.time());?>" />
</head>

<body style="background:#020f14;">
    <div class="container">
        <!-- grid -->
        <div class="row">
            <div class="col-sm-5 mx-auto mt-5 pt-5">
                <?php if(!empty($this->session->flashdata('failed'))){?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <?= $this->session->flashdata('failed');?>
                </div>
                <?php }?>
                <div class="card">
                    <div class="card-header text-center">
                        <h3 class="pt-2"><b>DEPO PRASASTI</b></h3>
                        <h3 class="pt-2"><b>SALATIGA</b></h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?= base_url('login/proses');?>">
                            <div class="form-group">
                                <label for="">Username</label>
                                <input type="text" required class="form-control" autocomplete="off" name="user"
                                    id="user" placeholder="Masukan Username">
                            </div>
                            <div class="form-group">
                                <label for="">Password</label>
                                <input type="password" required class="form-control" autocomplete="off" name="pass"
                                    id="pass" placeholder="Masukan Password">
                            </div>
                            <button type="submit" class="btn btn-primary btn-md float-right">
                                Masuk
                            </button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        Copyright &copy; <?= date('Y');?> DEPO PRASASTI |
                        <a href="https://www.depoprasasti.com" target="_blank"><b>DEPO PRASASTI </b></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- grid -->
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="<?= base_url('assets/js/jquery-3.3.1.min.js');?>"></script>
    <script src="<?= base_url('assets/plugins/bootstrap/popper.min.js');?>"></script>
    <script src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.min.js');?>"></script>
</body>

</html>