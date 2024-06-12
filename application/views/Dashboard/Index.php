<!-- Default box -->
<div class="row">
  <div class="col-xs-12">
    <div class="callout callout-success">
      <h4><?= $tapel['periode'] ?></h4>

      <p><?= $tapel['semester'] ?></p>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-3 col-xs-6">
    <div class="small-box bg-yellow">
      <div class="inner">
        <h3><?= $count['pegawai']['jml'] ?></h3>

        <p><?= $count['pegawai']['text']; ?></p>
      </div>
      <div class="icon">
        <i class="fas fa-user-tie"></i>
      </div>
      <a href="<?= $count['pegawai']['url']; ?>" class="small-box-footer">
        More info <i class="fa fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>
  <div class="col-lg-3 col-xs-6">
    <div class="small-box bg-aqua">
      <div class="inner">
        <h3><?= $count['siswa']['jml'] ?></h3>

        <p><?= $count['siswa']['text']; ?></p>
      </div>
      <div class="icon">
        <i class="fas fa-user-check"></i>
      </div>
      <a href="<?= $count['siswa']['url']; ?>" class="small-box-footer">
        More info <i class="fa fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>
  <div class="col-lg-3 col-xs-6">
    <div class="small-box bg-teal">
      <div class="inner">
        <h3><?= $count['kelas']['jml'] ?></h3>

        <p><?= $count['kelas']['text']; ?></p>
      </div>
      <div class="icon">
        <i class="fa fa-fw fa-building"></i>
      </div>
      <a href="<?= $count['kelas']['url']; ?>" class="small-box-footer">
        More info <i class="fa fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>
</div>