@extends('layout.backend.app',[
'title' => 'Blank Page',
'pageTitle' => "Edit Rumus "
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




    <div class="card">
        <div class="card-body">
            <form action="{{ route('formula.update') }}" method="post">
                @csrf
                <input type="hidden" name="formula_id" value="{{ $formula->id }}">

                <h4 class="card-title">Edit Rumus</h4>
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Nama
                    Rumus
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="name" id="" aria-describedby="helpId"
                        placeholder="Nama Rumus" value="{{ $formula->name }}">
                    <small id="helpId" class="form-text text-muted">Masukkan Nama Rumus
                        Disini</small>
                </div>

                <div class="form-group">
                    <label for="">File PDF ( Disarankan Untuk Operasi Matematika Yang Kompleks )</label>
                    <input type="file" class="form-control-file" name="pdf_file" id="" accept=".pdf" placeholder=""
                        aria-describedby="fileHelpId">
                    <small id="fileHelpId" class="form-text text-muted">Gunakan File PDF jika operasi matematika terlalu
                        kompleks</small>
                </div>

                <div class="form-group">
                    <label for="">Isi Rumus</label>
                    <textarea class="form-control" style="height: 500px" name="content" id="editor" rows="5">{{ $formula->formulas }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>




    @push('js')
        <script>
            CKEDITOR.replace('editor', {
                filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
                filebrowserUploadMethod: 'form'
            });

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
