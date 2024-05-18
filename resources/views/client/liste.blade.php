@extends('template.client')

@section('content')

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Maison</th>
                    <th>Finition</th>
                    <th>Prix</th>
                    <th>Etat Paiment</th>
                    <th>Etat Finition</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($devis as $row)
                    <tr>
                        <td>{{$row->maison}}</td>
                        <td>{{$row->finition}}</td>
                        <td>{{ number_format($row->total, 2, ',', ' ') }} MGA</td>
                        <td>
                        <span class="badge badge-pill {{ $row->statut_paiement == 'Payed' ? 'badge-success' : 'badge-danger' }}">
                            {{$row->statut_paiement}}
                        </span>
                        </td>
                        <td>
                        <span class="badge badge-pill {{ $row->etat == 'Finished' ? 'badge-success' : 'badge-danger' }}">
                            {{$row->etat}}
                        </span>
                        </td>
                        <td>
                            <button class="btn btn-outline-info"><a href="{{ url('client/export/'.$row->reference) }}">Exporter en pdf</a></button>
                        </td>
                        <td>
                            <button class="btn btn-secondary"><a href="{{ url('client/paiment/'.$row->reference) }}">Payer</a></button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <style>
                svg{
                    width: 40px;
                }
            </style>
            <div class="d-flex justify-content-center">{{ $devis->onEachSide(1)->links('pagination::bootstrap-4') }}
            </div>

        </div>
    </div>
@endsection
