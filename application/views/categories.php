<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>CATEGORIES</h2>
        </div>

        <!-- Striped Rows -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Category Lists
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="javascript:void(0);" data-toggle="modal" data-target="#create_category">Create Category</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Category Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Category Name</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php 
                                if (count($categories) > 0) {
                                    foreach ($categories as $category) { 
                                ?>
                                    <tr>
                                        <th scope="row"><?= $category->id ?></th>
                                        <td><?= $category->name ?></td>
                                        <td><a href="javascript:void(0);" onclick="testing('<?= $category->id ?>');">Hapus</a> | <a href="javascript:void(0);">Edit</a></td>
                                    </tr>
                                <?php 
                                    }
                                } 
                                ?>
                            </tbody>
                        </table>
                        <?= $pagination; ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Striped Rows -->

        <!-- MODAL -->
        <div class="modal fade" id="create_category" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <form action="<?= base_url('admin/categories') ?>" method="post">
                        <div class="modal-header">
                            <h4 class="modal-title">Create Categories</h4>
                        </div>
                        <div class="modal-body">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">label</i>
                                </span>
                                <div class="form-line">
                                    <input type="text" class="form-control" name="name" placeholder="Category Name" required autofocus>
                                </div>
                                <?php echo form_error('name'); ?>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-link waves-effect">SAVE CHANGES</button>
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    var testing = function(id) {
        if (confirm('Are You Sure?\nWant to Delete this data?')) {
            window.location = "<?= base_url() ?>admin/delete_category?id="+id;
        }
    }
</script>