<!-- MODAL FORM -->
<div class="modal fade" id="ModalaForm" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" onclick="clear_data()" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Tambah Pelajaran</h3>
            </div>
            <form class="form-horizontal" method="post" id="form">
                <div class="modal-body">
                    <!-- <div class="form-group">
                        <label class="control-label col-xs-3">Idlesson</label>
                        <div class="col-xs-9">
                            </div>
                        </div> -->
                    <input type="hidden" name="idlesson" id="idlesson" class="form-control" placeholder="Idlesson" />
                    <div class="form-group">
                        <label class="control-label col-xs-3">Periode</label>
                        <div class="col-xs-9">
                            <?= cmb_where('period_id', 'period', 'name_period', 'name_period', 'name_period', 'status'); ?>
                            <!-- <input type="text" name="period_id" id="period_id" class="form-control" placeholder="Period Id" /> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Guru</label>
                        <div class="col-xs-9">
                            <?= cmb_where('employee_id', 'employee', 'name', 'numberid', 'employee_id', 'status'); ?>
                            <!-- <input type="text" name="employee_id" id="employee_id" class="form-control" placeholder="Employee Id" /> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Kelas</label>
                        <div class="col-xs-9">
                            <select name="class_id" class="form-control select2" style="width: 100%;" id="class_id">
                                <option value="" selected disabled hidden>- Pilih Kelas -</option>
                            </select>
                            <!-- <input type="text" name="subject_id" id="subject_id" class="form-control" placeholder="Subject Id" /> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Mata Pelajaran</label>
                        <div class="col-xs-9">
                            <select name="subject_id" class="form-control select2" style="width: 100%;" id="subject_id">
                                <option value="" selected disabled hidden>- Pilih Mata Pelajaran -</option>
                            </select>
                            <!-- <input type="text" name="subject_id" id="subject_id" class="form-control" placeholder="Subject Id" /> -->
                        </div>
                    </div>
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