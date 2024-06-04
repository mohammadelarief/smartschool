<!-- MODAL FORM -->
<div class="modal fade" id="ModalaForm" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" onclick="clear_data()" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Tambah Periode</h3>
            </div>
            <form class="form-horizontal" method="post" id="form">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-xs-3">Name Periode</label>
                        <div class="col-xs-9">
                            <input type="text" name="name_period" id="name_period" class="form-control" placeholder="Name Period" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Start Date</label>
                        <div class="col-xs-9">
                            <input type="date" name="start_date" id="start_date" class="form-control" placeholder="Start Date" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">End Date</label>
                        <div class="col-xs-9">
                            <input type="date" name="end_date" id="end_date" class="form-control" placeholder="End Date" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Status</label>
                        <div class="col-xs-9">
                            <input type="text" name="status" id="status" class="form-control" placeholder="Status" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Description</label>
                        <div class="col-xs-9">
                            <input type="text" name="description" id="description" class="form-control" placeholder="Description" />
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