        <script type="text/javascript">

            App.datatables();
            $('#example-datatable').dataTable({
                columnDefs: [ { orderable: false, targets: [ 5 ] } ],
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
                    'no_ktp': {
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
                    'no-telp': {
                        required: true,
                        digits: true,
                        minlength: 10
                    }
                },
                messages: {
                    'no_ktp': {
                        required: 'Isikan no_ktp pegawai',
                        digits: 'Harus angka',
                        minlength: 'Jumlah data harus 16'
                    },
                    'nama': 'Isikan nama pegawai',
                    'alamat': 'Isikan alamat pegawai',
                    'no-telp': {
                        required: 'Isikan no telpon pegawai',
                        digits: 'Harus Angka',
                        minlength: 'Jumlah data harus lebih dari 10'
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
                <h1>PEGAWAI</h1>
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
        <h2>Data Pegawai</h2>
    </div>
    <div class="table-responsive">
        <table id="example-datatable" class="table table-striped table-bordered table-vcenter">
            <?php
            include "../config.php";
            $sql = $conn->query("SELECT * FROM pegawai ORDER BY id_peg ASC");
            ?>
            <thead>
                <tr>
                    <th class="text-center" style="width: 50px;">NO</th>
                    <th>NO KTP</th>
                    <th>NAMA</th>
                    <th>ALAMAT</th>
                    <th style="width: 120px;">NO TELPON</th>
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
                    <td><?php echo $r['no_ktp'];?></td>
                    <td><?php echo $r['nama'];?></td>
                    <td><?php echo $r['alamat'];?></td>
                    <td><?php echo $r['no_telp'];?></td>
                    <td>
                        <a href="javascript:void(0)" data-toggle="tooltip" title="Edit User" class="btn btn-effect-ripple btn-xs btn-success" onclick="lihat(<?php echo $r['id_peg'];?>)"><i class="fa fa-pencil"></i></a>
                        <a href="javascript:void(0)" data-toggle="tooltip" title="Delete User" class="btn btn-effect-ripple btn-xs btn-danger" onclick="hapus(<?php echo $r['id_peg'];?>)"><i class="fa fa-times"></i></a>
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
                                    <input type="hidden" id="id_peg" name="id_peg">
                                    <input type="text" id="no_ktp" name="no_ktp" class="form-control" placeholder="1234567890123456" maxlength="16">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Nama <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama pegawai">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Alamat <span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <textarea id="alamat" name="alamat" rows="5" class="form-control" placeholder="Alamat pegawai"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="val-digits">No Telp <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input type="text" id="no-telp" name="no-telp" class="form-control" placeholder="085711110000" maxlength="12">
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
    $('#judul').text('TAMBAH DATA PEGAWAI');
});

$( "#submit" ).click(function() {
    if ($('#form-validation').valid()){
        simpan();
    }
    event.preventDefault();
});

$( "#update" ).click(function() {
    if ($('#form-validation').valid()){
        ubah();
    }
    event.preventDefault();
});

function simpan(){
    var no_ktp  = $('#no_ktp').val();
    var nama    = $('#nama').val();
    var alamat  = $('#alamat').val();
    var no_telp = $('#no-telp').val();
                        
    $.ajax({
        url     : 'modal/pegawai.php',
        data    : 'tambah='+no_ktp+'&nama='+nama+'&alamat='+alamat+'&no_telp='+no_telp, 
        type    : 'POST',
        dataType: 'html',
        success : function(pesan){
            if(pesan=='ok'){
                $('#modal-add').modal('hide');
                $('#form-validation')[0].reset();
                swal('SUKSES!', 'Tambah data pegawai berhasil', 'success');
                setTimeout(function(){ load('pegawai'); }, 1000);
            }
            else{
                swal('PERINGATAN!', 'Tambah data pegawai gagal', 'warning');
            }
        },
    });
}

function ubah(){
    var id      = $('#id_peg').val();
    var no_ktp  = $('#no_ktp').val();
    var nama    = $('#nama').val();
    var alamat  = $('#alamat').val();
    var no_telp = $('#no-telp').val();
                        
    $.ajax({
        url     : 'modal/pegawai.php',
        data    : 'ubah='+id+'&no_ktp='+no_ktp+'&nama='+nama+'&alamat='+alamat+'&no_telp='+no_telp, 
        type    : 'POST',
        dataType: 'html',
        success : function(pesan){
            if(pesan=='ok'){
                $('#modal-add').modal('hide');
                $('#form-validation')[0].reset();
                swal('SUKSES!', 'Edit data pegawai berhasil', 'success');
                setTimeout(function(){ load('pegawai'); }, 1000);
            }
            else{
                swal('PERINGATAN!', 'Edit data pegawai gagal', 'warning');
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
            url     : 'modal/pegawai.php',
            data    : 'hapus='+id, 
            type    : 'POST',
            dataType: 'html',
            success : function(pesan){
                if(pesan=='ok'){
                    swal({title: "SUKSES!",text: "Data telah terhapus!",type:"success",timer: 1500,showConfirmButton: false});
                    setTimeout(function(){ load('pegawai'); }, 1000);
                }else{
                    swal('PERINGATAN!', 'Hapus data pegawai gagal', 'warning');
                }
            },
        });
    });
}

function lihat(id_peg){
    $('#submit').hide();
    $('#update').show();
    $('#judul').text('EDIT DATA PEGAWAI');

    $.ajax({
        url     : 'modal/pegawai.php',
        data    : 'lihat='+id_peg, 
        type    : 'POST',
        dataType: 'JSON',
        success : function(pesan){
            if(pesan != null){
                $('#form-validation')[0].reset();
                $('#id_peg').val(pesan.id_peg);
                $('#no_ktp').val(pesan.no_ktp);
                $('#nama').val(pesan.nama);
                $('#alamat').val(pesan.alamat);
                $('#no-telp').val(pesan.no_telp);
                $('#modal-add').modal('show');
            }
            else{
                swal('PERINGATAN!', 'Lihat data pegawai gagal', 'warning');
            }
        },
    });
}
</script>