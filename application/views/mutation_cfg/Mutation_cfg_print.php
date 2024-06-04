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
    <h3 align="center">DATA Cfg Mutation</h3>
    <h4>Tanggal Cetak : <?= date("d/M/Y");?> </h4>
    <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Idmutasi</th>
		<th>Type</th>
		<th>Title</th>
		<th>Keterangan</th>
		<th>Status</th>
		
            </tr><?php
            foreach ($mutation_cfg_data as $mutation_cfg)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $mutation_cfg->idmutasi ?></td>
		      <td><?php echo $mutation_cfg->type ?></td>
		      <td><?php echo $mutation_cfg->title ?></td>
		      <td><?php echo $mutation_cfg->keterangan ?></td>
		      <td><?php echo $mutation_cfg->status ?></td>	
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