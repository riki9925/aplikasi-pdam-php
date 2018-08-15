<script type="text/javascript">


    App.datatables();
    $('#example-datatable').dataTable({
        dom: 'Bfrtip',
        buttons: [
        {
           extend: 'copy',
           footer: true
        },
        {
           extend: 'pdf',
           footer: true
        },
        {
           extend: 'excel',
           footer: true
        },
        {
           extend: 'print',
           footer: true
        }
        ],
        pageLength: 10,
        lengthMenu: [[5, 10, 20], [5, 10, 20]],
        footer: true
    });
    $('.dataTables_filter input').attr('placeholder', 'Search');

</script>
            <?php
            include "../config.php";

            $no=1;
            $pemasukan = 0;
            $pengeluaran = 0;

            $bulan = $_GET['date'];
            $sql1 = $conn->query("SELECT date_format(tanggal,'%d-%m-%Y') tanggal, keterangan, total from kas where date_format(tanggal,'%m-%Y') = '$bulan'");
            $r1=$sql1->fetch_assoc();
            $pemasukan +=$r1['total'];

            $sql2 = $conn->query("SELECT date_format(tanggal,'%d-%m-%Y') tanggal, sum(jumlah) total from pembayaran where date_format(tanggal,'%m-%Y') = '$bulan'");
            $r2=$sql2->fetch_assoc();
            $pemasukan +=$r2['total'];

            $sql3 = $conn->query("SELECT date_format(tanggal,'%d-%m-%Y') tanggal, sum(beban) total from pembayaran where date_format(tanggal,'%m-%Y') = '$bulan'");
            $r3=$sql3->fetch_assoc();
            $pemasukan +=$r3['total'];

            $sql4 = $conn->query("SELECT date_format(tanggal,'%d-%m-%Y') tanggal, keterangan, total from pemasukan where date_format(tanggal,'%m-%Y') = '$bulan'");

            $sql5 = $conn->query("SELECT date_format(tanggal,'%d-%m-%Y') tanggal, keterangan, total from pengeluaran where date_format(tanggal,'%m-%Y') = '$bulan'");

            ?>
    <div class="table-responsive">
        <table id="example-datatable" class="table table-striped table-bordered table-vcenter">
            <thead>
                <tr>
                    <th class="text-center" style="width: 50px;">NO</th>
                    <th>TANGGAL</th>
                    <th>KETERANGAN</th>
                    <th>PEMASUKKAN</th>
                    <th>PENGELUARAN</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center"><?php echo $no++;?></td>
                    <td><?php echo $r1['tanggal'];?></td>
                    <td><?php echo $r1['keterangan'];?></td>
                    <td class="text-right">Rp. <?php echo number_format($r1['total']);?></td>
                    <td class="text-right">-</td>
                </tr>

                <tr>
                    <td class="text-center"><?php echo $no++;?></td>
                    <td><?php echo $r1['tanggal'];?></td>
                    <td>PEMBAYARAN AIR BULAN INI</td>
                    <td class="text-right">Rp. <?php echo number_format($r2['total']);?></td>
                    <td class="text-right">-</td>
                </tr>

                <tr>
                    <td class="text-center"><?php echo $no++;?></td>
                    <td><?php echo $r1['tanggal'];?></td>
                    <td>PENDAPATAN ADMIN BULAN INI</td>
                    <td class="text-right">Rp. <?php echo number_format($r3['total']);?></td>
                    <td class="text-right">-</td>
                </tr>
                <?php 
                while($r4=$sql4->fetch_assoc()){
                $pemasukan += $r4['total'];
                ?>
                <tr>
                    <td class="text-center"><?php echo $no;?></td>
                    <td><?php echo $r4['tanggal'];?></td>
                    <td><?php echo $r4['keterangan'];?></td>
                    <td class="text-right">Rp. <?php echo number_format($r4['total']);?></td>
                    <td class="text-right">-</td>
                </tr>
                <?php $no++; } ?>
                <?php 
                while($r5=$sql5->fetch_assoc()){
                $pengeluaran += $r5['total'];
                ?>
                    <td class="text-center"><?php echo $no;?></td>
                    <td><?php echo $r5['tanggal'];?></td>
                    <td><?php echo $r5['keterangan'];?></td>
                    <td class="text-right">-</td>
                    <td class="text-right">Rp. <?php echo number_format($r5['total']);?></td>
                <?php $no++;} ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-center">TOTAL</th>
                    <th class="text-right">Rp. <?php echo number_format($pemasukan); ?></th>
                    <th class="text-right">Rp. <?php echo number_format($pengeluaran); ?></th>
                </tr>
            </tfoot>
        </table>
    </div>
