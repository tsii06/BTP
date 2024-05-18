@extends('template.admin')

@section('content')

    <div class="card shadow">
        <div class="card-body">
                <div class="card-body p-5">
                    <div class="row mb-5">
                        <div class="col-12 text-center mb-4">
                            <h2 class="mb-0 text-uppercase">{{$total->reference}}</h2>
                        </div>
                        <div class="col-md-7">
                            <p class="mb-4">
                                <strong>Type de maison :{{$total->maison}}</strong>
                            </p>
                            <p class="mb-4">
                                <strong>Type de finition :{{$total->finition}}</strong>
                            </p>
                        </div>
                        <div class="col-md-5">
                            <p class="mb-4">
                                <strong>Total :{{ number_format($total->total, 2, ',', ' ') }} MGA</strong>
                            </p>
                            <p class="mb-4">
                                <strong>Reste :{{ number_format($total->reste, 2, ',', ' ') }} MGA</strong>
                            </p>
                            <p class="mb-4">
                                <strong>Payer :{{ number_format($total->payer, 2, ',', ' ') }} MGA</strong>
                            </p>

                        </div>
                    </div> <!-- /.row -->
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Code</th>
                    <th>Designation</th>
                    <th>Unite</th>
                    <th style="text-align:right">Quantite</th>
                    <th style="text-align:right">Prix</th>
                    <th style="text-align:right">Total</th>
                </tr>
                </thead>
                <tbody>
                @foreach($devis as $row)
                    <tr>
                        <td>{{$row->code}}</td>
                        <td>{{$row->designation}}</td>
                        <td>{{$row->unite}}</td>
                        <td style="text-align:right">{{$row->quantite}}</td>
                        <td style="text-align:right">{{ number_format($row->prixunitaire, 2, ',', ' ') }} MGA</td>
                        <td style="text-align:right">{{ number_format($row->montant, 2, ',', ' ') }} MGA</td>
                    </tr>
                @endforeach
                </tbody>

            </table>
                </div>
        </div>

        </div>
    </div>
@endsection
