<script src="<?= base_url() ?>assets/template/adminbsb/plugins/bootstrap-select/js/bootstrap-select.js"></script>
<script src="<?= base_url() ?>assets/template/adminbsb/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
<script src="<?= base_url() ?>assets/template/adminbsb/plugins/tinymce/tinymce.js"></script>
<!-- SweetAlert Plugin Js -->
<script src="<?= base_url() ?>assets/template/adminbsb/plugins/sweetalert/sweetalert.min.js"></script>
<script type="text/javascript">
    $(function() {
        tinymce.init({
            selector: "textarea#tinymce",
            theme: "modern",
            height: 300,
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools'
            ],
            toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            toolbar2: 'print preview media | forecolor backcolor emoticons',
            image_advtab: true
        });
        tinymce.suffix = ".min";
        tinyMCE.baseURL = '<?= base_url() ?>assets/template/adminbsb/plugins/tinymce';
        <?php if ($posting) { ?>
            $("#create_post").modal("show");
        <?php } ?>
    })

    function hapus_post(id) {
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel plx!",
            closeOnConfirm: false,
            closeOnCancel: false
        }, function (isConfirm) {
            if (isConfirm) {
                swal("Deleted!", "Your imaginary file has been deleted.", "success");
                window.location = "<?= site_url() ?>admin/delete_post?id="+id;
            } else {
                swal("Cancelled", "Your imaginary file is safe :)", "error");
            }
        });
    }
</script>