<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Table</h2>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i
                            class="zmdi zmdi-sort-amount-desc"></i></button>

                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <button class="float-right btn btn-primary btn-icon right_icon_toggle_btn" type="button"><i
                            class="zmdi zmdi-arrow-right"></i></button>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <!-- Basic Examples -->

            <!-- Exportable Table -->
            <div class="clearfix row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Tables</strong></h2>
                            <ul class="header-dropdown">
                                <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle"
                                        data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="zmdi zmdi-more"></i> </a>
                                    <ul class="dropdown-menu dropdown-menu-right slideUp">
                                        <li><a href="javascript:void(0);">Action</a></li>
                                        <li><a href="javascript:void(0);">Another action</a></li>
                                        <li><a href="javascript:void(0);">Something else</a></li>
                                    </ul>
                                </li>
                                <li class="remove">
                                    <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable  ">
                                    <thead class="">
                                        <tr class="">
                                            <th>S/N</th>
                                            <th>Name</th>
                                            <th>Acquisition Amount</th>
                                            <th>DNS Server</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <tr>

                                            <td>MM</td>
                                            <td>YY</td>
                                            <td>HH</td>
                                            <td>Hh</td>
                                            <td>Hh</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>


<!-- form for edit -->

<section class="content">
    <div class="container">
        <h2 class="col-md-6 text-left">Edit User</h2>
        <p><a href="<?php //echo base_url('user/index'); ?>">Users</a></p>

        <?php //echo form_open('user/edit_user', ['id' => 'userForm']); ?>

        <!-- Hidden field for user ID -->
        <input type="hidden" name="id" value="<?//= isset($user['id']) ? $user['id'] : ''; ?>">

        <div class="row clearfix">
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="userName" class="form-control" placeholder="User Name"
                        value="<?=// isset($user['userName']) ? set_value('userName', $user['userName']) : ''; ?>"
                        required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email"
                        value="<?//= isset($user['email']) ? set_value('email', $user['email']) : ''; ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password">
                    <small>Leave blank if you do not want to change the password</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" name="userPhoneNumber" class="form-control" placeholder="Phone Number"
                        value="<?//= isset($user['userPhoneNumber']) ? set_value('userPhoneNumber', $user['userPhoneNumber']) : ''; ?>"
                        required>
                </div>
            </div>

            <!-- Role Dropdown -->
            <div class="col-md-4">
                <div class="form-group">
                    <select name="roleId" class="form-control" required>
                        <option value="">Select Role</option>
                        <?php// foreach ($role as $r): ?>
                        <option value="<?php// echo $r['id']; ?>"
                            <?=// isset($user['roleId']) && $user['roleId'] == $r['id'] ? 'selected' : ''; ?>>
                            <?php //echo $r['name']; ?>
                            <!-- Ensure API returns 'role_name' -->
                        </option>
                        <?php// endforeach; ?>
                    </select>
                </div>
                <small>Current: <?//= isset($user['roleId']) ? $user['roleId'] : 'Not Set'; ?></small>
            </div>

            <!-- Hospital Dropdown -->
            <div class="col-md-4">
                <div class="form-group" id="hospitalField">
                    <?php //if ($_SESSION['role'] === 'SUPER_ADMIN'): ?>
                    <input type="hidden" name="hospitalId" class="form-control"
                        value="<?php// echo $_SESSION['hospital_id']; ?>" required>
                    <?php //else: ?>
                    <select name="hospitalId" class="form-control" required>
                        <option value="">Select Hospital</option>
                        <?php //foreach ($hospital_id as $hospital): ?>
                        <option value="<?php// echo $hospital['id']; ?>"
                            <?//= isset($user['hospitalId']) && $user['hospitalId'] == $hospital['id'] ? 'selected' : ''; ?>>
                            <?php //echo $hospital['hospitalName']; ?>
                        </option>
                        <?php //endforeach; ?>
                    </select>
                    <?php //endif; ?>
                </div>
                <small>Current: <?//= isset($user['hospitalId']) ? $user['hospitalId'] : 'Not Set'; ?></small>
            </div>

            <div class="col-md-4">
                <button type="submit" class="btn btn-success mt-2">Update User</button>
            </div>
        </div>

        <?php echo form_close(); ?>
    </div>
</section>
