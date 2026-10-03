<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">

<title><?= $judul ?></title>

<!-- Bootstrap core CSS-->
<link href="<?= asset_url(); ?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom fonts for this template-->
<link href="<?= asset_url(); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

<!-- Custom styles for this template-->
<link href="<?= asset_url(); ?>css/sb-admin-2.css" rel="stylesheet">

<!-- Bootstrap core JavaScript-->
<link rel="stylesheet" type="text/css" href="<?= asset_url(); ?>vendor/jquery-autocomplete/styles.css">
<script src="<?= asset_url(); ?>vendor/jquery/jquery.js"></script>
<script src="<?= asset_url(); ?>vendor/jquery-autocomplete/jquery.autocomplete.min.js"></script>
<script src="<?= asset_url(); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- DATATABLES CSS -->
<link href="<?= asset_url(); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="<?= asset_url(); ?>vendor/datatables/buttons.bootstrap4.min.css" rel="stylesheet">
<link href="<?= asset_url(); ?>vendor/datatables/jquery.dataTables.min.css" rel="stylesheet">
<link href="<?= asset_url(); ?>vendor/datatables/fixedColumns.dataTables.min.css" rel="stylesheet">

<!-- DATATABLES JS -->
<script src="<?= asset_url(); ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= asset_url(); ?>vendor/datatables/dataTables.bootstrap4.js"></script>
<script src="<?= asset_url(); ?>vendor/datatables/dataTables.buttons.min.js"></script>
<script src="<?= asset_url(); ?>vendor/datatables/buttons.bootstrap4.min.js"></script>
<script src="<?= asset_url(); ?>vendor/datatables/dataTables.fixedColumns.min.js"></script>
<script src="<?= asset_url(); ?>vendor/datatables/jszip.min.js"></script>
<script src="<?= asset_url(); ?>vendor/datatables/pdfmake.min.js"></script>
<script src="<?= asset_url(); ?>vendor/datatables/vfs_fonts.js"></script>
<script src="<?= asset_url(); ?>vendor/datatables/buttons.html5.min.js"></script>
<script src="<?= asset_url(); ?>vendor/datatables/buttons.print.min.js"></script>
<script src="<?= asset_url(); ?>vendor/datatables/buttons.colVis.min.js"></script>

<!-- Fullcalendar6 -->
<script src='<?= asset_url(); ?>vendor/fullcalendar/index.global.js'></script>

<!-- Sweetalert2 -->
<script src="<?= asset_url(); ?>vendor/sweetalert2/sweetalert2@11.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= asset_url(); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Page level plugins -->
<script src="<?= asset_url(); ?>vendor/chart.js/Chart.min.js"></script>


<style>
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    @media (max-width: 768px) {
        .nw td,
        th {
            white-space: nowrap;
        }
    }

    .badge-notif {
        zoom: 80%;
        border-radius: 8px;
    }

    .sidebar .nav-item.active > .nav-link,
    .sidebar .nav-item .collapse .nav-link.active {
        background: rgba(255, 255, 255, 0.18);
        color: #fff !important;
        border-radius: 0.45rem;
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.12);
    }

    .sidebar .nav-item .collapse .nav-link.active i,
    .sidebar .nav-item.active > .nav-link i {
        color: #fff;
    }

    @media (max-width: 767.98px) {
        .sidebar {
            width: 100% !important;
            min-height: auto;
            position: relative;
            overflow: visible;
        }

        .sidebar .nav-item {
            width: 100%;
            display: block;
        }

        .sidebar .nav-item .nav-link {
            width: 100% !important;
            display: flex !important;
            align-items: center;
            justify-content: flex-start;
            text-align: left !important;
            padding: 0.8rem 0.9rem !important;
        }

        .sidebar .nav-item .nav-link i {
            margin-right: 0.6rem;
            width: 16px;
            text-align: center;
        }

        .sidebar .nav-item .nav-link span {
            display: inline !important;
            font-size: 0.9rem !important;
            line-height: 1.3;
        }

        .sidebar .nav-item .nav-link[data-toggle="collapse"]::after {
            display: none !important;
        }

        .sidebar .nav-item .collapse {
            position: static !important;
            left: auto !important;
            top: auto !important;
            z-index: auto;
            display: block;
            width: 100%;
            margin: 0 0 0 1.1rem;
            border-left: 2px solid rgba(255,255,255,0.24);
            padding-left: 0.7rem;
            background: transparent;
        }

        .sidebar .nav-item .collapse:not(.show) {
            display: none;
        }

        .sidebar .nav-item .collapse .nav-link {
            padding: 0.7rem 0.8rem !important;
            white-space: normal;
            font-size: 0.9rem;
        }

        .sidebar .nav-item .collapse .nav-link i {
            margin-right: 0.55rem;
        }
    }
</style>