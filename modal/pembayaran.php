<?php
include "../config.php";
$id = $_GET['id'];
$sql = $conn->query("
SELECT
meter.id_meter id,
date_format(meter.tanggal,'%M') bulan,
meter.jumlah volume,
if(meter.jumlah > 10,(golongan.pertama * 10),(golongan.pertama * (meter.jumlah))) PERTAMA,
if(meter.jumlah > 20,(golongan.kedua * 10),(golongan.kedua * (meter.jumlah - 10))) KEDUA,
if(meter.jumlah > 30,(golongan.ketiga * 10),(golongan.ketiga * (meter.jumlah - 20))) KETIGA,
if(meter.jumlah > 40,(golongan.keempat * 10),(golongan.keempat * (meter.jumlah - 30))) KEEMPAT,
if(meter.jumlah > 50,(golongan.kelima * 10),(golongan.kelima * (meter.jumlah - 40))) KELIMA,
if(meter.jumlah >= 51,(golongan.keenam * (meter.jumlah - 50)),0) KEENAM,
(
if(meter.jumlah > 10,(golongan.pertama * 10),(golongan.pertama * (meter.jumlah))) +
if(meter.jumlah > 20,(golongan.kedua * 10),(golongan.kedua * (meter.jumlah - 10))) +
if(meter.jumlah > 30,(golongan.ketiga * 10),(golongan.ketiga * (meter.jumlah - 20))) +
if(meter.jumlah > 40,(golongan.keempat * 10),(golongan.keempat * (meter.jumlah - 30))) +
if(meter.jumlah > 50,(golongan.kelima * 10),(golongan.kelima * (meter.jumlah - 40))) +
if(meter.jumlah >= 51,(golongan.keenam * (meter.jumlah - 50)),0)
) total,
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
        <th>1 - 10 M3</th>
        <th>11 - 20 M3</th>
        <th>21 - 30 M3</th>
        <th>31 - 40 M3</th>
        <th>41 - 50 M3</th>
        <th>51 M3 LEBIH</th>
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
        <td>Rp. <?php echo number_format($r['PERTAMA']);?></td>
        <td>Rp. <?php echo number_format($r['KEDUA']);?></td>
        <td>Rp. <?php echo number_format($r['KETIGA']);?></td>
        <td>Rp. <?php echo number_format($r['KEEMPAT']);?></td>
        <td>Rp. <?php echo number_format($r['KELIMA']);?></td>
        <td>Rp. <?php echo number_format($r['KEENAM']);?></td>
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

                    $('#pertama').val(pesan.pertama.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
                    $('#kedua').val(pesan.kedua.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
                    $('#ketiga').val(pesan.ketiga.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
                    $('#keempat').val(pesan.keempat.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
                    $('#kelima').val(pesan.kelima.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
                    $('#keenam').val(pesan.keenam.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
                    // $('#denda').val(pesan.denda.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
                    $('#jumlah').val(pesan.total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
                    $('#volume').val(pesan.volume.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
                    var total =(parseInt(pesan.total) + parseInt(pesan.beban));
                    $('#total').val(total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));


                    $('#beban').val(pesan.beban.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
                }
                else{
                    $('#volume').val('');
                    $('#pertama').val(0);
                    $('#kedua').val(0);
                    $('#ketiga').val(0);
                    $('#keempat').val(0);
                    $('#kelima').val(0);
                    $('#keenam').val(0);
                    $('#jumlah').val(0);
                    $('#total').val(0);
                }
            },
        });
    });

</script>

