@extends('layout.backend.app',[
'title' => 'Blank Page',
'pageTitle' => "Edit Notasi",
])
@section('content')

    @push('css')
        <style>
            .text-overview {
                overflow: hidden;
                text-overflow: ellipsis;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                /* number of lines to show */
                -webkit-box-orient: vertical;
            }

            .c-dialog {
                z-index: 10055 !important;
            }

        </style>
    @endpush

    <script>
        $(".alert").alert();

    </script>
    <div class="notify"></div>

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong> {{ session()->get('success') }}</strong>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong> {{ session()->get('error') }}</strong>
        </div>
    @endif

    <div class="card border-left-primary shadow h-100">
        <div id="accordianId" role="tablist" aria-multiselectable="true">
            <form action="{{ route('notation.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header" role="tab" id="section1HeaderId">
                        <h5 class="mb-0">
                            <a data-toggle="collapse" data-parent="#accordianId" href="#newFormula" aria-expanded="true"
                                aria-controls="newFormula">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#create-modal">
                                    Tambah Notasi Baru
                                </button>
                            </a>
                        </h5>
                    </div>
                    <div id="newFormula" class="collapse in" role="tabpanel" aria-labelledby="section1HeaderId">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="form-group">
                                        <div class="font-weight-bold text-primary text-uppercase mb-1">Nama Notasi</div>
                                        <textarea class="form-control" name="notation" id="editor1" rows="1"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <div class="font-weight-bold text-primary text-uppercase mb-1">Cara Baca Notasi
                                        </div>
                                        <input type="text" class="form-control" name="read" id="" aria-describedby="helpId"
                                            placeholder="Cara Baca">
                                    </div>

                                    <div class="form-group">
                                        <div class="font-weight-bold text-primary text-uppercase mb-1">Deskripsi</div>
                                        <textarea class="form-control" name="content" id="editor2" rows="5"></textarea>
                                    </div>




                                    <div class="form-group">
                                        <label for="">File Audio ( Jika Ada )</label>
                                        <input type="file" class="form-control-file" name="audio_file" id="" placeholder=""
                                            aria-describedby="fileHelpId">
                                        <small id="fileHelpId" class="form-text text-muted">Upload File Audio Untuk Text to
                                            Speech ( Opsional , di Android sudah ada fitur terkait )</small>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>



    </div>

    <div class="card border-left-primary shadow h-100 mt-3">
        <div class="card">
            <div class="card-header">
                Data Notasi Matematika
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered data-table w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Notasi</th>
                                <th>Cara Baca</th>
                                <th>Edit</th>
                                <th>Hapus</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    @push('js')
        <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.7/MathJax.js?config=TeX-MML-AM_CHTML"></script>
        <script>
            CKEDITOR.replace('editor1', {
                filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
                filebrowserUploadMethod: 'form'
            });

            CKEDITOR.replace('editor2', {
                filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
                filebrowserUploadMethod: 'form'
            });

            CKEDITOR.replace('editor3', {
                filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
                filebrowserUploadMethod: 'form'
            });

            CKEDITOR.replace('editor4', {
                filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
                filebrowserUploadMethod: 'form'
            });

        </script>


        <script src="{{ asset('template/backend/sb-admin-2') }}/vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="{{ asset('template/backend/sb-admin-2') }}/vendor/datatables/dataTables.bootstrap4.min.js"></script>
        <script src="{{ asset('template/backend/sb-admin-2') }}/js/demo/datatables-demo.js"></script>

        <script type="text/javascript">
            $(function() {
                var table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    "ajax": {
                        "url": "{{ route('notation.fetch') }}",
                        "type": "POST",
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'id'
                        },
                        {
                            render: function(datum, type, row) {

                                const html = '<h5>' + row.notation + '</h5>';
                                return '' + html + '';
                            }
                        },
                        {
                            data: 'read',
                        },
                        {
                            render: function(datum, type, row) {
                                const html =
                                    '<button id="' + row.id + '" class="btn btn-danger btn-delete">' +
                                    '<span class="icon text-white-50">' +
                                    '<i class="fas fa-trash"></i>  </span>' +
                                    '<span class = "text" > Hapus Notasi </span>'
                                '</button>';
                                return html;
                            }
                        },
                        {
                            render: function(datum, type, row) {
                                console.log(row.id);
                                const html =
                                    '<button id="' + row.id + '" class="btn btn-success btn-edit">' +
                                    '<span class="icon text-white-50">' +
                                    '<i class="fas fa-pen"></i>  </span>' +
                                    '<span class = "text" > Edit Notasi </span>'
                                '</button>';
                                return html;
                            }
                        }

                    ]
                });
            });

            // Edit & Update
            $('body').on("click", ".btn-edit", function() {
                var id = $(this).attr("id")
                console.log("ID-nya apa weh " + id)
                $.ajax({
                    url: "/admin/notation/" + id + "/edit/",
                    method: "GET",
                    success: function(response) {
                        console.log(response);
                        console.log(response.notation);
                        $("#edit-modal").modal("show")
                        CKEDITOR.instances.editor4.setData( response.notation );
                        $("#id").val(response.id)
                        $("#e_read").val(response.read)
                        $("#editor4").val(response.notation)
                    }
                })
            });

            $("#editForm").on("submit", function(e) {
                e.preventDefault()
                var id = $("#id").val()

                $.ajax({
                    url: "/admin/user/" + id,
                    method: "PATCH",
                    data: $(this).serialize(),
                    success: function() {
                        $('.data-table').DataTable().ajax.reload();
                        $("#edit-modal").modal("hide")
                        flash("success", "Data berhasil diupdate")
                    }
                })
            })
            //Edit & Update
            $('body').on("click", ".btn-delete", function() {
                var id = $(this).attr("id")
                console.log("id " + id);
                $(".btn-destroy").attr("id", id)
                $("#destroy-modal").modal("show")
            });

            $(".btn-destroy").on("click", function() {
                var id = $(this).attr("id")
                console.log("id hapus : " + id)
                $.ajax({
                    url: "{{ url('admin/notation') }}" + '/' + id,
                    method: "DELETE",
                    success: function() {
                        $("#destroy-modal").modal("hide")
                        $('.data-table').DataTable().ajax.reload();
                        flash('success', 'Data berhasil dihapus')
                    },
                    error: function(x, status, error) {
                        if (x.status == 403) {
                            alert("Sorry, your session has expired. Please login again to continue");
                            window.location.href = "/Account/Login";
                        } else {
                            alert("An error occurred: " + x + status + "nError: " + error);
                        }
                    }
                });
            })

            function flash(type, message) {
                $(".notify").html(`<div class="alert alert-` + type +
                    ` alert-dismissible fade show" role="alert">
                                                                                                                                                                              ` +
                    message +
                    `
                                                                                                                                                                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                                                                                                                                <span aria-hidden="true">&times;</span>
                                                                                                                                                                              </button>
                                                                                                                                                                            </div>`
                )
            }

        </script>

    @endpush

    <!-- Destroy Modal -->
    <div class="modal fade" id="destroy-modal" tabindex="-1" role="dialog" aria-labelledby="destroy-modalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="destroy-modalLabel">Yakin Hapus ?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger btn-destroy">Hapus</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Destroy Modal -->


    <!-- Modal Edit -->
    <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit-modalLabel">Edit Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <div class="form-group">
                            <div class="font-weight-bold text-primary text-uppercase mb-1">Cara Baca Notasi
                            </div>
                            <input type="text" class="form-control c-dialog e_read" name="edit_read" id="e_read"
                                aria-describedby="helpId" placeholder="Cara Baca">
                        </div>

                        <div class="form-group">
                            <div class="font-weight-bold text-primary text-uppercase mb-1">Nama Notasi</div>
                            <textarea class="form-control c-dialog e_notation" name="edit_notation" id="editor4" rows="1"></textarea>
                        </div>

                        <div class="form-group">
                            <div class="font-weight-bold text-primary text-uppercase mb-1">Deskripsi</div>
                            <textarea class="form-control c-dialog e_description" name="edit_content" id="editor3" rows="5"></textarea>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-update">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Edit -->



@stop
