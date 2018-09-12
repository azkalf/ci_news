<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>POSTS</h2>
        </div>

        <!-- Striped Rows -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Post Lists
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="javascript:void(0);" data-toggle="modal" data-target="#create_post">Create Post</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <?php if (auth_user()->group_id == 1) { ?>
                                        <th>Author</th>
                                    <?php } ?>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Tags</th>
                                    <th>Descriptiom</th>
                                    <th>Date Created</th>
                                    <th>Date Updated</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <?php if (auth_user()->group_id == 1) { ?>
                                        <th>Author</th>
                                    <?php } ?>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Tags</th>
                                    <th>Descriptiom</th>
                                    <th>Date Created</th>
                                    <th>Date Updated</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php 
                                if (count($posts) > 0) {
                                    foreach ($posts as $post) { 
                                ?>
                                    <tr>
                                        <th scope="row"><?= $post->id ?></th>
                                        <td><img src="<?= base_url('assets/images/posts/'.$post->image) ?>" style="max-width: 50px; max-height: 50px;"></td>
                                        <?php if (auth_user()->group_id == 1) { ?>
                                            <td><?= author($post->author_id) ?></td>
                                        <?php } ?>
                                        <td><?= $post->title ?></td>
                                        <td><?= category($post->category_id) ?></td>
                                        <td><?= tags($post->id) ?></td>
                                        <td><?= substr($post->description, 0, 11) ?></td>
                                        <td><?= $post->date_created ?></td>
                                        <td><?= $post->date_updated ?></td>
                                        <td><a href="javascript:void(0);">Hapus</a> | <a href="javascript:void(0);">Edit</a></td>
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
        <div class="modal fade" id="create_post" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="<?= site_url('admin/posts') ?>" method="post" enctype="multipart/form-data" id="form_post">
                        <div class="modal-header">
                            <h4 class="modal-title">Create Post</h4>
                        </div>
                        <div class="modal-body">
                            <?= isset($error) ? '<label class="error col-red text-center">'.$error.'</label>' : '' ?>
                            <div class="form-group">
                                <label>Image</label>
                                <div class="form-line">
                                    <input type="file" name="image" id="image" />
                                </div>
                                <?php echo form_error('image'); ?>
                            </div>
                            <div class="form-group">
                                <label>Title</label>
                                <div class="form-line">
                                    <input type="text" class="form-control" name="title" placeholder="Title" value="<?= set_value('title') ?>" autofocus>
                                </div>
                                <?php echo form_error('title'); ?>
                            </div>
                            <div class="form-group">
                                <label>Category</label>
                                <select class="form-control show-tick" name="category_id">
                                    <option value="">-- Select Category --</option>
                                    <?php 
                                    if (count($categories) > 0) {
                                        foreach ($categories as $category) { 
                                            $selected = $category->id == set_value('category_id') ? 'selected' : '';
                                    ?>
                                        <option value="<?= $category->id ?>" <?= $selected ?>><?= $category->name ?></option>
                                    <?php 
                                        }
                                    }
                                    ?>
                                </select>
                                <?php echo form_error('category_id'); ?>
                            </div>
                            <div class="form-group">
                                <label>Tags</label>
                                <div class="form-line">
                                    <input type="text" class="form-control" name="tags" data-role="tagsinput" value="<?= set_value('tags') ?>">
                                </div>
                                <?php echo form_error('tags'); ?>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea id="tinymce" name="description"><?= set_value('description') ?></textarea>
                                <?php echo form_error('description'); ?>
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