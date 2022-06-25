<?php
    $division = array('General', 'Admin & Finance', 'Training & Planning', 'Operations');
    $category = array('General', 'Admin & Finance', 'Training & Planning', 'Operations');
?>

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-briefcase"></i> Documents</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <a href="<?php echo base_url('documents/scanbarcode'); ?>" class="btn btn-primary"><i class="fa fa-barcode"></i> Scan Barcode</a> &nbsp;&nbsp;
            <button class="btn btn-primary addDocument" data-toggle="modal" data-target="#modal_addDocument" type="button"><i class="fa fa-plus-circle"></i> Add Document</button>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">Filter Division:</label>
                <select name="byDivision" class="form-control byDivision">
                    <option value="All" selected>All</option>
                    <?php foreach($division as $key => $value) { ?>
                    <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">Filter Category:</label>
                <input type="text" class="form-control byCategory" name="byCategory">
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <button type="button" name="filterBtn" class="btn btn-primary filterBtn"><i class="fa fa-filter"></i> Filter</button>
            </div>
        </div>

    </div><br>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <table id="tbl_documents" class="table table-hover table-striped tbl_documents">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Divsion</th>
                                <th>Category</th>
                                <th>Date Added</th>
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

<!-- =============================Add Document Modal================================= -->
<div id="modal_addDocument" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="icon-user"></i> Add Document</h4>
                
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                    <form class="form_addDocument" action="" method="post">
                    <div class="form-body">

                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="title" class="control-label">Title</label>
                                    <input type="text" class="form-control title" name="title">
                                    <small class="err"></small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="docfile" class="control-label">Import Document File</label>
                                    <input type="file" class="form-control docfile" id="docfile" name="docfile" accept="image/*,.pdf,.zip,.doc,.docx,.xls,.xlsx">
                                    <small class="err"></small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="division" class="control-label">Division</label>
                                    <select name="division" class="form-control division">
                                        <option value="" selected hidden> - Please select - </option>
                                        <?php foreach($division as $key => $value) { ?>
                                        <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                        <?php } ?>
                                    </select>
                                    <small class="err"></small>
                                </div>
                            </div>
                            
                        </div>

                        <div class="row divContainer"></div>

                    </div>
                    <hr>
                    <div class="form-group">
                        <div class="col-sm-12 text-center">
                            <button type="submit" class="btn btn-primary btn-sm btn-submits"><i class="fa fa-file"></i> Add Document</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
</div>

<!-- =============================Update Document Modal================================= -->
<div id="modal_updateDocument" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="icon-user"></i> Update Document</h4>
                
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                    <form class="form_updateDocument" action="" method="post">
                    <div class="form-body">

                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="title" class="control-label">Title</label>
                                    <input type="text" class="form-control title" name="title">
                                    <small class="err"></small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="docfile" class="control-label">Import Document File</label>
                                    <input type="file" class="form-control docfile" id="docfile" name="docfile" accept="image/*,.pdf,.zip,.doc,.docx,.xls,.xlsx">
                                    <small class="err"></small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="division" class="control-label">Division</label>
                                    <select name="division" class="form-control division">
                                        <option value="" selected hidden> - Please select - </option>
                                        <?php foreach($division as $key => $value) { ?>
                                        <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                        <?php } ?>
                                    </select>
                                    <small class="err"></small>
                                </div>
                            </div>
                            
                        </div>

                        <div class="row divContainer"></div>

                    </div>
                    <hr>
                    <div class="form-group">
                        <div class="col-sm-12 text-center">
                            <input type="hidden" name="file_id">
                            <input type="hidden" name="file_path">
                            <button type="submit" class="btn btn-primary btn-sm btn-submits"><i class="fa fa-file"></i> Add Document</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
</div>