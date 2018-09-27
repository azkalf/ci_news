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
                        <table class="table table-striped" id="category_table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Category Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if (count($categories) > 0) {
                                    foreach ($categories as $category) { 
                                ?>
                                    <tr>
                                        <th scope="row"><?= $category->id ?></th>
                                        <td data-id="<?= $category->id ?>"><?= $category->name ?></td>
                                        <td><a href="javascript:void(0);" onclick="hapus_category('<?= $category->id ?>');">Hapus</a> | <a href="javascript:void(0);" onclick="edit_category('<?= $category->id ?>')">Edit</a></td>
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
                    <form action="<?= site_url('admin/categories') ?>" method="post">
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

        <!-- MODAL -->
        <div class="modal fade" id="edit_category" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Create Categories</h4>
                    </div>
                    <div class="modal-body">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">label</i>
                            </span>
                            <div class="form-line">
                                <input type="hidden" name="id" id="category_id">
                                <input type="text" class="form-control" name="name" id="category_name" placeholder="Category Name" required autofocus>
                            </div>
                            <?php echo form_error('name'); ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link waves-effect" onclick="update_category()">SAVE CHANGES</button>
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>