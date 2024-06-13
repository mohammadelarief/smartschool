<div class="row">
  <div class="col-xs-12">
    <a href="<?= base_url('employment') ?>" class="btn btn-sm btn-success"><span class="fas fa-users-cog"></span> Data Kepegawaian</a>
    <a href="<?= base_url('employment/group') ?>" class="btn btn-sm btn-info"><span class="fas fa-users-cog"></span> Data Group</a>
    <a href="<?= base_url('employment/status') ?>" class="btn btn-sm btn-warning"><span class="fas fa-users-cog"></span> Data Status</a>
  </div>
</div>
<br>
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Daftar Pegawai</h3>
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
            <div class="col-xs-12 col-md-4"></div>
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
                  <th>Periode</th>
                  <th>NIP Internal</th>
                  <th>Nama</th>
                  <th>Status Kepegawaian</th>
                  <th>Jenis Kelamin</th>
                  <th>Status</th>

                </tr>
              </thead>


            </table>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>