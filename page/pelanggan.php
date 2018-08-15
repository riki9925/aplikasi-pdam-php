        <script type="text/javascript">

            App.datatables();
            $('#example-datatable').dataTable({
                columnDefs: [ { orderable: false, targets: [ 7 ] } ],
                pageLength: 10,
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
                    'no-ktp': {
                        required: true,
                        digits: true,
                        minlength: 16
                    },
                    'nama': {
                        required: true
                    },
                    'alamat': {
                        required: true
                        // minlength: 10
                    },
                    'tanggal': {
                        required: true
                    },
                    'id_golongan': {
                        required: true
                    }
                },
                messages: {
                    'no-ktp': {
                        required: 'Isikan no-ktp pelanggan',
                        digits: 'Harus angka',
                        minlength: 'Jumlah data harus 16'
                    },
                    'nama': 'Isikan nama pelanggan',
                    'alamat': 'Isikan alamat pelanggan',
                    'tanggal': 'Isikan tanggal pendaftaran pelanggan',
                    'id_golongan': 'Isikan golongan pelanggan'
                }
            });

            $("#form-validation").submit(function(e) {
                e.preventDefault();
            });

        </script>
        <script src="js/app.js"></script>


<!-- Table Styles Header -->
<div class="content-header">
    <div class="row">
        <div class="col-sm-12">
            <div class="header-section">
                <h1>Pelanggan</h1>
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
        <h2>Data Pelanggan</h2>
    </div>
    <div class="table-responsive">
        <table id="example-datatable" class="table table-striped table-bordered table-vcenter">
            <?php
            include "../config.php";
            $sql = $conn->query("
            SELECT
            pelanggan.id_pel,
            pelanggan.nopel,
            pelanggan.nama,
            pelanggan.alamat,
            pelanggan.no_telp,
            DATE_FORMAT(pelanggan.tanggal,'%d-%m-%Y') tanggal,
            pelanggan.gol,
            pelanggan.no_mtr,
            pelanggan.akses,
            pelanggan.area,
            golongan.golongan
            FROM
            pelanggan
            LEFT JOIN golongan ON golongan.id_gol = pelanggan.gol
            ORDER BY pelanggan.id_pel ASC");
            ?>
            <thead>
                <tr>
                    <th class="text-center" style="width: 50px;">NO</th>
                    <th>NO KTP</th>
                    <th>NAMA</th>
                    <th>ALAMAT</th>
                    <th>NO TELPON</th>
                    <th>TANGGAL</th>
                    <th>GOL</th>
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
                    <td><?php echo $r['nopel'];?></td>
                    <td><?php echo $r['nama'];?></td>
                    <td><?php echo $r['alamat'];?></td>
                    <td><?php echo $r['no_telp'];?></td>
                    <td><?php echo $r['tanggal'];?></td>
                    <td><?php echo $r['golongan'];?></td>
                    <td>
                        <a href="javascript:void(0)" data-toggle="tooltip" title="Edit User" class="btn btn-effect-ripple btn-xs btn-success" onclick="lihat(<?php echo $r['id_pel'];?>)"><i class="fa fa-pencil"></i></a>
                        <a href="javascript:void(0)" data-toggle="tooltip" title="Delete User" class="btn btn-effect-ripple btn-xs btn-danger" onclick="hapus(<?php echo $r['id_pel'];?>)"><i class="fa fa-times"></i></a>
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
                                <label class="col-md-3 control-label">No KTP <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input type="hidden" id="id_pel" name="id_pel">
                                    <input type="text" id="no-ktp" name="no-ktp" class="form-control" placeholder="1234567890123456" maxlength="16">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Nama <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama pelanggan">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Alamat <span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <textarea id="alamat" name="alamat" rows="5" class="form-control" placeholder="Alamat pelanggan"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="val-digits">No Telp <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input type="text" id="no-telp" name="no-telp" class="form-control" placeholder="085711110000" maxlength="12">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="val-digits">Tanggal <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input type="text" id="tanggal" name="tanggal" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="val-digits">Golongan <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <select id="id_golongan" name="golongan" data-placeholder="Pilih golongan" style="width: 100%;">
                                        <?php
                                        $sql = $conn->query("SELECT * FROM golongan ORDER BY id_gol DESC");
                                        while($r=$sql->fetch_assoc()){
                                        ?>
                                        <option value="<?php echo $r['id_gol'];?>"> <?php echo $r['golongan'];?> </option>
                                        <?php } ?>
                                    </select>
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

$( "#btn-add" ).click(function(event) {
    $('#form-validation')[0].reset();
    $('#submit').show();
    $('#update').hide();
    $('#judul').text('TAMBAH DATA PELANGGAN');
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

function simpan(){
    var no_ktp  = $('#no-ktp').val();
    var nama    = $('#nama').val();
    var alamat  = $('#alamat').val();
    var no_telp = $('#no-telp').val();
    var tanggal = $('#tanggal').val();
    var golongan = $('#id_golongan').val();
                        
    $.ajax({
        url     : 'modal/pelanggan.php',
        data    : 'tambah='+no_ktp+'&nama='+nama+'&alamat='+alamat+'&no_telp='+no_telp+'&tanggal='+tanggal+'&golongan='+golongan, 
        type    : 'POST',
        dataType: 'html',
        success : function(pesan){
            if(pesan=='ok'){
                $('#modal-add').modal('hide');
                $('#form-validation')[0].reset();
                swal('SUKSES!', 'Tambah data pelanggan berhasil', 'success');
                setTimeout(function(){ load('pelanggan'); }, 1000);
            }
            else{
                swal('PERINGATAN!', 'Tambah data pelanggan gagal', 'warning');
            }
        },
    });
}

function ubah(){
    var id      = $('#id_pel').val();
    var no_ktp  = $('#no-ktp').val();
    var nama    = $('#nama').val();
    var alamat  = $('#alamat').val();
    var no_telp = $('#no-telp').val();
    var tanggal = $('#tanggal').val();
    var golongan = $('#id_golongan').val();
                        
    $.ajax({
        url     : 'modal/pelanggan.php',
        data    : 'ubah='+id+'&no_ktp='+no_ktp+'&nama='+nama+'&alamat='+alamat+'&no_telp='+no_telp+'&tanggal='+tanggal+'&golongan='+golongan, 
        type    : 'POST',
        dataType: 'html',
        success : function(pesan){
            if(pesan=='ok'){
                $('#modal-add').modal('hide');
                $('#form-validation')[0].reset();
                swal('SUKSES!', 'Edit data pelanggan berhasil', 'success');
                setTimeout(function(){ load('pelanggan'); }, 1000);
            }
            else{
                swal('PERINGATAN!', 'Edit data pelanggan gagal', 'warning');
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
            url     : 'modal/pelanggan.php',
            data    : 'hapus='+id, 
            type    : 'POST',
            dataType: 'html',
            success : function(pesan){
                if(pesan=='ok'){
                    swal({title: "SUKSES!",text: "Data telah terhapus!",type:"success",timer: 1500,showConfirmButton: false});
                    setTimeout(function(){ load('pelanggan'); }, 1000);
                }else{
                    swal('PERINGATAN!', 'Hapus data pelanggan gagal', 'warning');
                }
            },
        });
    });
}

function lihat(id_pel){
    $('#submit').hide();
    $('#update').show();
    $('#judul').text('EDIT DATA PELANGGAN');

    $.ajax({
        url     : 'modal/pelanggan.php',
        data    : 'lihat='+id_pel, 
        type    : 'POST',
        dataType: 'JSON',
        success : function(pesan){
            if(pesan != null){
                $('#form-validation')[0].reset();
                $('#id_pel').val(pesan.id_pel);
                $('#no-ktp').val(pesan.nopel);
                $('#nama').val(pesan.nama);
                $('#alamat').val(pesan.alamat);
                $('#no-telp').val(pesan.no_telp);
                $('#tanggal').val(pesan.tanggal);
                $('#id_golongan').val(pesan.gol).change();
                $('#modal-add').modal('show');
            }
            else{
                swal('PERINGATAN!', 'Lihat data pelanggan gagal', 'warning');
            }
        },
    });
}
</script>