<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Daftar Siswa</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-box-tool" onclick="location.reload()" title="Refresh">
            <i class="fa fa-refresh"></i></button>
        </div>
      </div>

      <div class="box-body">
        <?php (isset($filter) ? $this->load->view($filter) : ""); ?>

        <form id="myform" method="post" onsubmit="return false">

          <div class="row" style="margin-bottom: 10px">
            <div class="col-xs-12 col-md-4"><a href="#" id="add_button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalaForms"><span class="fa fa-plus"></span> Create</a></div>
            <div class="col-xs-12 col-md-4 text-center">
              <div style="margin-top: 4px" id="message">

              </div>
            </div>
            <div class="col-xs-12 col-md-4 text-right">
              <a href="#" id="import_button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#ModalaImport"><span class="fas fa-cloud-upload-alt"></span> Import</a>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered table-striped" id="mytable" style="width:100%">
              <thead>
                <tr>
                  <th width=""></th>
                  <th class="text-center" width="10px">No</th>
                  <th class="text-center">NIS</th>
                  <th class="text-center">Nama</th>
                  <th class="text-center">Gender</th>
                  <th class="text-center">Kelas</th>
                  <th class="text-center">Status</th>

                  <th class="text-center" width="80px">Action</th>
                </tr>
              </thead>


            </table>
          </div>
          <!-- <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i> Hapus Data Terpilih</button> -->
        </form>

      </div>
    </div>
  </div>
</div>