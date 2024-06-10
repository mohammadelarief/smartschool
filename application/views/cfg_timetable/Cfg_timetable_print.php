<!DOCTYPE html>
<html>
<head>
    <title>Tittle</title>
    <style type="text/css" media="print">
    @page {
        margin: 0;  /* this affects the margin in the printer settings */
    }
      table{
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
      }
      table th{
          -webkit-print-color-adjust:exact;
        border: 1px solid;

                padding-top: 11px;
    padding-bottom: 11px;
    background-color: #a29bfe;
      }
   table td{
        border: 1px solid;

   }
        </style>
</head>
<body>
    <h3 align="center">DATA Cfg Timetable</h3>
    <h4>Tanggal Cetak : <?= date("d/M/Y");?> </h4>
    <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Idtimetable</th>
		<th>Period Id</th>
		<th>Semester Id</th>
		<th>Keterangan</th>
		<th>Status</th>
		
            </tr><?php
            foreach ($cfg_timetable_data as $cfg_timetable)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $cfg_timetable->idtimetable ?></td>
		      <td><?php echo $cfg_timetable->period_id ?></td>
		      <td><?php echo $cfg_timetable->semester_id ?></td>
		      <td><?php echo $cfg_timetable->keterangan ?></td>
		      <td><?php echo $cfg_timetable->status ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
</body>
<script type="text/javascript">
      window.print()
    </script>
</html>