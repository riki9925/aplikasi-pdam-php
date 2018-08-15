<?php
include "../config.php";
?>
<script type="text/javascript">
    $('thead input:checkbox').click(function() {
        var checkedStatus   = $(this).prop('checked');
        var table           = $(this).closest('table');

        $('tbody input:checkbox', table).each(function() {
            $(this).prop('checked', checkedStatus);
        });
    });

    $('#form-validation').validate({
        errorClass: 'help-block animation-pullUp',
        errorElement: 'div',
        errorPlacement: function(error, e) {
            e.parents('.form-group > div').append(error);
        },
        highlight: function(e) {
            $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
            $(e).closest('.help-block').remove();
        },
        success: function(e) {
            e.closest('.form-group').removeClass('has-success has-error').addClass('has-success');
            e.closest('.help-block').remove();
        },
        rules: {
            'id_pelanggan': {
                required: true
            },
            'total': {
                required: true,
                number : true
                // minlength: 10
            }
        },
        messages: {
            'pelanggan': 'Pilih Pelanggan',
            'total': {
                required: 'Pilih data meter',
                number: 'Isi dengan nominal'
                }
        }
    });

    $("#form-validation").submit(function(e) {
        e.preventDefault();
    });
</script>
        <!-- <script src="js/app.js"></script> -->


<!-- Table Styles Header -->
<div class="content-header">
    <div class="row">
        <div class="col-sm-12">
            <div class="header-section">
                <h1>PEMBAYARAN</h1>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <div class="block full">
            <div class="block-title">
                <h2>FILTER DATA PELANGGAN</h2>
            </div>
            <form id="form-validation" action="#" class="form-horizontal form-bordered">
                <div class="form-group">
                    <div class="col-md-12">
                        <select id="id_pelanggan" name="pelanggan" data-placeholder="Pilih pelanggan" style="width: 100%;" onchange="check_pelanggan()">
                            <option value=""> -Pilih Pelanggan- </option>
                        <?php
                        $sql2 =    $conn->query("SELECT * FROM pelanggan ORDER BY id_pel ASC");
                        while($b=$sql2->fetch_assoc()){
                        ?>
                            <option value="<?php echo $b['id_pel'];?>"> <?php echo $b['nopel'].' - '.$b['nama'];?> </option>
                        <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">No KTP</label>
                        <div class="col-md-9">
                        <p class="form-control-static" id="txtNo">:</p>
                    </div>
                <!-- </div> -->
                <!-- <div class="form-group"> -->
                    <label class="col-md-3 control-label">Alamat</label>
                    <div class="col-md-9">
                        <p class="form-control-static" id="txtAlamat">:</p>
                    </div>
                <!-- </div> -->
                <!-- <div class="form-group"> -->
                    <label class="col-md-3 control-label">No telp</label>
                    <div class="col-md-9">
                        <p class="form-control-static" id="txtTelp">:</p>
                    </div>
                <!-- </div> -->
                <!-- <div class="form-group"> -->
                    <label class="col-md-3 control-label">Golongan</label>
                    <div class="col-md-9">
                        <p class="form-control-static" id="txtGol">:</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Volume</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <input type="text" id="volume" name="volume" class="form-control" placeholder="Total volume" disabled="">
                            <span class="input-group-addon">M3</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">1 - 10 M3</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon">RP.</span>
                            <input type="text" id="pertama" name="pertama" class="form-control" placeholder="Harga" disabled="">
                        </div>
                    </div>
                    <label class="col-md-4 control-label">11 - 20 M3</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon">RP.</span>
                            <input type="text" id="kedua" name="kedua" class="form-control" placeholder="Harga" disabled="">
                        </div>
                    </div>
                    <label class="col-md-4 control-label">21 - 30 M3</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon">RP.</span>
                            <input type="text" id="ketiga" name="ketiga" class="form-control" placeholder="Harga" disabled="">
                        </div>
                    </div>
                    <label class="col-md-4 control-label">31 - 40 M3</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon">RP.</span>
                            <input type="text" id="keempat" name="keempat" class="form-control" placeholder="Harga" disabled="">
                        </div>
                    </div>
                    <label class="col-md-4 control-label">41 - 50 M3</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon">RP.</span>
                            <input type="text" id="kelima" name="kelima" class="form-control" placeholder="Harga" disabled="">
                        </div>
                    </div>
                    <label class="col-md-4 control-label">51 M3 =< </label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon">RP.</span>
                            <input type="text" id="keenam" name="keenam" class="form-control" placeholder="Harga" disabled="">
                        </div>
                    </div>
                    <label class="col-md-3 control-label">Total</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon">RP.</span>
                            <input type="text" id="jumlah" name="jumlah" class="form-control" placeholder="Total Harga " disabled="">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Beban</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon">RP.</span>
                            <input type="text" id="beban" name="beban" class="form-control" placeholder="Biaya admin" disabled="">
                        </div>
                    </div>
                    <label class="col-md-3 control-label">Pembayaran</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon">RP.</span>
                            <input type="text" id="total" name="total" class="form-control" placeholder="Total Pembayaran" disabled="">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success pull-right" id="bayar">Bayar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="block full">
            <div class="block-title">
                <h2>Data Meter Pelanggan</h2>
            </div>
            <div class="table-responsive">
                 <table id="example-datatable" class="table table-striped table-bordered table-vcenter">
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

$( "#form-validation" ).submit(function( event ) {
    if ($('#form-validation').valid()){
        if ($('#total').val() == '') {
            swal('Peringatan!','Pilih data meter','warning');
        }else{
           simpan();
           $('#bayar').prop('disabled',true);            
        }
    }
    event.preventDefault();
});


function simpan(){
    var checked = []
    var id      = $('#id_pelanggan').val();
    var volume  = $('#volume').val().replace(/[^0-9-.]/g, '');
    // var harga   = $('#harga').val().replace(/[^0-9-.]/g, '');
    // var denda   = $('#denda').val().replace(/[^0-9-.]/g, '');
    var beban   = $('#beban').val().replace(/[^0-9-.]/g, '');
    var jumlah   = $('#jumlah').val().replace(/[^0-9-.]/g, '');
    var total   = $('#total').val().replace(/[^0-9-.]/g, '');
    // var uang    = $('#uang').val().replace(/[^0-9-.]/g, '');
    // var kembalian   = $('#kembalian').val().replace(/[^0-9-.]/g, '');
    
    $("input[name='check']:checked").each(function ()
    {
        checked.push(parseInt($(this).val()));
    });

    $.ajax({
        url     : 'modal/m_pembayaran.php',
        data    : 'tambah='+id
                +'&volume='+volume
                // +'&harga='+harga
                // +'&denda='+denda
                +'&beban='+beban
                +'&jumlah='+jumlah
                +'&total='+total
                // +'&uang='+uang
                // +'&kembalian='+kembalian
                +'&meter='+checked, 
        type    : 'POST',
        dataType: 'JSON',
        success : function(pesan){
            if(pesan.status){
                $('#form-validation')[0].reset();
                $('#txtNo').text(': ');
                $('#txtAlamat').text(': ');
                $('#txtTelp').text(': ');
                $('#txtGol').text(': ');
                $('#id_pelanggan').val('').change();
                swal({title: "SUKSES!",text: "Proses pembayaran",type:"success",timer: 1500,showConfirmButton: false});
                setTimeout(function(){ datatgl(); }, 1000);
                window.open("http://localhost/pdam/print.php?code="+pesan.kode, "_blank", "toolbar=no,scrollbars=yes,resizable=no,width=420,height=595");
            }
            else{
                swal('PERINGATAN!', 'Pembayaran gagal', 'warning');
            }
            $('#bayar').prop('disabled',false);
        },
    });
}


function check_pelanggan(){
    var id = $('#id_pelanggan').val();
    $.ajax({
        url     : 'modal/m_pembayaran.php',
        data    : 'lihat='+id, 
        type    : 'POST',
        dataType: 'JSON',
        success : function(pesan){
            if(pesan != null){
                $('#txtNo').text(': '+pesan.nopel);
                $('#txtAlamat').text(': '+pesan.alamat);
                $('#txtTelp').text(': '+pesan.no_telp);
                $('#txtGol').text(': '+pesan.golongan);
                $('#volume').val('');
                // $('#harga').val('');
                $('#jumlah').val('');
                $('#total').val('');
                $('#beban').val(pesan.beban.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
                datatgl(id);
            }else
            if(pesan == null){
                
            }else{
                swal('PERINGATAN!', 'Lihat data pelanggan gagal', 'warning');
            }
        },
    });
}

$('#id_pelanggan').select2();

function datatgl(id) {
  $('#example-datatable').load('modal/pembayaran.php?id='+id);
}

</script>