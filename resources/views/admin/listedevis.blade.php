@extends('template.admin')

@section('content')
{{--    <style>--}}
{{--        .lokoina{--}}
{{--            background-color: green;--}}
{{--        }--}}
{{--        .tsy{--}}
{{--            background-color: red;--}}
{{--        }--}}
{{--    </style>--}}

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Maison</th>
                    <th>Finition</th>
                    <th>Prix</th>
                    <th>Pourcentage Payé</th>
                    <th>Etat Paiment</th>
                    <th>Etat Finition</th>
                    <th>Reste</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($devis as $row)
                    <tr class="{{ $row->pourcentage_paiement >50 ? 'bg-success' : 'bg-danger' }}">
                        <td>{{$row->maison}}</td>
                        <td>{{$row->finition}}</td>
                        <td>{{ number_format($row->total, 2, ',', ' ') }} MGA</td>
{{--                        <td>{{ number_format($row->pourcentage_paiement, 2, ',', ' ') }}%</td>--}}
                        <td>
                        <span class="badge badge-pill {{ $row->pourcentage_paiement >50 ? 'badge-success' : 'badge-danger' }}">
                            {{ number_format($row->pourcentage_paiement, 2, ',', ' ') }}%
                        </span>
                        </td>
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
                        <td>{{ number_format($row->reste, 2, ',', ' ') }} MGA</td>
                        <td>
                            <button class="btn btn-danger"><a href="{{ url('admin/details/'.$row->reference) }}">Details</a></button>
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
