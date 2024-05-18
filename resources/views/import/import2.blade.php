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

            <form action="{{ route('import.paiment') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input class="form-control" type="file" name="csv_file">
                <button class="btn btn-secondary" type="submit">Importer</button>
            </form>
        </div>
    </div>
@endsection
