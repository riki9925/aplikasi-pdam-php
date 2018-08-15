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
        lengthMenu: [[5, 10, 20], [5, 10, 20]]
    });
    $('.dataTables_filter input').attr('placeholder', 'Search');

</script>
            <?php
            include "../config.php";
            $bulan = $_GET['date'];
            $sql = $conn->query("
            SELECT
            pelanggan.nama pelanggan,
            pelanggan.nopel,
            meter.jumlah volume,
            meter.id_meter id,
            CASE WHEN meter.jumlah BETWEEN 0  and 10 THEN golongan.pertama
                 WHEN meter.jumlah BETWEEN 11 and 20 THEN golongan.kedua
                 WHEN meter.jumlah BETWEEN 21 and 30 THEN golongan.ketiga
                 WHEN meter.jumlah BETWEEN 31 and 40 THEN golongan.keempat
                 WHEN meter.jumlah BETWEEN 41 and 50 THEN golongan.kelima
                 WHEN meter.jumlah > 50 THEN golongan.keenam
            END jumlah,
            (meter.jumlah *
            CASE WHEN meter.jumlah BETWEEN 0  and 10 THEN golongan.pertama
                 WHEN meter.jumlah BETWEEN 11 and 20 THEN golongan.kedua
                 WHEN meter.jumlah BETWEEN 21 and 30 THEN golongan.ketiga
                 WHEN meter.jumlah BETWEEN 31 and 40 THEN golongan.keempat
                 WHEN meter.jumlah BETWEEN 41 and 50 THEN golongan.kelima
                 WHEN meter.jumlah > 50 THEN golongan.keenam
            END) total
            FROM
            meter
            LEFT JOIN pelanggan ON pelanggan.id_pel = meter.id_pel
            LEFT JOIN golongan ON golongan.id_gol = pelanggan.gol
            where date_format(meter.tanggal,'%m-%Y') = '$bulan'
            and meter.st = '0'");
            ?>
    <div class="table-responsive">
        <table id="example-datatable" class="table table-striped table-bordered table-vcenter">
            <thead>
                <tr>
                    <th class="text-center" style="width: 50px;">NO</th>
                    <th>NO KTP</th>
                    <th>NAMA</th>
                    <th>VOLUME</th>
                    <th>HARGA</th>
                    <th>TOTAL</th>
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
                    <td><?php echo $r['nopel'];?></td>
                    <td><?php echo $r['pelanggan'];?></td>
                    <td><?php echo number_format($r['volume']);?> /M3</td>
                    <td class="text-center">Rp. <?php echo number_format($r['jumlah']);?></td>
                    <td class="text-center">Rp. <?php echo number_format($r['total']);?></td>
                </tr>
                <?php } ?>
            </tbody>
                <tr>
                    <th colspan="5" class="text-center">TOTAL TUNGGAKAN</th>
                    <th class="text-center">Rp. <?php echo number_format($total); ?></th>
                </tr>
        </table>
    </div>
