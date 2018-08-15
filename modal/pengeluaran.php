<script type="text/javascript">


    App.datatables();
    $('#example-datatable').dataTable({
        columnDefs: [ { orderable: false, targets: [ 4 ] } ],
        pageLength: 10,
        lengthMenu: [[5, 10, 20], [5, 10, 20]]
    });
    $('.dataTables_filter input').attr('placeholder', 'Search');

</script>
            <?php
            include "../config.php";
            $bulan = $_GET['date'];
            $sql = $conn->query("
            SELECT
            id_pengeluaran id, tanggal tgl, keterangan, total,
            DATE_FORMAT(tanggal,'%d-%m-%Y') tanggal
            FROM
            pengeluaran
            where date_format(tanggal,'%m-%Y') = '$bulan'");
            ?>
    <div class="table-responsive">
        <table id="example-datatable" class="table table-striped table-bordered table-vcenter">
            <thead>
                <tr>
                    <th class="text-center" style="width: 50px;">NO</th>
                    <th>TANGGAL</th>
                    <th>KETERANGAN</th>
                    <th>TOTAL</th>
                    <th class="text-center" style="width: 75px;"><i class="fa fa-flash"></i></th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no=0;
                $total=0;
                while($r=$sql->fetch_assoc()){$no++;
                $total += $r['total'];
                ?>
                <tr>
                    <td class="text-center"><?php echo $no;?></td>
                    <td><?php echo $r['tanggal']; ?></td>
                    <td><?php echo nl2br($r['keterangan']);?></td>
                    <td class="text-right">Rp. <?php echo number_format($r['total']);?></td>
                    <td>
                    <?php
                    $sql1 = $conn->query("
                    SELECT * FROM kas 
                    where date_format(tanggal,'%m-%Y') = date_format(date_add('".$r['tgl']."',INTERVAL 1 MONTH), '%m-%Y') ");
 
                    if ((substr($r['tanggal'], 3,2) == date('m')) && $sql1->num_rows == 0 ) { 
                    ?>
                        <a href="javascript:void(0)" data-toggle="tooltip" title="Edit User" class="btn btn-effect-ripple btn-xs btn-success" onclick="lihat(<?php echo $r['id'];?>)"><i class="fa fa-pencil"></i></a>
                        <a href="javascript:void(0)" data-toggle="tooltip" title="Delete User" class="btn btn-effect-ripple btn-xs btn-danger" onclick="hapus(<?php echo $r['id'];?>)"><i class="fa fa-times"></i></a>
                    <?php } ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-center">TOTAL PENGELUARAN</th>
                    <th class="text-right">Rp. <?php echo number_format($total); ?></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>
