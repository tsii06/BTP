@extends('template.client')

@section('content')
    <div class="row">
        <div class="card shadow col-md-6">
            <div class="card-body">
                <form id="myForm" method="POST">
                    @csrf
                    <input hidden="" value="{{$id}}" name="id">
                    <div class="form-group">
                        <label for="montant">Montant</label>
                        <input type="text" class="form-control @error('montant') is-invalid @enderror" id="montant" name="montant" placeholder="Ajouter montant">
                        @error('montant')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="datepaiment">Date de paiement</label>
                        <input type="date" class="form-control @error('datepaiment') is-invalid @enderror" id="datepaiment" name="datepaiment" placeholder="">
                        @error('datepaiment')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <button id="submitForm" type="submit" class="btn btn-primary">Submit</button>

                    <div id="responseMessage"></div>
                </form>
            </div>
    </div>
    <hr>
    <div class="card shadow col-md-6">
        <div class="card-body">
            <div class="col-md-6">
                <div class="card shadow bg-primary text-white border-0">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col pr-0">
                                <p class="small text-muted mb-0">Payer</p>
                                <span style="text-align:right" class="h3 mb-0 text-white">{{  number_format($total->payer, 2, ',', ' ') }} MGA</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-4">
                <div class="card shadow bg-primary text-white border-0">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col pr-0">
                                <p class="small text-muted mb-0">Montant Total</p>
                                <span style="text-align:right" class="h3 mb-0 text-white">{{  number_format($total->total, 2, ',', ' ') }} MGA</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-4">
                <div class="card shadow bg-primary text-white border-0">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col pr-0">
                                <p class="small text-muted mb-0">Reste</p>
                                <span style="text-align:right" class="h3 mb-0 text-white">{{  number_format($total->reste, 2, ',', ' ') }} MGA</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
    <hr>

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>idpaiment</th>
                    <th>Montant</th>
                    <th>Date de paiment</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($paiments as $row)
                    <tr>
                        <td>{{$row->idpaiment}}</td>
                        <td>{{$row->montant}}</td>
                        <td>{{$row->datepaiment}}</td>
                    </tr>
                @endforeach
                </tbody>


            </table>
            <style>
                svg{
                    width: 40px;
                }
            </style>

        </div>
    </div>

    <!-- Conteneur pour afficher les messages de réponse -->


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#submitForm').on('click', function(event) {
                event.preventDefault(); // Empêcher le comportement par défaut du bouton

                // Récupérer les données du formulaire
                var formData = $('#myForm').serialize();

                // Envoyer les données via AJAX
                $.ajax({
                    url: '{{ route("client.insertpaiment") }}', // Remplacez 'your-route-name' par le nom de votre route
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        // Afficher le message de succès
                        $('#responseMessage').html('<div class="alert alert-success">'+ response.success +'</div>');
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    },
                    error: function(xhr, status, error) {
                        // Afficher le message d'erreur
                        $('#responseMessage').html('<div class="alert alert-danger">'+ xhr.responseText +'</div>');
                    }
                });
            });
        });
    </script>
@endsection


