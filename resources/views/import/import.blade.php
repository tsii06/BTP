@extends('template.admin')

@section('content')
    <div class="card shadow col-md-6">
        <div class="card-body">
            @if(session('errors'))
                <div class="alert alert-danger" role="alert">
                    <ul>
                        @foreach(session('errors') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

                @if(session('succes'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('succes') }}
                    </div>
                @endif

            <form action="{{ route('import.csv') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group col-md-5">
                    <label for="inputEmail4">Maisons et travaux</label>
                    <input  name="file1" type="file" class="form-control" id="inputEmail4">
                </div>
                <div class="form-group col-md-5">
                    <label for="inputEmail4">Devis</label>
                    <input  name="file2" type="file" class="form-control" id="inputEmail4">
                </div>
                <button class="btn btn-secondary" type="submit">Importer</button>
            </form>
        </div>
    </div>
@endsection
