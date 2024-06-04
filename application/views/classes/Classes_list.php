<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">List Class</h3>
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
            <div class="col-xs-12 col-md-4"><a href="#" id="add_button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalaForm"><span class="fa fa-plus"></span> Create</a></div>
            <div class="col-xs-12 col-md-4 text-center">
              <div style="margin-top: 4px" id="message">

              </div>
            </div>
            <div class="col-xs-12 col-md-4 text-right">

            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered table-striped" id="mytable" style="width:100%">
              <thead>
                <tr>
                  <th width=""></th>
                  <th width="10px">No</th>
                  <!-- <th>Idclass</th> -->
                  <th>Periode</th>
                  <th>Kelas</th>
                  <!-- <th>Wali Kelas</th> -->
                  <th>Jenjang</th>
                  <th>Tingkat</th>
                  <th>Rombel</th>
                  <th>Kapasitas</th>
                  <th>Terisi</th>
                  <th>L</th>
                  <th>P</th>
                  <th>Tidak Aktif</th>
                  <th>Status</th>

                  <th width="80px">Action</th>
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