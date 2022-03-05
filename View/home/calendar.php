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

    <div class="content-wrapper p-2">
        <div class="content">
            <div id="calendar">

            </div>
        </div>
    </div>

</div>


<?php view('static/footer') ?>

</div>

<script src="<?= asset('plugins/jquery/jquery.min.js'); ?>"></script>
<script src="<?= asset('plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?= asset('js/adminlte.min.js'); ?>"></script>
<script src="<?= asset('plugins/fullcalendar/locales-all.js'); ?>"></script>
<script src="<?= asset('plugins/fullcalendar/main.js'); ?>"></script>
<script>

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale :'<?= default_lang()?>',
            events:'<?= url('api/calendar/') ?>'
        });
        calendar.render();
    });

</script>


</body>
</html>
;