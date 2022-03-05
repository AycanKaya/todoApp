<?php view('static/header'); ?>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <nav class="main-header navbar navbar-expand navbar-white navbar-light">

        <ul class="navbar-nav ml-auto">
            <li class="nav-item d-none d-sm-inline-block">
                <a href="<?= URL . 'cikis'; ?>" class="nav-link">Çıkış Yap</a>
            </li>
        </ul>
    </nav>

    <?php view('static/sidebar') ?>

    <div class="content-wrapper p-5">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Profiliniz</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <?php
                            echo get_session('error') ? '<div class="alert alert-' . $_SESSION['error']['type'] . '">' . $_SESSION['error']['message'] . '</div>' : null;


                            ?>

                            <form id="profile" action="" method="post">
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="isim">İsim</label>
                                        <input type="text" class="form-control" value="<?= get_session('name')?>" id="isim" >
                                    </div>
                                    <div class="form-group">
                                        <label for="soyisim">Soyisim</label>
                                        <input type="text" class="form-control" value="<?= get_session('surname')?>" id="soyisim" >
                                    </div>
                                    <div class="form-group">
                                        <label for="email">E-Posta</label>
                                        <input type="text" class="form-control" value="<?= get_session('email')?>" id="email" >
                                    </div>




                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Güncelle
                                    </button>
                                </div>
                            </form>


                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Şifrenizi Değiştirin</h3>
                            </div>

                            <form id="password_change" action="" method="post">
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="old_password">Geçerli Şifreniz</label>
                                        <input type="text" class="form-control" id="old_password">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Yeni Şifre</label>
                                        <input type="text" class="form-control" id="password">
                                    </div>
                                    <div class="form-group">
                                        <label for="password_again">Yeni Şifre Tekrar</label>
                                        <input type="text" class="form-control" id="password_again">
                                    </div>




                                    <div class="card-footer">
                                        <button type="submit" name="submit" value="1" class="btn btn-primary">Güncelle
                                        </button>
                                    </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php view('static/footer') ?>

</div>

<script src="<?= asset('plugins/jquery/jquery.min.js'); ?>"></script>


<script src="<?= asset('plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?= asset('plugins/sweetalert2/sweetalert2.all.js'); ?>"></script>


<script src="<?= asset('js/adminlte.min.js'); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.0/axios.min.js"
        integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>

    const profile = document.getElementById('profile');

    const password_change = document.getElementById('password_change');



    profile.addEventListener('submit', (e) => {
        e.preventDefault();

        let isim = document.getElementById('isim').value;
        let soyisim = document.getElementById('soyisim').value;
        let email = document.getElementById('email').value;

        let formData = new FormData();
        formData.append('isim', isim);
        formData.append('soyisim', soyisim);
        formData.append('email', email);


        axios.post('<?= url('api/profile')?>', formData).then(res => {

            Swal.fire(
                res.data.title,
                res.data.msg,
                res.data.status,
            );

            console.log(res)
        }).catch(err => console.log(err));
    })

    password_change.addEventListener('submit', (e) => {
        e.preventDefault();

        let old_password = document.getElementById('old_password').value;
        let password = document.getElementById('password').value;
        let password_again = document.getElementById('password_again').value;

        let formData = new FormData();
        formData.append('old_password', old_password);
        formData.append('password', password);
        formData.append('password_again', password_again);


        axios.post('<?= url('api/passwordchange')?>', formData).then(res => {

            Swal.fire(
                res.data.title,
                res.data.msg,
                res.data.status,
            );
            console.log(res)
        }).catch(err => console.log(err));
    })

</script>
</body>
</html>
