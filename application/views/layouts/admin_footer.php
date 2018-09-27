    <!-- Jquery Core Js -->
    <script src="<?= base_url('assets/template/adminbsb/') ?>plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="<?= base_url('assets/template/adminbsb/') ?>plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="<?= base_url('assets/template/adminbsb/') ?>plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="<?= base_url('assets/template/adminbsb/') ?>plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="<?= base_url('assets/template/adminbsb/') ?>plugins/node-waves/waves.js"></script>

    <!-- Jquery CountTo Plugin Js -->
    <script src="<?= base_url('assets/template/adminbsb/') ?>plugins/jquery-countto/jquery.countTo.js"></script>

    <!-- Morris Plugin Js -->
    <script src="<?= base_url('assets/template/adminbsb/') ?>plugins/raphael/raphael.min.js"></script>
    <script src="<?= base_url('assets/template/adminbsb/') ?>plugins/morrisjs/morris.js"></script>

    <!-- ChartJs -->
    <script src="<?= base_url('assets/template/adminbsb/') ?>plugins/chartjs/Chart.bundle.js"></script>

    <!-- Flot Charts Plugin Js -->
    <script src="<?= base_url('assets/template/adminbsb/') ?>plugins/flot-charts/jquery.flot.js"></script>
    <script src="<?= base_url('assets/template/adminbsb/') ?>plugins/flot-charts/jquery.flot.resize.js"></script>
    <script src="<?= base_url('assets/template/adminbsb/') ?>plugins/flot-charts/jquery.flot.pie.js"></script>
    <script src="<?= base_url('assets/template/adminbsb/') ?>plugins/flot-charts/jquery.flot.categories.js"></script>
    <script src="<?= base_url('assets/template/adminbsb/') ?>plugins/flot-charts/jquery.flot.time.js"></script>

    <!-- Sparkline Chart Plugin Js -->
    <script src="<?= base_url('assets/template/adminbsb/') ?>plugins/jquery-sparkline/jquery.sparkline.js"></script>
    
    <?php if (isset($js)) {
        $this->load->view('js/'.$js);
    } ?>

    <!-- Custom Js -->
    <script src="<?= base_url('assets/template/adminbsb/') ?>js/admin.js"></script>
    <script src="<?= base_url('assets/template/adminbsb/') ?>js/pages/index.js"></script>

    <!-- Demo Js -->
    <script src="<?= base_url('assets/template/adminbsb/') ?>js/demo.js"></script>

</body>

</html>