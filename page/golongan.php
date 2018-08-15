        <script type="text/javascript">

            App.datatables();
            $('#example-datatable').dataTable({
                columnDefs: [ { orderable: false, targets: [ 5 ] } ],
                pageLength: 10,
                scrollX: true,
                lengthMenu: [[5, 10, 20], [5, 10, 20]]
            });
            $('.dataTables_filter input').attr('placeholder', 'Search');
            $('thead input:checkbox').click(function() {
                var checkedStatus   = $(this).prop('checked');
                var table           = $(this).closest('table');

                $('tbody input:checkbox', table).each(function() {
                    $(this).prop('checked', checkedStatus);
                });
            });

            var genTable        = $('#general-table');
            var styleBorders    = $('#style-borders');

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
                    'kd_gol': {
                        required: true
                    },
                    'nama': {
                        required: true
                    },
                    'pertama': {
                        required: true,
                        number: true
                    },
                    'kedua': {
                        required: true,
                        number: true
                    },
                    'ketiga': {
                        required: true,
                        number: true
                    },
                    'keempat': {
                        required: true,
                        number: true
                    },
                    'kelima': {
                        required: true,
                        number: true
                    },
                    'harga': {
                        required: true,
                        number: true
                    },
                    'keenam': {
                        required: true,
                        number: true
                    },
                    'denda': {
                        required: true,
                        number: true
                    }
                },
                messages: {
                    'kd_gol': 'Isikan kode golongan',
                    'nama': 'Isikan nama golongan',
                    'harga': {
                        required: 'Isikan beban harga',
                        number: 'Harus Angka'
                    },
                    'pertama': {
                        required: 'Isikan harga per M3',
                        number: 'Harus Angka'
                    },
                    'kedua': {
                        required: 'Isikan harga per M3',
                        number: 'Harus Angka'
                    },
                    'ketiga': {
                        required: 'Isikan harga per M3',
                        number: 'Harus Angka'
                    },
                    'keempat': {
                        required: 'Isikan harga per M3',
                        number: 'Harus Angka'
                    },
                    'kelima': {
                        required: 'Isikan harga per M3',
                        number: 'Harus Angka'
                    },
                    'keenam': {
                        required: 'Isikan harga per M3',
                        number: 'Harus Angka'
                    },
                    'denda': {
                        required: 'Isikan denda perbulan',
                        number: 'Harus Angka'
                    }
                }
            });

            $("#form-validation").submit(function(e) {
                e.preventDefault();
            });
        </script>


<!-- Table Styles Header -->
<div class="content-header">
    <div class="row">
        <div class="col-sm-12">
            <div class="header-section">
                <h1>GOLONGAN</h1>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="block full">
            <div class="block-title">
                <h2>ACTION</h2>
            </div>
            <a href="#modal-add" type="button" class="btn btn-effect-ripple btn-primary" data-toggle="modal" id="btn-add"><i class="fa fa-plus"></i> Tambah</a>
        </div>
    </div>
</div>

<div class="block full">
    <div class="block-title">
        <h2>Data Golongan</h2>
    </div>
    <div class="table-responsive">
        <table id="example-datatable" class="table table-striped table-bordered table-vcenter">
            <?php
            include "../config.php";
            $sql = $conn->query("SELECT * FROM golongan ORDER BY id_gol ASC");
            ?>
            <thead>
                <tr>
                    <th class="text-center" style="width: 50px;">NO</th>
                    <th>KODE</th>
                    <th>GOLONGAN</th>
                    <th width="125px">0 - 10 M3</th>
                    <th width="125px">11 - 20 M3</th>
                    <th width="125px">21 - 30 M3</th>
                    <th width="125px">31 - 40 M3</th>
                    <th width="125px">41 - 50 M3</th>
                    <th width="125px">51 - 60 M3</th>
                    <th>BEBAN</th>
                    <th>DENDA</th>
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
                    <td><?php echo $r['kd_gol'];?></td>
                    <td><?php echo $r['golongan'];?></td>
                    <td>Rp. <?php echo number_format($r['pertama']);?></td>
                    <td>Rp. <?php echo number_format($r['kedua']);?></td>
                    <td>Rp. <?php echo number_format($r['ketiga']);?></td>
                    <td>Rp. <?php echo number_format($r['keempat']);?></td>
                    <td>Rp. <?php echo number_format($r['kelima']);?></td>
                    <td>Rp. <?php echo number_format($r['keenam']);?></td>
                    <td>Rp. <?php echo number_format($r['harga']);?></td>
                    <td>Rp. <?php echo number_format($r['denda']);?></td>
                    <td>
                        <a href="javascript:void(0)" data-toggle="tooltip" title="Edit User" class="btn btn-effect-ripple btn-xs btn-success" onclick="lihat(<?php echo $r['id_gol'];?>)"><i class="fa fa-pencil"></i></a>
                        <a href="javascript:void(0)" data-toggle="tooltip" title="Delete User" class="btn btn-effect-ripple btn-xs btn-danger" onclick="hapus(<?php echo $r['id_gol'];?>)"><i class="fa fa-times"></i></a>
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
                            <h2 id="judul"></h2>
                        </div>
                        <form id="form-validation" action="#" class="form-horizontal form-bordered">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Golongan <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input type="hidden" id="id_gol" name="id_gol">
                                    <input type="text" id="kd_gol" name="kd_gol" class="form-control" placeholder="Isikan kode golongan" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Kelompok<span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama Golongan">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">0 - 10 M3 <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input type="text" id="pertama" name="pertama" class="form-control" placeholder="20000">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">11 - 20 M3 <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input type="text" id="kedua" name="kedua" class="form-control" placeholder="20000">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">21 - 30 M3 <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input type="text" id="ketiga" name="ketiga" class="form-control" placeholder="20000">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">31 - 40 M3 <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input type="text" id="keempat" name="keempat" class="form-control" placeholder="20000">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">41 - 50 M3 <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input type="text" id="kelima" name="kelima" class="form-control" placeholder="20000">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">51 M3 Keatas <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input type="text" id="keenam" name="keenam" class="form-control" placeholder="20000">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Beban <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input type="text" id="harga" name="harga" class="form-control" placeholder="20000">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="val-digits">Denda <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input type="text" id="denda" name="denda" class="form-control" placeholder="1000">
                                </div>
                            </div>

                            <div class="form-group form-actions pull-right">
                                <div class="col-md-9 col-md-offset-3">
                                    <button type="submit" class="btn btn-success" id="submit">Submit</button>
                                    <button type="submit" class="btn btn-danger" id="update">Update</button>
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

$( "#btn-add" ).click(function() {
    $('#form-validation')[0].reset();
    $('#submit').show();
    $('#update').hide();
    $('#judul').text('TAMBAH DATA GOLONGAN');
});

$( "#submit" ).click(function(event) {
    if ($('#form-validation').valid()){
        simpan();
    }
    event.preventDefault();
});

$( "#update" ).click(function(event) {
    if ($('#form-validation').valid()){
        ubah();
    }
    event.preventDefault();
});

$("#pertama").on('keyup', function(){
        var m = $(this).val().replace(/[^0-9-.]/g, '')
        var n = m.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
        $(this).val(n);
});
$("#kedua").on('keyup', function(){
        var m = $(this).val().replace(/[^0-9-.]/g, '')
        var n = m.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
        $(this).val(n);
});
$("#ketiga").on('keyup', function(){
        var m = $(this).val().replace(/[^0-9-.]/g, '')
        var n = m.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
        $(this).val(n);
});
$("#keempat").on('keyup', function(){
        var m = $(this).val().replace(/[^0-9-.]/g, '')
        var n = m.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
        $(this).val(n);
});
$("#kelima").on('keyup', function(){
        var m = $(this).val().replace(/[^0-9-.]/g, '')
        var n = m.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
        $(this).val(n);
});
$("#keenam").on('keyup', function(){
        var m = $(this).val().replace(/[^0-9-.]/g, '')
        var n = m.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
        $(this).val(n);
});
$("#harga").on('keyup', function(){
        var m = $(this).val().replace(/[^0-9-.]/g, '')
        var n = m.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
        $(this).val(n);
});
$("#denda").on('keyup', function(){
        var m = $(this).val().replace(/[^0-9-.]/g, '')
        var n = m.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
        $(this).val(n);
});

function simpan(){
    var kd_gol      = $('#kd_gol').val();
    var nama        = $('#nama').val();
    var pertama     = $('#pertama').val().replace(/[^0-9-.]/g, '');
    var kedua       = $('#kedua').val().replace(/[^0-9-.]/g, '');
    var ketiga      = $('#ketiga').val().replace(/[^0-9-.]/g, '');
    var keempat     = $('#keempat').val().replace(/[^0-9-.]/g, '');
    var kelima      = $('#kelima').val().replace(/[^0-9-.]/g, '');
    var keenam      = $('#keenam').val().replace(/[^0-9-.]/g, '');
    var harga       = $('#harga').val().replace(/[^0-9-.]/g, '');
    var denda       = $('#denda').val().replace(/[^0-9-.]/g, '');
                        
    $.ajax({
        url     : 'modal/golongan.php',
        data    : 'tambah='+kd_gol+'&nama='+nama+'&pertama='+pertama+'&kedua='+kedua+'&ketiga='+ketiga+'&keempat='+keempat+'&kelima='+kelima+'&keenam='+keenam+'&harga='+harga+'&denda='+denda, 
        type    : 'POST',
        dataType: 'html',
        success : function(pesan){
            if(pesan=='ok'){
                $('#modal-add').modal('hide');
                $('#form-validation')[0].reset();
                swal('SUKSES!', 'Tambah data golongan berhasil', 'success');
                setTimeout(function(){ load('golongan'); }, 1000);
            }
            else{
                swal('PERINGATAN!', 'Tambah data golongan gagal', 'warning');
            }
        },
    });
}

function ubah(){
    var id          = $('#id_gol').val();
    var kd_gol      = $('#kd_gol').val();
    var nama        = $('#nama').val();
    var pertama     = $('#pertama').val().replace(/[^0-9-.]/g, '');
    var kedua       = $('#kedua').val().replace(/[^0-9-.]/g, '');
    var ketiga      = $('#ketiga').val().replace(/[^0-9-.]/g, '');
    var keempat     = $('#keempat').val().replace(/[^0-9-.]/g, '');
    var kelima      = $('#kelima').val().replace(/[^0-9-.]/g, '');
    var keenam      = $('#keenam').val().replace(/[^0-9-.]/g, '');
    var harga       = $('#harga').val().replace(/[^0-9-.]/g, '');
    var denda       = $('#denda').val().replace(/[^0-9-.]/g, '');
                        
    $.ajax({
        url     : 'modal/golongan.php',
        data    : 'ubah='+id+'&kd_gol='+kd_gol+'&nama='+nama+'&pertama='+pertama+'&kedua='+kedua+'&ketiga='+ketiga+'&keempat='+keempat+'&kelima='+kelima+'&keenam='+keenam+'&harga='+harga+'&denda='+denda, 
        type    : 'POST',
        dataType: 'html',
        success : function(pesan){
            if(pesan=='ok'){
                $('#modal-add').modal('hide');
                $('#form-validation')[0].reset();
                swal('SUKSES!', 'Edit data golongan berhasil', 'success');
                setTimeout(function(){ load('golongan'); }, 1000);
            }
            else{
                swal('PERINGATAN!', 'Edit data golongan gagal', 'warning');
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
            url     : 'modal/golongan.php',
            data    : 'hapus='+id, 
            type    : 'POST',
            dataType: 'html',
            success : function(pesan){
                if(pesan=='ok'){
                    swal({title: "SUKSES!",text: "Data telah terhapus!",type:"success",timer: 1500,showConfirmButton: false});
                    setTimeout(function(){ load('golongan'); }, 1000);
                }else{
                    swal('PERINGATAN!', 'Hapus data golongan gagal', 'warning');
                }
            },
        });
    });
}

function lihat(id_gol){
    $('#submit').hide();
    $('#update').show();
    $('#judul').text('EDIT DATA GOLONGAN');

    $.ajax({
        url     : 'modal/golongan.php',
        data    : 'lihat='+id_gol, 
        type    : 'POST',
        dataType: 'JSON',
        success : function(pesan){
            if(pesan != null){
                $('#form-validation')[0].reset();
                $('#id_gol').val(pesan.id_gol);
                $('#kd_gol').val(pesan.kd_gol);
                $('#nama').val(pesan.golongan);
                $('#pertama').val(pesan.pertama);
                $('#kedua').val(pesan.kedua);
                $('#ketiga').val(pesan.ketiga);
                $('#keempat').val(pesan.keempat);
                $('#kelima').val(pesan.kelima);
                $('#keenam').val(pesan.keenam);
                $('#harga').val(pesan.harga);
                $('#denda').val(pesan.denda);
                $('#modal-add').modal('show');
            }
            else{
                swal('PERINGATAN!', 'Lihat data golongan gagal', 'warning');
            }
        },
    });
}
</script>