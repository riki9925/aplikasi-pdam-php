<?php
include "../config.php";
?>
        <!-- <script src="js/app.js"></script> -->
<script type="text/javascript">

function datatgl() {
    var date = $('#tanggal').val();
  $('#data').load('modal/meter.php?date='+date);
}


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
            'pegawai': {
                required: true
            },
            'pelanggan': {
                required: true
            },
            'sekarang': {
                required: true,
                number : true
                // minlength: 10
            }
        },
        messages: {
            'pegawai': 'Pilih Pegawai',
            'pelanggan': 'Pilih Pelanggan',
            'sekarang': {
                required: 'Isikan total volume sekarang',
                number: 'Isi dengan nominal'
                }
        }
    });

    $("#form-validation").submit(function(e) {
        e.preventDefault();
    });
    var date = new Date();
    var today = new Date(date.getFullYear(), date.getMonth());
    // Initialize Datepicker
    $('.input-datepicker, .input-daterange').datepicker({weekStart: 1, format: "mm-yyyy",viewMode: "months", minViewMode: "months"}).on('changeDate', function(e){ $(this).datepicker('hide'); });
    $('#tanggal').datepicker('setDate', today);
</script>


<!-- Table Styles Header -->
<div class="content-header">
    <div class="row">
        <div class="col-sm-12">
            <div class="header-section">
                <h1>Data Meter Pelanggan</h1>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="block full">
            <div class="block-title">
                <h2 id="title-input">INPUT DATA</h2>
            </div>
            <form id="form-validation" action="#" class="form-horizontal form-bordered">
                <div class="form-group" id="h_pegawai">
                    <label class="col-md-3 control-label" for="val-digits">Pegawai <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <select id="id_pegawai" name="pegawai" data-placeholder="Pilih pegawai" style="width: 250px;">
                        <?php
                        $sql1 =    $conn->query("SELECT * FROM pegawai ORDER BY id_peg ASC");
                        while($a=$sql1->fetch_assoc()){ 
                        ?>
                            <option value="<?php echo $a['id_peg'];?>"> <?php echo $a['nama'];?> </option>
                        <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group"  id="h_pelanggan">
                    <label class="col-md-3 control-label" for="val-digits">Pelanggan <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <select id="id_pelanggan" name="pelanggan" data-placeholder="Pilih pelanggan" style="width: 250px;" onchange="check_lalu()">
                            <option value=""> -Pilih Pelanggan- </option>
                        <?php
                        $sql2 =    $conn->query("SELECT * FROM pelanggan where id_pel NOT IN (select id_pel from meter where date_format(tanggal,'%m') = '".date('m')."') ORDER BY id_pel ASC");
                        while($b=$sql2->fetch_assoc()){
                        ?>
                            <option value="<?php echo $b['id_pel'];?>"> <?php echo $b['nopel'].' - '.$b['nama'];?> </option>
                        <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Bulan Lalu</label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" id="lalu" name="lalu" class="form-control" placeholder="Bulan Lalu" disabled="">
                            <span class="input-group-addon">M3</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Sekarang <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" id="sekarang" name="sekarang" class="form-control" placeholder="Total volume sekarang" onchange="check_jumlah()">
                            <span class="input-group-addon">M3</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Total Bulan Ini</label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" id="jumlah" name="jumlah" class="form-control" placeholder="Bulan ini" disabled="">
                            <span class="input-group-addon">M3</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-success pull-right" id="tambah">Tambah</button>
                        
                        <input type="hidden" id="id_meter" name="id_meter" class="form-control" placeholder="Bulan Lalu" disabled="">
                        <button type="button" class="btn btn-success pull-right" id="btnupdate">Ubah</button>
                        <button type="button" class="btn btn-danger pull-left" id="btncancel" onclick="actioncancel()">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="block full">
            <div class="block-title">
                <h2>FILTERING DATA METER</h2>
            </div>
            <input type="text" id="tanggal" name="tanggal" class="form-control input-datepicker" data-date-format="yyyy-mm" placeholder="yyyy-mm" onchange="datatgl()">
        </div>
    </div>
</div>

<div class="block full" id="data">
</div>
<script type="text/javascript">

$('#btnupdate').hide();
$('#btncancel').hide();
$('#tambah').show();


$( "#form-validation" ).submit(function( event ) {
    if ($('#form-validation').valid()){
       simpan();
    }
    event.preventDefault();
});

$( "#btnupdate" ).click(function( event ) {
    if ($('#form-validation').valid()){
       ubah();
    }
    event.preventDefault();
});

$("#sekarang").on('keyup', function(){
        var m = $(this).val().replace(/[^0-9-.]/g, '')
        var n = m.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
        $(this).val(n);
});

function simpan(){
    var pegawai     = $('#id_pegawai').val();
    var pelanggan   = $('#id_pelanggan').val();
    var lalu        = $('#lalu').val().replace(/[^0-9-.]/g, '');
    var sekarang    = $('#sekarang').val().replace(/[^0-9-.]/g, '');
    var jumlah      = $('#jumlah').val().replace(/[^0-9-.]/g, '');
                        
    $.ajax({
        url     : 'modal/m_meter.php',
        data    : 'tambah='+pegawai+'&pelanggan='+pelanggan+'&lalu='+lalu+'&sekarang='+sekarang+'&jumlah='+jumlah, 
        type    : 'POST',
        dataType: 'html',
        success : function(pesan){
            if(pesan=='ok'){
                $('#form-validation')[0].reset();
                swal('SUKSES!', 'Tambah data meter berhasil', 'success');
                setTimeout(function(){ load('meter'); }, 1000);
            }
            else{
                swal('PERINGATAN!', 'Tambah data meter gagal', 'warning');
            }
        },
    });
}

function ubah(){
    var id          = $('#id_meter').val();
    var sekarang    = $('#sekarang').val().replace(/[^0-9-.]/g, '');
    var jumlah      = $('#jumlah').val().replace(/[^0-9-.]/g, '');
                        
    $.ajax({
        url     : 'modal/m_meter.php',
        data    : 'ubah='+id+'&sekarang='+sekarang+'&jumlah='+jumlah, 
        type    : 'POST',
        dataType: 'html',
        success : function(pesan){
            if(pesan=='ok'){
                $('#form-validation')[0].reset();
                swal('SUKSES!', 'Edit data meter berhasil', 'success');
                setTimeout(function(){ datatgl(); }, 1000);
                actioncancel();
            }
            else{
                swal('PERINGATAN!', 'Edit data meter gagal', 'warning');
            }
        },
    });
}

function hapus(id){                        
    swal({
      title: "PERINGATAN!",
      text: "Apakah anda yakin ingin menghapus?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Yes!",
      closeOnConfirm: false
    },
    function(){
        $.ajax({
            url     : 'modal/m_meter.php',
            data    : 'hapus='+id, 
            type    : 'POST',
            dataType: 'html',
            success : function(pesan){
                if(pesan=='ok'){
                    swal({title: "SUKSES!",text: "Data telah terhapus!",type:"success",timer: 1500,showConfirmButton: false});
                    setTimeout(function(){ datatgl(); }, 1000);
                }else{
                    swal('PERINGATAN!', 'Hapus data meter gagal', 'warning');
                }
            },
        });
    });
}

function lihat(id){
    $('#submit').hide();
    $('#update').show();
    $('#judul').text('EDIT DATA PELANGGAN');

    $.ajax({
        url     : 'modal/m_meter.php',
        data    : 'lihat='+id, 
        type    : 'POST',
        dataType: 'JSON',
        success : function(pesan){
            if(pesan != null){
                $('#form-validation')[0].reset();
                $('#id_meter').val(pesan.id_meter);
                // $('#id_pegawai').val(pesan.id_peg).change();
                // $('#id_pelanggan').val(pesan.id_pel).change();
                $('#title-input').text(pesan.pelanggan);
                $('#lalu').val(pesan.lalu);
                $('#sekarang').val(pesan.sekarang);
                $('#jumlah').val(pesan.jumlah);
                $('#btnupdate').show();
                $('#btncancel').show();
                $('#tambah').hide();
                $('#h_pegawai').hide();
                $('#h_pelanggan').hide();
            }
            else{
                swal('PERINGATAN!', 'Lihat data pelanggan gagal', 'warning');
            }
        },
    });
}

function actioncancel(){
    $('#form-validation')[0].reset();
    $('#btnupdate').hide();
    $('#btncancel').hide();
    $('#tambah').show();
    $('#h_pegawai').show();
    $('#h_pelanggan').show();
    $('#title-input').text('INPUT DATA');
}

function check_lalu(){
    var id = $('#id_pelanggan').val();
    $.ajax({
        url     : 'modal/m_meter.php',
        data    : 'lalu='+id, 
        type    : 'POST',
        dataType: 'JSON',
        success : function(pesan){
            if(pesan != null){
                $('#lalu').val(pesan.sekarang.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
                if ($('#jumlah').val() != '') {
                   check_jumlah();
                }
            }
            else{
                $('#lalu').val('0');
            }
        },
    });
}

function check_jumlah(){
    var lalu = $('#lalu').val().replace(/[^0-9-.]/g, '');
    var skrg = $('#sekarang').val().replace(/[^0-9-.]/g, '');
    // swal(lalu+skrg);
    var total = parseInt(skrg)-parseInt(lalu);
    if ($('#lalu').val() == '') {
        swal('PERINGATAN!', 'Volume bulan lalu kosong', 'warning');
        $('#sekarang').val('');
        $('#jumlah').val('');
    }else
    if (parseInt(skrg) < parseInt(lalu)) {
        swal('PERINGATAN!', 'Bulan ini terlalu kecil', 'warning');
        $('#sekarang').val('');
        $('#jumlah').val('');
    }else{
        $('#jumlah').val(total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
    }
}


// datatgl();
$('#id_pelanggan').select2();
$('#id_pegawai').select2();

</script>