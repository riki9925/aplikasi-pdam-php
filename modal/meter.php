<script type="text/javascript">


    App.datatables();
    $('#example-datatable').dataTable({
        columnDefs: [ { orderable: false, targets: [ 7 ] } ],
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
            pegawai.nama pegawai,
            pelanggan.nama pelanggan,
            meter.sekarang,
            meter.jumlah,
            meter.st,
            meter.id_meter id,
            DATE_FORMAT(meter.tanggal,'%d-%m-%Y') tanggal
            FROM
            meter
            LEFT JOIN pegawai ON pegawai.id_peg = meter.id_peg
            LEFT JOIN pelanggan ON pelanggan.id_pel = meter.id_pel
            where date_format(meter.tanggal,'%m-%Y') = '$bulan'");
            ?>
    <div class="block-title">
        <h2>Data Pelanggan</h2>
    </div>
    <div class="table-responsive">
        <table id="example-datatable" class="table table-striped table-bordered table-vcenter">
            <thead>
                <tr>
                    <th class="text-center" style="width: 50px;">NO</th>
                    <th>PELANGGAN</th>
                    <th>PEGAWAI</th>
                    <th>TANGGAL</th>
                    <th>TOTAL</th>
                    <th>BULAN INI</th>
                    <th>STATUS</th>
                    <th class="text-center" style="width: 75px;"><i class="fa fa-flash"></i></th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no=0;
                while($r=$sql->fetch_assoc()){$no++;
                ?>
                <tr>
                    <td class="text-center"><?php echo $no;?></td>
                    <td><?php echo $r['pelanggan'];?></td>
                    <td><?php echo $r['pegawai'];?></td>
                    <td><?php echo $r['tanggal'];?></td>
                    <td><?php echo number_format($r['sekarang']);?> /M3</td>
                    <td><?php echo number_format($r['jumlah']);?> /M3</td>
                    <td>
                    <?php if ($r['st'] == '1') { ?>
                        <span class="label label-success">Lunas</span>
                    <?php }else{ ?>
                        <span class="label label-danger">Pending</span>
                    <?php } ?>
                    </td>
                    <td>
                    <?php if ($r['st'] == '1') { ?>
                        -
                    <?php }else{ ?>
                        <a href="javascript:void(0)" data-toggle="tooltip" title="Edit User" class="btn btn-effect-ripple btn-xs btn-success" onclick="lihat(<?php echo $r['id'];?>)"><i class="fa fa-pencil"></i></a>
                        <a href="javascript:void(0)" data-toggle="tooltip" title="Delete User" class="btn btn-effect-ripple btn-xs btn-danger" onclick="hapus(<?php echo $r['id'];?>)"><i class="fa fa-times"></i></a>
                    <?php } ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
