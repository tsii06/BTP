@extends('template.admin')

@section('content')


    @if($errors->has('codemodal') || $errors->has('designationmodal')  || $errors->has('unitemodal') || $errors->has('prixunitairemodal'))
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
                    <h5 class="modal-title" id="exampleModalLabel">Modifier travaux</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editForm" action="{{ url('travaux/modifier') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="idtravaux" id="idtravaux">
                        <div class="form-group">
                            <label for="code_modal">Code</label>
                            <input type="text" id="code_modal" value="{{old('codemodal')}}" class="form-control @error('codemodal') is-invalid @enderror" id="codemodal" name="codemodal" placeholder="Inserer code">
                            @error('codemodal')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="designation_modal">Designation</label>
                            <input type="text" id="designation_modal" value="{{old('designationmodal')}}" class="form-control @error('designationmodal') is-invalid @enderror" id="designationmodal" name="designationmodal" placeholder="Inserer Designation">
                            @error('designationmodal')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="unite_modal">Unite</label>
                            <input type="text" id="unite_modal" value="{{old('unitemodal')}}" class="form-control @error('unitemodal') is-invalid @enderror" id="unitemodal" name="unitemodal" placeholder="Ajouter uniter">
                            @error('unitemodal')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="prixunitaire_modal">Prix Unitaire</label>
                            <input type="text" id="prixunitaire_modal" value="{{old('prixunitairemodal')}}" class="form-control @error('prixunitairemodal') is-invalid @enderror" id="prixunitairemodal" name="prixunitairemodal" placeholder="Inserer prix unitaire">
                            @error('prixunitairemodal')
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
                    <th>idtravaux</th>
                    <th>Code</th>
                    <th>Designation</th>
                    <th>Unite</th>
                    <th>Prix Unitaire</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($travauxs as $row)
                    <tr>
                        <td>{{$row->idtravaux}}</td>
                        <td>{{$row->code}}</td>
                        <td>{{$row->designation}}</td>
                        <td>{{$row->unite}}</td>
                        <td>{{$row->prixunitaire}}</td>
                        <td>
                            <button class="btn btn-primary"
                                    onclick="openModal('{{$row->idtravaux}}', '{{$row->code}}', '{{$row->designation}}', '{{$row->unite}}', '{{$row->prixunitaire}}')"><i class="fe fe-edit-2"></i></button>
                            <button class="btn btn-danger"><a href="{{ url('travaux/delete/'.$row->idtravaux) }}"><i class="fe fe-trash-2"></i></a></button>
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
            <div class="d-flex justify-content-center">{{ $travauxs->onEachSide(1)->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    <script>
        function openModal(idtravaux, code, designation, unite, prixunitaire) {
            document.getElementById('idtravaux').value = idtravaux;
            document.getElementById('code_modal').value = code;
            document.getElementById('designation_modal').value = designation;
            document.getElementById('unite_modal').value = unite;
            document.getElementById('prixunitaire_modal').value = prixunitaire;
            $('#exampleModal').modal('show');
        }
    </script>

@endsection
