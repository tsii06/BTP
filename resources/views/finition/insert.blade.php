@extends('template.admin')

@section('content')
    @if($errors->has('nommodal') || $errors->has('pourcentagemodal'))
        <script>
            $(document).ready(function (){
                $('#exampleModal').modal('show');
            });
        </script>
    @endif


    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modifier finition</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editForm" action="{{ url('finition/modifier') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="idfinition" id="idfinition">
                        <div class="form-group">
                            <label for="nom_modal">Nom</label>
                            <input type="text" id="nom_modal" value="{{old('nommodal')}}" class="form-control @error('nommodal') is-invalid @enderror" id="nommodal" name="nommodal" placeholder="Inserer nom">
                            @error('nommodal')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="pourcentage_modal">Pourcentage</label>
                            <input type="text" id="pourcentage_modal" value="{{old('pourcentagemodal')}}" class="form-control @error('pourcentagemodal') is-invalid @enderror" id="pourcentagemodal" name="pourcentagemodal" placeholder="Inserer taux">
                            @error('pourcentagemodal')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <div class="card shadow">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>idfinition</th>
                    <th>Nom</th>
                    <th>Pourcentage</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($finitions as $row)
                    <tr>
                        <td>{{$row->idfinition}}</td>
                        <td>{{$row->nom}}</td>
                        <td>{{$row->pourcentage}}</td>
                        <td>
                            <button class="btn btn-primary"
                                    onclick="openModal('{{$row->idfinition}}', '{{$row->nom}}', '{{$row->pourcentage}}')"><i class="fe fe-edit-2"></i></button>
                            <button class="btn btn-danger"><a href="{{ url('finition/delete/'.$row->idfinition) }}"><i class="fe fe-trash-2"></i></a></button>
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
            <div class="d-flex justify-content-center">{{ $finitions->onEachSide(1)->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    <script>
        function openModal(idfinition, nom, pourcentage) {
            document.getElementById('idfinition').value = idfinition;
            document.getElementById('nom_modal').value = nom;
            document.getElementById('pourcentage_modal').value = pourcentage;
            $('#exampleModal').modal('show');
        }
    </script>

@endsection
