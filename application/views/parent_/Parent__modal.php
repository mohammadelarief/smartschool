<!-- MODAL FORM -->
<div class="modal fade" id="ModalaForm" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" onclick="clear_data()" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Tambah Parent</h3>
            </div>
            <form class="form-horizontal" method="post" id="form">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-xs-3">Idparent</label>
                        <div class="col-xs-9">
                            <input type="text" name="idparent" id="idparent" class="form-control" placeholder="Idparent" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Name</label>
                        <div class="col-xs-9">
                            <input type="text" name="name" id="name" class="form-control" placeholder="Name" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Gender</label>
                        <div class="col-xs-9">
                            <input type="text" name="gender" id="gender" class="form-control" placeholder="Gender" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Nik</label>
                        <div class="col-xs-9">
                            <input type="text" name="nik" id="nik" class="form-control" placeholder="Nik" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Work</label>
                        <div class="col-xs-9">
                            <input type="text" name="work" id="work" class="form-control" placeholder="Work" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Education</label>
                        <div class="col-xs-9">
                            <input type="text" name="education" id="education" class="form-control" placeholder="Education" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Earnings</label>
                        <div class="col-xs-9">
                            <input type="text" name="earnings" id="earnings" class="form-control" placeholder="Earnings" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Phone Number</label>
                        <div class="col-xs-9">
                            <input type="text" name="phone_number" id="phone_number" class="form-control" placeholder="Phone Number" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Position</label>
                        <div class="col-xs-9">
                            <input type="text" name="position" id="position" class="form-control" placeholder="Position" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Status</label>
                        <div class="col-xs-9">
                            <input type="text" name="status" id="status" class="form-control" placeholder="Status" />
                        </div>
                    </div>
                    <input type="hidden" name="id" />
                </div>

                <div class="modal-footer">
                    <button class="btn" onclick="clear_data()" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    <input type="hidden" name="actions" id="actions" class="btn btn-success" value="Add" />
                    <input type="submit" name="action" id="action" class="btn btn-success" value="Add" />
                </div>
            </form>
        </div>
    </div>
</div>
<!--END MODAL FORM-->