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
    <h3 align="center">DATA Mutation</h3>
    <h4>Tanggal Cetak : <?= date("d/M/Y");?> </h4>
    <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Idmutation</th>
		<th>Cfg Mutation Id</th>
		<th>Student Id</th>
		<th>Person Id</th>
		<th>New Classes</th>
		<th>Old Classes</th>
		<th>Date Mutation</th>
		<th>Date Process</th>
		<th>Keterangan</th>
		<th>User Id</th>
		<th>Status</th>
		
            </tr><?php
            foreach ($mutation_data as $mutation)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $mutation->idmutation ?></td>
		      <td><?php echo $mutation->cfg_mutation_id ?></td>
		      <td><?php echo $mutation->student_id ?></td>
		      <td><?php echo $mutation->person_id ?></td>
		      <td><?php echo $mutation->new_classes ?></td>
		      <td><?php echo $mutation->old_classes ?></td>
		      <td><?php echo $mutation->date_mutation ?></td>
		      <td><?php echo $mutation->date_process ?></td>
		      <td><?php echo $mutation->keterangan ?></td>
		      <td><?php echo $mutation->user_id ?></td>
		      <td><?php echo $mutation->status ?></td>	
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