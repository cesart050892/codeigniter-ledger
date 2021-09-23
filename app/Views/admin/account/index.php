<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>
Accounts
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Basic Card Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Accounts</h6>
        </div>
        <div class="card-body">
            <table id="account" class="table table-hover table-bordered table-striped display nowrap" style="width:100%">
            </table>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
<?= $this->endSection() ?>

<?= $this->section('plugins-js') ?>
<!-- DataTables  & Plugins -->
<script type="text/javascript" src="<?= base_url('assets/plugins/datatables-min/js/pdfmake.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/plugins/datatables-min/js/vfs_fonts.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/plugins/datatables-min/js/datatables.min.js') ?>"></script>
<!-- Select2 -->
<script src="<?= base_url('assets/plugins/select2/js/select2.full.min.js') ?>"></script>
<?= $this->endSection() ?>

<?= $this->section('plugins-css') ?>
<!-- DataTables-->
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/plugins/datatables-min/css/datatables.min.css') ?>" />
<!-- Select2 -->
<link rel="stylesheet" href="<?= base_url('assets/plugins/select2/css/select2.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">
<?= $this->endSection() ?>


<?= $this->section('script') ?>
<script>
    //------- SweetAlert2 -------------
    const swal = Swal.mixin({
        confirmButtonColor: '#4C71DD',
        cancelButtonColor: '#898A99',
    })
    //------- DataTable -------------
    var table = $("#account").DataTable({
        ajax: {
            type: "GET",
            url: baseUrl + '/api/accounts',
            dataSrc: function(response) {
                return response.data;
            },
        },
        columns: [{
                data: null,
                title: "Code",
                render: function(data) {
                    return `${data.general}.${data.code}`;
                },
            },
            {
                data: "root",
                title: "Type"
            },
            {
                data: "account",
                title: "Account"
            },
            {
                data: null,
                title: "Actions",
                render: function(data) {
                    return `
          <div class='text-center'>
          <button class='btn btn-warning btn-sm' onClick="edit(${data.id})">
          <i class="fas fa-edit"></i>
          </button>
          <button class='btn btn-danger btn-sm' onClick="destroy(${data.id})">
          <i class="fas fa-trash"></i>
          </button>
          </div>`;
                },
            },
        ],
        columnDefs: [{
            className: "text-center",
            targets: "_all",
        }, ],
        responsive: true,
    });

    setInterval(function() {
        table.ajax.reload();
    }, 1000);

    function destroy(id) {
        swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.get(baseUrl + '/api/accounts/delete/' + id, () => {
                    table.ajax.reload(null, false);
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                });
            }
        })
    }

    function edit(id) {
        alert(id)
    }
</script>
<?= $this->endSection() ?>