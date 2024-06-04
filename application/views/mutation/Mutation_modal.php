<!-- MODAL FORM -->
<div class="modal fade" id="ModalaForm" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" onclick="clear_data()" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Tambah Mutation</h3>
            </div>
            <form class="form-horizontal" method="post" id="form">
                <div class="modal-body">
                    <input type="hidden" name="idmutation" id="idmutation" class="form-control" placeholder="Idmutation" />
                    <input type="hidden" name="idmutation_old" id="idmutation_old" class="form-control" placeholder="Idmutation" />
                    <input type="hidden" name="cfg_mutation_id" id="cfg_mutation_id" class="form-control" placeholder="Cfg Mutation Id" />
                    <input type="hidden" name="student_id" id="student_id" class="form-control" placeholder="Student Id" />


                    <input type="hidden" name="person_id" id="person_id" class="form-control" placeholder="Person Id" />

                    <input type="hidden" name="new_classes" id="new_classes" class="form-control" placeholder="New Classes" />
                    <input type="hidden" name="old_classes" id="old_classes" class="form-control" placeholder="Old Classes" />
                    <input type="hidden" name="date_process" id="date_process" class="form-control" placeholder="Date Process" />

                    <div class="form-group">
                        <label class="control-label col-xs-3">Date Mutation</label>
                        <div class="col-xs-9">
                            <input type="date" name="date_mutation" id="date_mutation" class="form-control" placeholder="Date Mutation" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Keterangan</label>
                        <div class="col-xs-9">
                            <textarea name="keterangan" id="keterangan" rows="3" class="form-control" placeholder="Keterangan"></textarea>
                        </div>
                    </div>
                    <input type="hidden" name="user_id" id="user_id" class="form-control" placeholder="User Id" />
                    <input type="hidden" name="status" id="status" class="form-control" placeholder="Status" />
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