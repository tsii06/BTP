@extends('template.admin')

@section('content')
<div class="row">
    <div class="col-md-6 col-xl-3 mb-4">
        <div class="card shadow bg-primary text-white border-0">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col pr-0">
                        <p class="small text-muted mb-0">Montant total devis</p>
                        <span style="text-align:right" class="h3 mb-0 text-white">{{  number_format($total, 2, ',', ' ') }} MGA</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3 mb-4">
        <div class="card shadow bg-primary text-white border-0">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col pr-0">
                        <p class="small text-muted mb-0">Montant paiement effectué</p>
                        <span style="text-align:right" class="h3 mb-0 text-white">{{  number_format($paiement, 2, ',', ' ') }} MGA</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <h2>Histogramme</h2>
    <div class="row">

        <div class="col-md-8" id="chart"></div>
        <div class="col-md-4">
            <select class="form-control" id="selectYear">
                @foreach($annee as $row)
                    <option value="{{ $row->year }}">{{ $row->year }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        var chart;

        function updateChart(year) {
            var mois = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];
            $.ajax({
                url: '/admin/histogram/' + year,
                type: 'GET',
                success: function(data) {
                    var options = {
                        chart: {
                            type: 'bar'
                        },
                        series: [{
                            name: 'Total',
                            data: data.map(item => item.total)
                        }],
                        xaxis: {
                            categories: data.map(item => mois[item.month - 1])
                        }
                    };

                    if (chart) {
                        chart.updateSeries(options.series);
                    } else {
                        chart = new ApexCharts(document.querySelector("#chart"), options);
                        chart.render();
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        $(document).ready(function (){
            // Lorsque la valeur de la liste déroulante change, mettre à jour le graphique
            $('#selectYear').on('change', function() {
                var selectedYear = $(this).val();
                updateChart(selectedYear);
            });

            // Appel initial de la fonction updateChart avec l'année par défaut
            var defaultYear = $('#selectYear').val();
            updateChart(defaultYear);
        });
    </script>
@endsection
