<!-- MODAL FORM -->
<div class="modal fade" id="ModalaForm" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" onclick="clear_data()" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Tambah Cfg_mutation</h3>
            </div>
            <form class="form-horizontal" method="post" id="form">
                <div class="modal-body">
                    <input type="hidden" name="idmutasi" id="idmutasi" class="form-control" placeholder="Idmutasi" readonly />
                    <!-- <div class="form-group">
                        <label class="control-label col-xs-3">Idmutasi</label>
                        <div class="col-xs-9">
                        </div>
                    </div> -->
                    <div class="form-group">
                        <label class="control-label col-xs-3">Type</label>
                        <div class="col-xs-9">
                            <?php
                            $options = array(
                                'K' => 'Keluar',
                                'M' => 'Masuk'
                            );
                            echo select_input('type', 'type', $options);
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Title</label>
                        <div class="col-xs-9">
                            <input type="text" name="title" id="title" class="form-control" placeholder="Title" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Keterangan</label>
                        <div class="col-xs-9">
                            <input type="text" name="keterangan" id="keterangan" class="form-control" placeholder="Keterangan" />
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