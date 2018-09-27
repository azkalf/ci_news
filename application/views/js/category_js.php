<!-- SweetAlert Plugin Js -->
<script src="<?= base_url() ?>assets/template/adminbsb/plugins/sweetalert/sweetalert.min.js"></script>
<script type="text/javascript">
	<?php if ($posting) { ?>
    $(function() {
        $("#create_category").modal("show");
    })
	<?php } ?>
    function hapus_category(id) {
        swal({
	        title: "Are you sure?",
	        text: "Want to Delete this data?",
	        type: "warning",
	        showCancelButton: true,
	        confirmButtonColor: "#DD6B55",
	        confirmButtonText: "Yes, delete it!",
	        closeOnConfirm: false
	    }, function () {
	        swal("Deleted!", "Category has been deleted.", "success");
            window.location = "<?= site_url() ?>admin/delete_category?id="+id;
	    });
    }
    function edit_category(id) {
    	$.ajax({
    		url: "<?= site_url('admin/get_category') ?>",
    		data: {id: id},
    		type: 'post',
    		dataType: 'json',
    		success: function(data) {
    			$('#category_id').val(data.id);
    			$('#category_name').val(data.name);
    			$('#edit_category').modal("show");
    		},
    		error: function(data) {
    			console.log(data);
    		}
    	})
    }

    function update_category() {
    	var id = $('#category_id').val();
    	var name = $('#category_name').val();
    	if (name == '') {
    		swal("Eits!", "isi dong datanya!", "error");
    	} else {
	    	$.ajax({
	    		url: "<?= site_url('admin/update_category') ?>",
	    		data: {id: id, name: name},
	    		type: 'post',
	    		dataType: 'json',
	    		success: function(data) {
	    			if (data.status == 'success') {
	    				$('#category_table').find('[data-id="'+id+'"]').html(name);
		    			swal("Updated!", "Category has been updated.", "success");
		    			$('#edit_category').modal("hide");
	    			} else {
		    			swal("Gagal!", data.message, "error");
	    			}
	    		},
	    		error: function(data) {
	    			console.log(data);
	    		}
	    	})
    	}
    }
</script>