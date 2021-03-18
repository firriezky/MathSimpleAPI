@extends('layout.backend.app',[
'title' => 'Blank Page',
'pageTitle' => $formula->name,
])
@section('content')

    @push('css')

    @endpush
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


    <div class="card border-left-primary shadow h-100 mt-3">
        <div class="card">
            <div class="card-header">
                {{ $formula->name }}
            </div>
            <div class="card-body p-4">
                {!! $formula->formulas !!}
            </div>
        </div>
    </div>

    
    <div class="card border-left-primary shadow h-100 mt-3">
        <div class="card">
            <div class="card-header">
                File PDF (Jika ada)
            </div>
            <div class="card-body p-4">
                <embed src= "{{url('/')."/uploads/pdf/".$formula->pdf_path}}" width= "100%" height= "1000px">
            </div>
        </div>
    </div>


    @push('js')

    @endpush




@stop
