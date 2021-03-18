@extends('layout.backend.app',[
'title' => 'Blank Page',
'pageTitle' => "Edit Rumus Untuk ".$class->class_name,
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
            <form action="{{ route('formula.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="category_id" value="{{ $class->id }}">
                <div class="card">
                    <div class="card-header" role="tab" id="section1HeaderId">
                        <h5 class="mb-0">
                            <a data-toggle="collapse" data-parent="#accordianId" href="#newFormula" aria-expanded="true"
                                aria-controls="newFormula">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#create-modal">
                                    Buat Rumus Baru Untuk Kelas {{ $class->class_name }}
                                </button>
                            </a>
                        </h5>
                    </div>
                    <div id="newFormula" class="collapse in" role="tabpanel" aria-labelledby="section1HeaderId">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Nama
                                        Rumus
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="title" id="" aria-describedby="helpId"
                                            placeholder="">
                                        <small id="helpId" class="form-text text-muted">Masukkan Nama Rumus
                                            Disini</small>
                                    </div>

                                    <div class="form-group">
                                      <label for="">File PDF ( Disarankan Untuk Operasi Matematika Yang Kompleks )</label>
                                      <input type="file" class="form-control-file" name="pdf_file" id="" accept=".pdf" placeholder="" aria-describedby="fileHelpId">
                                      <small id="fileHelpId" class="form-text text-muted">Gunakan File PDF jika operasi matematika terlalu kompleks</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Judul Rumus</label>
                                        <textarea class="form-control" name="content" id="editor" rows="5"></textarea>
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
                Data Rumus Matematika {{ $class->class_name }}
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered data-table w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Rumus</th>
                                <th>Detail</th>
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

            CKEDITOR.replace('editor', {
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
                        "url": "{{ route('formula.fetch') }}",
                        "type": "POST",
                        "data": {
                            "id": "{{ $class->id }}",

                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'id'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            render: function(datum, type, row) {
                                const html =
                                    '<a href="{{ url('formula/') }}' + "/" + row.id + '">' +
                                    '<button class="btn btn-success">' +
                                    'Lihat Rumus <span class="badge badge-primary"></span>' +
                                    '</button>' +
                                    '</a>';

                                return html;
                            }
                        }, {
                            render: function(datum, type, row) {
                                console.log(row.id);
                                const html =
                                    '<button id="' + row.id + '" class="btn btn-danger btn-delete">' +
                                    '<span class="icon text-white-50">' +
                                    '<i class="fas fa-trash"></i>  </span>' +
                                    '<span class = "text" > Hapus Rumus </span>'
                                '</button>';
                                return html;
                            }
                        }

                    ]
                });
            });

            $('#button1').on('click', function() {
                $('#openModal').show();
            });

            // Create 

            $("#createForm").on("submit", function(e) {
                e.preventDefault()
                $.ajax({
                    url: "/admin/user",
                    method: "POST",
                    data: $(this).serialize(),
                    success: function() {
                        $("#create-modal").modal("hide")
                        $('.data-table').DataTable().ajax.reload();
                        flash("success", "Data berhasil ditambah")
                        resetForm()
                    }
                })
            })


            // Edit & Update
            $('body').on("click", ".btn-edit", function() {
                var id = $(this).attr("id")
                $.ajax({
                    url: "/admin/user/" + id + "/edit",
                    method: "GET",
                    success: function(response) {
                        $("#edit-modal").modal("show")
                        $("#id").val(response.id)
                        $("#name").val(response.name)
                        $("#email").val(response.email)
                        $("#role").val(response.role)
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
                    url: "{{ url('admin/formula') }}" + '/' + id,
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
                                                                                                                            </div>`)
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



@stop
