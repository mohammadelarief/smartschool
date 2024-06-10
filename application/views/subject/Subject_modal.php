<!-- MODAL FORM -->
<div class="modal fade" id="ModalaForm" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" onclick="clear_data()" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Tambah Mata Pelajaran</h3>
            </div>
            <form class="form-horizontal" method="post" id="form">
                <div class="modal-body">
                    <!-- <div class="form-group">
                        <label class="control-label col-xs-3">Idsubject</label>
                        <div class="col-xs-9">
                            </div>
                        </div> -->
                    <input type="hidden" name="idsubject" id="idsubject" class="form-control" placeholder="Idsubject" readonly />
                    <div class="form-group">
                        <label class="control-label col-xs-3">Periode</label>
                        <div class="col-xs-9">
                            <?= cmb_where('period_id', 'period', 'name_period', 'name_period', 'name_period', 'status'); ?>
                            <!-- <input type="text" name="period_id" id="period_id" class="form-control" placeholder="Period Id" /> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Kode Mapel</label>
                        <div class="col-xs-9">
                            <input type="text" name="nick_name" id="nick_name" class="form-control" placeholder="Nick Name" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Mata Pelajaran</label>
                        <div class="col-xs-9">
                            <input type="text" name="full_name" id="full_name" class="form-control" placeholder="Full Name" />
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