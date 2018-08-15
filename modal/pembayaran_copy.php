<?php
include "../config.php";
$id = $_GET['id'];
$sql = $conn->query("
SELECT
meter.id_meter id,
date_format(meter.tanggal,'%M') bulan,
meter.jumlah volume,
CASE WHEN meter.jumlah BETWEEN 0  and 10 THEN '0 - 10M3'
     WHEN meter.jumlah BETWEEN 11 and 20 THEN '11 - 20M3'
     WHEN meter.jumlah BETWEEN 21 and 30 THEN '21 - 30M3'
     WHEN meter.jumlah BETWEEN 31 and 40 THEN '31 - 40M3'
     WHEN meter.jumlah BETWEEN 41 and 50 THEN '41 - 50M3'
     WHEN meter.jumlah > 50 THEN '51 - Keatas'
END golongan,
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
END) total,
golongan.harga beban
FROM meter
LEFT JOIN pelanggan ON pelanggan.id_pel = meter.id_pel
LEFT JOIN golongan ON golongan.id_gol = pelanggan.gol
where meter.st = '0' and meter.id_pel = '$id'");
?>


<thead>
    <tr>
        <th style="width: 80px;" class="text-center"><label class="csscheckbox csscheckbox-primary"><input type="checkbox"><span></span></label></th>
        <th>BULAN</th>
        <th>VOLUME</th>
        <th>GOLONGAN</th>
        <th>HARGA</th>
        <th>TOTAL</th>
    </tr>
</thead>
<tbody>
    <?php 
    while($r=$sql->fetch_assoc()){
    ?>
    <tr>
        <td class="text-center"><label class="csscheckbox csscheckbox-primary"><input type="checkbox" name="check" value="<?php echo $r['id'];?>"><span></span></label></td>
        <td><?php echo $r['bulan'];?></td>
        <td><?php echo number_format($r['volume']);?> /M3</td>
        <td><?php echo ($r['golongan']);?></td>
        <td>Rp. <?php echo number_format($r['jumlah']);?></td>
        <td>Rp. <?php echo number_format($r['total']);?></td>
    </tr>
    <?php } ?>
</tbody>




<script type="text/javascript">
    $('thead input:checkbox').click(function() {
        var checkedStatus   = $(this).prop('checked');
        var table           = $(this).closest('table');

        $('tbody input:checkbox', table).each(function() {
            $(this).prop('checked', checkedStatus);
        });
    });

    $('input:checkbox').click(function() {
        var checked = []
        $("input[name='check']:checked").each(function ()
        {
            checked.push(parseInt($(this).val()));
        });
 
        $.ajax({
            url     : 'modal/m_pembayaran.php',
            data    : 'total='+checked, 
            type    : 'POST',
            dataType: 'JSON',
            success : function(pesan){
                if(pesan.harga != 0){
                    var beban = $('#beban').val().replace(/[^0-9-.]/g, '');

                    $('#harga').val(pesan.harga.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
                    // $('#denda').val(pesan.denda.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
                    $('#jumlah').val(pesan.total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
                    $('#volume').val(pesan.volume.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
                    var total =(parseInt(pesan.total) + parseInt(beban));
                    $('#total').val(total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
                }
                else{
                    $('#volume').val('');
                    $('#harga').val('');
                    $('#jumlah').val(0);
                    $('#total').val(0);
                }
            },
        });
    });

</script>

