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
                                    <h3 class="card-title">TODOS</h3>

                                    <div class="card-tools">
                                       <a href="<?= url('todo/add')?>" class="btn btn-sm btn-dark">Todo Ekle</a>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body p-0">

                                    <?php
                                    echo get('message') ? '<div class="alert alert-' . get('type'). '">' . get('message'). '</div>' : null;
                                    ?>

                                    <table class="table">
                                        <thead>
                                        <tr>

                                            <th>Başlık</th>
                                            <th>Kategori</th>
                                            <th>Başlangıç</th>
                                            <th>Bitiş</th>
                                            <th>İlerleme</th>
                                            <th>İşlem</th>
                                            <th style="width: 40px">İşlem</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($data as $key => $value): ?>
                                        <tr>

                                            <td><?= $value['title']?></td>
                                            <td><?= $value['category_title']?></td>
                                            <td>
                                               <?= $value['created_date']?>
                                            </td>
                                            <td>
                                                <?= $value['end_date']?>
                                            </td>
                                            <td>
                                                <?= $value['progress']?>%
                                                <div class="progress progress-xs">
                                                    <div class="progress-bar progress-bar-danger" style="width: 55%"></div>

                                                </div>
                                            </td>
                                            <td><span class="badge bg-<?= status($value['status'])['color'];?>"><?= status($value['status'])['title']?></span></td>


                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a class="btn btn-sm btn-danger" href="<?= url('todo/remove/'.$value['id'])?>">
                                                        Sil
                                                    </a>

                                                    <a class="btn btn-sm btn-warning" href="<?= url('todo/edit/'.$value['id'])?>">
                                                        Güncelle
                                                    </a>


                                                </div>
                                            </td>
                                        </tr>
                                        <?php  endforeach;?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
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

<script src="<?= asset('js/adminlte.min.js'); ?>"></script>
</body>
</html>
