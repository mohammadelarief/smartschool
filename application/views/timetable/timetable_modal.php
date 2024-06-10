<!-- MODAL FORM -->
<div class="modal fade" id="ModalaForm" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" onclick="clear_data()" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Tambah Konfigurasi Jadwal</h3>
            </div>
            <form class="form-horizontal" method="post" id="form">
                <div class="modal-body">
                    <!-- <div class="form-group">
                        <label class="control-label col-xs-3">Idtimetable</label>
                        <div class="col-xs-9">
                            </div>
                        </div> -->
                    <input type="hidden" name="idtimetable" id="idtimetable" class="form-control" placeholder="Idtimetable" />
                    <div class="form-group">
                        <label class="control-label col-xs-3">Period</label>
                        <div class="col-xs-9">
                            <?= cmb_where('period_id', 'period', 'name_period', 'name_period', 'name_period', 'status'); ?>
                            <!-- <input type="text" name="period_id" id="period_id" class="form-control" placeholder="Period Id" /> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Semester</label>
                        <div class="col-xs-9">
                            <select name="semester_id" class="form-control select2" id="semester_id">
                                <option value="" selected disabled hidden>- Pilih Semester -</option>
                            </select>
                            <!-- <input type="text" name="semester_id" id="semester_id" class="form-control" placeholder="Semester Id" /> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Keterangan</label>
                        <div class="col-xs-9">
                            <textarea name="keterangan" id="keterangan" rows="3" class="form-control" placeholder="Keterangan"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Status</label>
                        <div class="col-xs-9">
                            <?php
                            $options = array(
                                1 => 'Aktif',
                                0 => 'Nonaktif'
                            );
                            echo select_input('status', 'status', $options);
                            ?>
                            <!-- <input type="text" name="status" id="status" class="form-control" placeholder="Status" /> -->
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