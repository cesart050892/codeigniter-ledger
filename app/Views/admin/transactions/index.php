<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>
Transactions
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Basic Card Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 mt-1 font-weight-bold text-primary">Transaction</h6>
            <button type="button" class="btn btn-primary btn-sm" id="btn-new-transaction">
                <i class="fas fa-plus-square"></i>
                Add New Transaction
            </button>
        </div>
        <div class="card-body">
            <table id="transaction" class="table table-hover table-bordered table-striped display nowrap" style="width:100%">
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
    $(function() {
        $('#input-type').select2({});
    });
    //------- SweetAlert2 -------------
    const swal = Swal.mixin({
        confirmButtonColor: '#4C71DD',
        cancelButtonColor: '#898A99',
    })
    //------- DataTable -------------
    var table = $("#transaction").DataTable({
        "lengthMenu": [
            [3, 5, 10, -1],
            [3, 5, 10, "All"]
        ],
        ajax: {
            type: "GET",
            url: baseUrl + '/api/transactions',
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
                data: "Transaction",
                title: "transaction"
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
                $.get(baseUrl + '/api/transactions/delete/' + id, () => {
                    table.ajax.reload(null, false);
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 1000
                    })
                });
            }
        })
    }
    window.stateFunction = true
    function edit(id) {
        $.get(baseUrl + '/api/transactions/edit/' + id, (response) => {
            sessionStorage.setItem('idtransaction', id)
            render({
                    title: 'Update',
                    result: response.data
                },
                false
            );
        });
    }

    $('#btn-new-transaction').click(function(e) {
        if (!window.stateFunction) window.stateFunction = true;
        e.preventDefault();
        render({
            title: 'Save',
        }, )
    });

    $('form').submit(function(e) {
        e.preventDefault();
        data = $(this).serialize()
        stateFunction ? ajaxSave(data) : ajaxUpdate(data);
    });

    function ajaxSave(data) {
        $.ajax({
            type: "POST",
            url: baseUrl + "/api/transactions",
            data: data,
            success: function(response) {
                table.ajax.reload();
                $('#transactionModal').modal('hide');
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Your work has been saved',
                    showConfirmButton: false,
                    timer: 1000
                })
            },
            error: function(err, status, thrown){
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Error when saving, check your data.',
                    showConfirmButton: false,
                    timer: 1000
                })
            }
        });
    }

    function ajaxUpdate(data) {
        data = `${data}&id=${sessionStorage.getItem('idtransaction')}`
        sessionStorage.removeItem('idtransaction')
        $.ajax({
            type: "POST",
            url: baseUrl + "/api/transactions/update",
            data: data,
            success: function(response) {
                table.ajax.reload();
                $('#transactionModal').modal('hide');
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Your work has been updated',
                    showConfirmButton: false,
                    timer: 1000
                })
            }
        });
    }

    function render(data, option = true) {
        $('#transactionModal').modal('show');
        !option ? renderUpdate(data) : renderSave(data);
    }

    function renderUpdate(data) {
        $('.modal-title').text(data.title)
        $('.btn-submit').text(data.title)
        $('#input-transaction').val(data.result.transaction)
        $('#input-code').val(data.result.code)
        getTypetransaction()
    }

    function renderSave(data) {
        $('.modal-title').text(data.title)
        $('.btn-submit').text(data.title)
        $('#input-transaction').val('')
        $('#input-code').val('')
        getTypetransaction()
    }

    stateSelect = true

    function getTypetransaction() {
        if (stateSelect) {
            $.get(baseUrl + '/api/transactions/type', (response) => {
                $.each(response.data, function(key, value) {
                    $('#input-type').append(`<option value="${value.id}">${value.type}</option>`);
                    $('#input-type').val(value.id).trigger('change');
                });
                stateSelect = false
            });
        }
    }
</script>
<?= $this->endSection() ?>

<?= $this->section('modal') ?>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#exampleModal">
    Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="transactionModal" role="dialog" tabindex="-1" aria-labelledby="transactionModalLabel" aria-hidden="true" data-mdb-backdrop="static" data-mdb-keyboard="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="transactionModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="container">
                        <div class="form-group row">
                            <label for="input-account" class="col-4 col-form-label">account</label>
                            <div class="col-8">
                                <select id="input-account" name="input-account" required="required" class="custom-select">
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="input-transaction" class="col-4 col-form-label">Transaction</label>
                            <div class="col-8">
                                <div class="input-group">
                                    <input id="input-transaction" name="input-transaction" type="text" required="required" class="form-control">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="fa fa-address-card"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="input-quantity" class="col-4 col-form-label">Quantity</label>
                            <div class="col-8">
                                <div class="input-group">
                                    <input id="input-quantity" name="input-quantity" type="text" required="required" class="form-control">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="fas fa-list-ol"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button name="submit" type="submit" class="btn btn-primary btn-submit"></button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Close
                </button>
            </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>