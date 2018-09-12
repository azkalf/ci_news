<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>USERS</h2>
        </div>

        <!-- Striped Rows -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            User Lists
                        </h2>
                    </div>
                    <div class="body table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Fullname</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Group</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Fullname</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Group</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php 
                                if (count($users) > 0) {
                                    foreach ($users as $user) { 
                                ?>
                                    <tr>
                                        <th scope="row"><?= $user->id ?></th>
                                        <td><img src="<?= base_url('assets/images/users/'.$user->photo) ?>" style="max-width: 50px; max-height: 50px;"></td>
                                        <td><?= $user->name ?></td>
                                        <td><?= $user->fullname ?></td>
                                        <td><?= $user->email ?></td>
                                        <td><?= genders($user->gender) ?></td>
                                        <td><?= groups($user->group_id) ?></td>
                                    </tr>
                                <?php 
                                    }
                                } 
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Striped Rows -->
    </div>
</section>