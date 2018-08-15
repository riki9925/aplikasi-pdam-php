<?php
include "../config.php";
?>
        <!-- <script src="js/app.js"></script> -->
<script type="text/javascript">

    App.datatables();
    $('#example-datatable').dataTable({
        columnDefs: [ { orderable: false, targets: [ 4 ] } ],
        pageLength: 10,
        lengthMenu: [[5, 10, 20], [5, 10, 20]]
    });
    $('.dataTables_filter input').attr('placeholder', 'Search');

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
                <h1>Data Saldo Kas</h1>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 text-center">
        <div class="block full">
            <button type="button" class="btn btn-primary btn-lg" onclick="simpan()"><i class="fa fa-book"></i> TUTUP BUKU</button>
        </div>
    </div>
</div>

<div class="block full">
            <?php
            $sql = $conn->query("
            SELECT
            id_kas id, keterangan, total,
            DATE_FORMAT(tanggal,'%d-%m-%Y') tanggal,
            DATE_FORMAT(tanggal,'%m') bulan,
            DATE_FORMAT(tanggal,'%Y') tahun
            FROM
            kas");
            ?>
    <div class="table-responsive">
        <table id="example-datatable" class="table table-striped table-bordered table-vcenter">
            <thead>
                <tr>
                    <th class="text-center" style="width: 50px;">NO</th>
                    <th>BULAN</th>
                    <th>KETERANGAN</th>
                    <th class="text-center">TOTAL</th>
                    <th class="text-center" style="width: 75px;"><i class="fa fa-flash"></i></th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no=0;
                $total=0;
                while($r=$sql->fetch_assoc()){$no++;
                $total += $r['total'];
                if ($r['bulan'] == '01') {
                    $bulan = 'JANUARI';
                }else
                if ($r['bulan'] == '02') {
                    $bulan = 'FEBRUARI';
                }else
                if ($r['bulan'] == '03') {
                    $bulan = 'MARET';
                }else
                if ($r['bulan'] == '04') {
                    $bulan = 'APRIL';
                }else
                if ($r['bulan'] == '05') {
                    $bulan = 'MEI';
                }else
                if ($r['bulan'] == '06') {
                    $bulan = 'JUNI';
                }else
                if ($r['bulan'] == '07') {
                    $bulan = 'JULI';
                }else
                if ($r['bulan'] == '08') {
                    $bulan = 'AGUSTUS';
                }else
                if ($r['bulan'] == '08') {
                    $bulan = 'SEPTEMBER';
                }else
                if ($r['bulan'] == '10') {
                    $bulan = 'OKTOBER';
                }else
                if ($r['bulan'] == '11') {
                    $bulan = 'NOVEMBER';
                }else
                if ($r['bulan'] == '12') {
                    $bulan = 'DESEMBER';
                }
                ?>
                <tr>
                    <td class="text-center"><?php echo $no;?></td>
                    <td><?php echo $bulan.' '.$r['tahun']; ?></td>
                    <td><?php echo nl2br($r['keterangan']);?></td>
                    <td class="text-right">Rp. <?php echo number_format($r['total']);?></td>
                    <td class="text-center">
                    <?php if ($r['id'] == '1' && $sql->num_rows == 1) { ?>
                        <a href="javascript:void(0)" data-toggle="tooltip" title="Edit User" class="btn btn-effect-ripple btn-xs btn-success" onclick="lihat(<?php echo $r['id'];?>)"><i class="fa fa-pencil"></i></a>
                    <?php } ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<div id="modal-add" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="block">
                        <div class="block-title">
                            <div class="block-options pull-right">
                                <button type="button" class="btn btn-danger" id="delete" data-dismiss="modal">Close</button>
                            </div>
                            <h2>EDIT TOTAL SALDO AWAL</h2>
                        </div>
                        <form id="form-validation" action="#" class="form-horizontal form-bordered">
                            <div class="form-group">
                                <label class="col-md-3 control-label">TOTAL <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input type="hidden" id="id_kas" name="id_kas">
                                    <input type="text" id="total" name="total" class="form-control" placeholder="10000000">
                                </div>
                            </div>

                            <div class="form-group form-actions pull-right">
                                <div class="col-md-9 col-md-offset-3">
                                    <button type="submit" class="btn btn-danger" onclick="ubah()">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">

$("#total").on('keyup', function(){
        var m = $(this).val().replace(/[^0-9-.]/g, '')
        var n = m.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
        $(this).val(n);
});

function simpan(){
swal({
  title: "TUTUP BUKU",
  text: "Keterangan:",
  type: "input",
  showCancelButton: true,
  closeOnConfirm: false,
  animation: "slide-from-top",
  inputPlaceholder: "Kas akhir bulan februari"
},
function(inputValue){
  if (inputValue === false) return false;
  
  if (inputValue === "") {
    swal.showInputError("Tuliskan Keterangan Tutup Buku");
    return false
  }
    $.ajax({
        url     : 'modal/m_kas.php',
        data    : 'tambah='+inputValue, 
        type    : 'POST',
        dataType: 'html',
        success : function(pesan){
            if(pesan=='ok'){
                swal('SUKSES!', 'Tutup Buku Berhasil', 'success');
                setTimeout(function(){ load('kas'); }, 1000);
            }
            else{
                swal('PERINGATAN!', 'Tambah data kas gagal', 'warning');
                setTimeout(function(){ load('kas'); }, 1000);
            }
        },
    });
  
});
}

function ubah(){
    var id          = $('#id_kas').val();
    var total       = $('#total').val().replace(/[^0-9-.]/g, '');
                        
    $.ajax({
        url     : 'modal/m_kas.php',
        data    : 'ubah='+id+'&total='+total, 
        type    : 'POST',
        dataType: 'html',
        success : function(pesan){
            if(pesan=='ok'){
                $('#form-validation')[0].reset();
                swal('SUKSES!', 'Edit total saldo awal  berhasil', 'success');
                setTimeout(function(){ load('kas'); }, 1000);
                $('#modal-add').modal('hide');
            }
            else{
                swal('PERINGATAN!', 'Edit total saldo kas gagal', 'warning');
            }
        },
    });
}

function lihat(id){
    $.ajax({
        url     : 'modal/m_kas.php',
        data    : 'lihat='+id, 
        type    : 'POST',
        dataType: 'JSON',
        success : function(pesan){
            if(pesan != null){
                $('#modal-add').modal('show');
                $('#form-validation')[0].reset();
                $('#id_kas').val(pesan.id_kas);
                $('#total').val(pesan.total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
            }
            else{
                swal('PERINGATAN!', 'Lihat data kas gagal', 'warning');
            }
        },
    });
}
</script>