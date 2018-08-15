<?php
include "../config.php";
?>
        <!-- <script src="js/app.js"></script> -->
<script type="text/javascript">

function datatgl() {
    var date1 = $('#tanggal').val();
  $('#data').load('modal/pengeluaran.php?date='+date1);
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
            'keterangan': {
                required: true
            },
            'total': {
                required: true,
                number : true
                // minlength: 10
            }
        },
        messages: {
            'keterangan': 'keterangan tidak boleh kosong',
            'total': {
                required: 'Isikan total harga',
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
                <h1>Data Pengeluaran</h1>
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
                <div class="form-group">
                    <label class="col-md-3 control-label">Keterangan <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <textarea id="keterangan" name="keterangan" rows="5" class="form-control" placeholder="Keterangan pengeluaran"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Total <span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon">RP.</span>
                            <input type="text" id="total" name="total" class="form-control" placeholder="Total pengeluaran">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-success pull-right" id="tambah">Tambah</button>
                        
                        <input type="hidden" id="id_pengeluaran" name="id_pengeluaran">
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
                <h2>FILTERING PERIODE BULAN</h2>
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

$("#total").on('keyup', function(){
        var m = $(this).val().replace(/[^0-9-.]/g, '')
        var n = m.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
        $(this).val(n);
});

function simpan(){
    var keterangan  = $('#keterangan').val();
    var total       = $('#total').val().replace(/[^0-9-.]/g, '');
                        
    $.ajax({
        url     : 'modal/m_pengeluaran.php',
        data    : 'tambah='+keterangan+'&total='+total, 
        type    : 'POST',
        dataType: 'html',
        success : function(pesan){
            if(pesan=='ok'){
                $('#form-validation')[0].reset();
                swal('SUKSES!', 'Tambah data pengeluaran berhasil', 'success');
                setTimeout(function(){ datatgl(); }, 1000);
            }
            else{
                swal('PERINGATAN!', 'Tambah data pengeluaran gagal', 'warning');
            }
        },
    });
}

function ubah(){
    var id          = $('#id_pengeluaran').val();
    var keterangan  = $('#keterangan').val();
    var total       = $('#total').val().replace(/[^0-9-.]/g, '');
                        
    $.ajax({
        url     : 'modal/m_pengeluaran.php',
        data    : 'ubah='+id+'&keterangan='+keterangan+'&total='+total, 
        type    : 'POST',
        dataType: 'html',
        success : function(pesan){
            if(pesan=='ok'){
                $('#form-validation')[0].reset();
                swal('SUKSES!', 'Edit data pengeluaran berhasil', 'success');
                setTimeout(function(){ datatgl(); }, 1000);
                actioncancel();
            }
            else{
                swal('PERINGATAN!', 'Edit data pengeluaran gagal', 'warning');
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
            url     : 'modal/m_pengeluaran.php',
            data    : 'hapus='+id, 
            type    : 'POST',
            dataType: 'html',
            success : function(pesan){
                if(pesan=='ok'){
                    swal({title: "SUKSES!",text: "Data telah terhapus!",type:"success",timer: 1500,showConfirmButton: false});
                    setTimeout(function(){ datatgl(); }, 1000);
                }else{
                    swal('PERINGATAN!', 'Hapus data pengeluaran gagal', 'warning');
                }
            },
        });
    });
}

function lihat(id){
    $('#submit').hide();
    $('#update').show();
    $('#judul').text('EDIT DATA PENGELUARAN');

    $.ajax({
        url     : 'modal/m_pengeluaran.php',
        data    : 'lihat='+id, 
        type    : 'POST',
        dataType: 'JSON',
        success : function(pesan){
            if(pesan != null){
                $('#form-validation')[0].reset();
                $('#id_pengeluaran').val(pesan.id_pengeluaran);
                $('#keterangan').val(pesan.keterangan);
                $('#total').val(pesan.total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
                $('#btnupdate').show();
                $('#btncancel').show();
                $('#tambah').hide();
            }
            else{
                swal('PERINGATAN!', 'Lihat data pengeluaran gagal', 'warning');
            }
        },
    });
}

function actioncancel(){
    $('#form-validation')[0].reset();
    $('#btnupdate').hide();
    $('#btncancel').hide();
    $('#tambah').show();
    $('#title-input').text('INPUT DATA');
}

</script>