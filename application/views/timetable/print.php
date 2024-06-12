<style>
    .subject-name {
        font-size: 0.75em;
        /* Ukuran teks h6 */
    }

    .subject-fullname {
        font-size: 0.85em;
        /* Ukuran teks h5 */
    }

    @media print {
        .no-print {
            display: none;
        }
    }

    thead th,
    tfoot td {
        background-color: #f2f2f2;
        /* Warna latar belakang untuk thead dan tfoot */
    }

    tbody td:first-child {
        background-color: #f2f2f2;
        /* Warna latar belakang untuk kolom pertama */
        font-weight: bold;
        /* Menebalkan teks di kolom pertama */
        text-align: center;
        /* Rata kiri teks di kolom pertama */
        vertical-align: middle;
    }

    tbody td.day-column {
        vertical-align: middle;
        /* Vertikal rata tengah isi kolom */
    }
</style>
<div class="row">
    <div class="col-md-3">
    </div>
    <div class="col-md-12">
        <div class="box direct-chat box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Daftar Mata Pelajaran</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" onclick="location.href='<?= base_url('timetable') ?>';" title="Back">
                        <i class=" fas fa-reply"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" onclick="location.reload()" title="Refresh">
                        <i class="fa fa-refresh"></i></button>
                </div>
            </div>
            <form id="schedule-form" method="post" action="<?= site_url('timetable/save_timetable') ?>">
                <div class="box-body">
                    <div class="col-md-12 no-print">
                        <?php
                        $segment1 = $this->uri->segment(3);
                        ?>
                        <input type="hidden" name="idtimetable" id="idtimetable" class="form-control" placeholder="Idtimetable" value="<?= $segment1; ?>" />
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="select-day">Pilih Hari:</label>
                                    <select id="select-day" class="form-control select2" style="width: 100%;">
                                        <option value="all">Semua Hari</option>
                                        <?php
                                        $days = ['SABTU', 'MINGGU', 'SENIN', 'SELASA', 'RABU', 'KAMIS', 'JUMAT'];
                                        foreach ($days as $index => $day) {
                                            echo "<option value='day-$index'>$day</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="select-class">Pilih Tingkat Kelas:</label>
                                    <select id="select-class" class="form-control select2" style="width: 100%;">
                                        <option value="all">Semua Kelas</option>
                                        <?php
                                        foreach ($jenjang as $class) {
                                            echo "<option value='$class->jenjang'>$class->jenjang</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="direct-chat-messages">
                        <!-- <div class="table-container"> -->
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center" rowspan="2" width="80px">Kelas</th>
                                    <?php
                                    foreach ($days as $index => $day) {
                                        echo "<th class='text-center day-header day-$index' colspan='10'>$day</th>";
                                    }
                                    ?>
                                </tr>
                                <tr>
                                    <?php
                                    foreach ($days as $index => $day) {
                                        for ($i = 1; $i <= 10; $i++) {
                                            echo "<th class='text-center day-column day-$index' >Jam $i</th>";
                                        }
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($classes as $class) : ?>
                                    <tr class="<?= $class->jenjang ?>">
                                        <td class="text-center"><?= $class->name_class ?></td>
                                        <?php
                                        for ($dayIndex = 0; $dayIndex < 6; $dayIndex++) { // 6 hari dalam seminggu
                                            for ($i = 1; $i <= 10; $i++) {
                                                $selected_subject = '';
                                                foreach ($schedule as $s) {
                                                    if ($s->class_id == $class->idclass && $s->day == $days[$dayIndex] && $s->position == $i) {
                                                        $selected_subject = $s->lesson_id;
                                                        break;
                                                    }
                                                }
                                                echo "<td class='text-center day-column day-$dayIndex' width='80px'>";
                                                if ($selected_subject == 'Istirahat' || $selected_subject == 'Pulang') {
                                                    echo "<div><h5>{$selected_subject}</h5></div>";
                                                } else {
                                                    foreach ($subjects[$class->idclass] as $subject) {
                                                        if ($subject->idlesson == $selected_subject) {
                                                            echo "<div><h5>{$subject->full_name}</h5><h6>{$subject->name}</h6></div>";
                                                            break;
                                                        }
                                                    }
                                                }
                                                echo "</td>";
                                            }
                                        }
                                        ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box-footer">
                    <button class="btn btn-primary no-print" onclick="window.print()">Cetak</button>
                    <!-- <button type="submit" class="btn btn-primary">Simpan Jadwal</button> -->
                </div>
            </form>
        </div>
    </div>
</div>