<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-users"></i> Users</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <button class="btn btn-primary addUser" data-toggle="modal" data-target="#modal_addManager" type="button"><i class="fa fa-plus-circle"></i> Add Manager</button>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <table id="tbl_users" class="table table-hover table-striped tbl_users">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Office</th>
                                <th>Division</th>
                                <th>Phone</th>
                                <th>User Type</th>
                                <th>User Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- =============================Add Manager Modal================================= -->
<div id="modal_addManager" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="icon-user"></i> Add Manager</h4>
                
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                    <form class="form_addUser" action="" method="post">
                    <div class="form-body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Username</label>
                                    <input type="text" class="form-control" name="username" placeholder="Enter Username Here">
                                    <small class="err"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Password</label>
                                    <input type="password" class="form-control" name="password" placeholder="Enter Password Here">
                                    <small class="err"></small>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 text-center">
                            <button type="submit" class="btn btn-primary btn-sm btn-submits"><i class="fa fa-user"></i> Add Manager</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
</div>
      <!-- =============================Update User Modal================================= -->
<div id="modal_updateUser" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="icon-user"></i> Update User</h4>
                
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                    <form class="form_updateUser" action="" method="post">
                    <div class="form-body">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">First Name <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control" name="firstname" placeholder="Enter First Name Here" value="">
                                    <small class="err"></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Middle Name</label>
                                    <input type="text" class="form-control" name="middlename" placeholder="Enter Middle Name Here" value="">
                                    <small class="err"></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Last Name <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control" name="lastname" placeholder="Enter Last Name Here" value="">
                                    <small class="err"></small>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Address <sup>(Barangay / Municipality / Province) <i class="text-danger">*</i></sup></label>
                                    <input type="text" class="form-control" name="address" placeholder="Enter Address Here">
                                    <small class="err"></small>
                                </div>
                            </div>
                        </div>
                        <br />

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Username <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control" name="username" placeholder="Enter Username Here">
                                    <small class="err"></small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Email</label>
                                    <input type="email" class="form-control" name="email" placeholder="Enter Email Here">
                                    <small class="err"></small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Phone</label>
                                    <input type="text" class="form-control" name="phone" placeholder="Enter Phone Number Here">
                                    <small class="err"></small>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Password ( Optional )</label>
                                    <input type="password" class="form-control" name="password" placeholder="Enter Password Here">
                                    <small class="err"></small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Office <sup class="text-danger">*</sup></label>
                                    <select name="" class="form-control">
                                        <option value="" selected> - Please select - </option>
                                        <option value="MDRRMO">MDRRMO</option>
                                        <option value="MDRRMC">MDRRMC</option>
                                    </select>
                                    <small class="err"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Division <sup class="text-danger">*</sup></label>
                                    <select name="" class="form-control">
                                        <option value="" selected> - Please select - </option>
                                        <option value="General">General</option>
                                        <option value="Admin & Finance">Admin & Finance</option>
                                        <option value="Training & Planning">Training & Planning</option>
                                        <option value="Operations">Operations</option>
                                    </select>
                                    <small class="err"></small>
                                </div>
                            </div>

                        </div>
                        

                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 text-center">
                            <input type="hidden" name="user_id">
                            <input type="hidden" name="user_type">
                            <button type="submit" class="btn btn-primary btn-sm btn-submits"><i class="fa fa-user"></i> Update User</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>

</div>