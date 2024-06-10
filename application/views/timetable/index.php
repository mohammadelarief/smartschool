<style>
    .day-column {
        display: none;
    }
</style>
<div class="row">
    <div class="col-md-3">
    </div>
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Daftar Mata Pelajaran</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" onclick="location.reload()" title="Refresh">
                        <i class="fa fa-refresh"></i></button>
                </div>
            </div>

            <div class="box-body">
                <div class="col-md-12">
                    <form id="schedule-form" method="post" action="<?= site_url('timetable/save_timetable') ?>">
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
                                    echo "<th class='text-center day-column day-$index'>Jam $i</th>";
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
                                        // echo $selected_subject;
                                        echo "<td class='day-column day-$dayIndex'>
                                                <select class='form-control select2' style='width: 100%;' name='schedule[{$class->idclass}][$dayIndex][$i]'>
                                                    <option value='' selected disabled hidden></option>";
                                        foreach ($subjects[$class->idclass] as $subject) {
                                            $selected = ($subject->idlesson == $selected_subject) ? 'selected' : '';
                                            echo "<option value='{$subject->idlesson}' $selected>{$subject->full_name} | {$subject->name}</option>";
                                        }
                                        echo "  </select>
                                              </td>";
                                    }
                                }
                                ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary">Simpan Jadwal</button>
                </form>
            </div>
        </div>
    </div>
</div>