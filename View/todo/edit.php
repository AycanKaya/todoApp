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
                                <h3 class="card-title">Yapılacaklar Listenize Ekleyin</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <?php
                            echo get_session('error') ? '<div class="alert alert-' . $_SESSION['error']['type'] . '">' . $_SESSION['error']['message'] . '</div>' : null;


                            ?>

                            <form id="todo" action="" method="post">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="title">Kategori Seçiniz</label>
                                        <select class="form-control" id="category_id">
                                            <option value="0">Kategori Seçimi Yapınız</option>
                                            <?php foreach ($data as $category): ?>
                                                <option value="<?= $category['id'] ?>"> <?= $category['title'] ?> </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="title">Başlık</label>
                                        <input type="text" class="form-control" id="title" name="title"
                                               placeholder="<?= $data['title'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="title">Açıklama</label>
                                        <input type="text" class="form-control" id="description" name="description"
                                               placeholder="<?= $data['description'] ?>">
                                    </div>


                                    <div class="form-group">
                                        <label for="status">Durum</label>
                                        <select id="status" class="form-control">
                                            <option <?php $data['status'] == 'a' ? ' selected="selected" ' : null; ?>
                                                    value="a">Aktif
                                            </option>
                                            <option <?php $data['status'] == 'p' ? ' selected="selected" ' : null; ?>
                                                    value="p">Pasif
                                            </option>
                                            <option <?php $data['status'] == 's' ? ' selected="selected" ' : null; ?>
                                                    value="s">Süreçte
                                            </option>
                                        </select>

                                    </div>

                                    <div class="form-group">
                                        <label for="progress">İlerleme</label>
                                        <input type="range" class="form-control" id="progress"
                                               value="<?= $data['progress'] ?>" min="0" max="100">

                                    </div>


                                    <div class="form-group">
                                        <label for="title">Renk Seçiniz</label>
                                        <input type="color" class="form-control" id="color"
                                               value="<?= $data['color'] ?>"
                                               name="color">
                                    </div>
                                    <div class="form-group">
                                        <label for="title">Başlangıç Tarihi</label>
                                        <div class="row">
                                            <input type="date" class="form-control col-8" id="start_date"
                                                   value="<?= $data['start_date'] ?>"
                                                   name="start_date">
                                            <input type="time" class="form-control col-4" id="start_date_time"
                                                   value="<?= $data['start_date_time'] ?>"
                                                   name="start_date_time">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="title">Bitiş Tarihi</label>
                                        <div class="row">
                                            <input type="date" class="form-control col-8" id="end_date"
                                                   value="<?= $data['end_date'] ?>" name="end_date">
                                            <input type="time" class="form-control col-4" id="end_date_time"
                                                   value="<?= $data['end_date_time'] ?>"
                                                   name="end_date_time">
                                        </div>
                                    </div>

                                </div>

                                <div class="card-footer">
                                    <button type="submit" name="submit" value="1" class="btn btn-primary">Ekle
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

    const todo = document.getElementById('todo');

    let progress = document.getElementById('progress');

    progress.addEventListener('change', (e) => {
        console.log(progress.value);
    })

    todo.addEventListener('submit', (e) => {
        e.preventDefault();

        let title = document.getElementById('title').value;
        let description = document.getElementById('description').value;
        let category_id = document.getElementById('category_id').value;
        let color = document.getElementById('color').value;
        let start_date = document.getElementById('start_date').value;
        let end_date = document.getElementById('end_date').value;
        let end_date_time = document.getElementById('end_date_time').value;
        let start_date_time = document.getElementById('start_date_time').value;
        let progress = document.getElementById('progress').value;
        let status = document.getElementById('status').value;


        let formData = new FormData();
        formData.append('title', title);
        formData.append('description', description);
        formData.append('category_id', category_id);
        formData.append('color', color);
        formData.append('start_date', start_date);
        formData.append('end_date', end_date);
        formData.append('end_date_time', end_date_time);
        formData.append('start_date_time', start_date_time);
        formData.append('progress', progress);
        formData.append('status', status);

        axios.post('<?= url('api/edittodo')?>', formData).then(res => {

            //if response.data.redirect
            if (res.data.redirect) {
                window.location.href = res.data.redirect;
            } else {
                Swal.fire(
                    res.data.title,
                    res.data.msg,
                    res.data.status,
                );
            }
            console.log(res)
        }).catch(err => console.log(err));
    })

</script>
</body>
</html>
