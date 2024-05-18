@extends('template.client')

@section('content')
    <form action="{{ url('client/insert') }}" method="POST">
        @csrf
        <h6 class="mb-3">Type de Maison</h6>
    <div class="row my-4 pb-4">
        @foreach($maisons as $row)
        <div class="col-md-3">
            <div class="card shadow text-center mb-4">
                <div class="card-body file">
                    <div class="circle circle-lg bg-light my-4">
                        <span class="fe fe-archive fe-24 text-secondary"></span>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 fname">
                    <h2>{{ number_format($row->prix, 2, ',', ' ') }} MGA</h2>
                </div>
                <div class="card-footer bg-transparent border-0 fname">
                    <strong>{{ $row->nom }}</strong>
                </div>
                <div class="card-footer bg-transparent border-0 fname">
                    <input value="{{$row->idmaison}}" type="radio" name="idmaison" class="form-control">
                </div>
                <p>
                    {{ $row->description }}
                </p>
            </div>
        </div>
        @endforeach

    </div>
    <h6 class="mb-3">Type de finition</h6>
    <div class="card-deck my-4">
        @foreach($finition as $row)
        <div class="card mb-4">
            <div class="card-body text-center my-4">
                <a href="#">
                    <h3 class="h5 mt-4 mb-0">{{ $row->nom }}</h3>
                </a>
                <span class="h1 mb-0">{{$row->pourcentage}}</span>
                <input value="{{$row->idfinition}}" type="radio" name="idfinition" class="form-control">
            </div>
        </div>
        @endforeach

    </div>

    <div class="form-group col-md-5">
        <label for="inputEmail4">Date debut du travail</label>
        <input  name="datedebut" type="date" class="form-control @error('datedebut') is-invalid @enderror" id="inputEmail4">
        @error('datedebut')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

        <div class="form-group col-md-5">
            <label for="inputEmail4">Lieu</label>
            <input  name="lieu" type="text" class="form-control @error('lieu') is-invalid @enderror" id="inputEmail4">
            @error('lieu')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Ajouter devise</button>
    </form>

@endsection
