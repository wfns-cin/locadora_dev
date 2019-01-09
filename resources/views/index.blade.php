@extends('template')

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/select2-4.0.5/dist/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{ asset('vendor/DataTables/datatables.min.css')}} ">
    <link rel="stylesheet" href="{{ asset('vendor/icheck-1.0.2/skins/all.css')}} ">
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #367FA9;
            border-color: #000;
            padding: 1px 10px;
            color: #fff;
            cursor: pointer;
        }
        .select2 input {
            width: 100% !important;
        }
        a {
            cursor: pointer;
        }
    </style>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Consulta ao acervo</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <span><input type="radio" name="radioSearch" value="1" id="radioBS" checked > Busca simples</span>
                &nbsp;&nbsp;
                <span><input type="radio" name="radioSearch" value="2"  id="radioBA" > Busca avançada</span>
                <div class="pull-right" id="divSearch">
                    <a id="btnSearch" style="display: none;" chave="{{ route('advanced_search') }}" class="btn btn-primary"><i class="fas fa-search"></i> &nbsp; &nbsp; Busca avançada </a>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <table id="tb_filmes" class="table table-striped">
                    <thead>
                        <tr>
                            <th>TÍTULO</th>
                            <th>GÊNERO</th>
                            <th>ANO</th>
                            <th>TIPO</th>
                            <th>MÍDIAS DISPONÍVEIS</th>
                            <th>AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($movies as $m) 
                        <tr>
                            <td>{{$m->title}}</td>
                            <td>{{$m->available_genres}}</td>
                            <td>{{$m->year}}</td>
                            <td>{{$m->available_type}}</td>
                            <td>{{$m->available_medias}}</td>
                            <td>  
                                <div class="btn-group">
                                        <abbr title="Detalhes"><a chave="{{ route('movie_details', $m->id) }}" class="btn btn-default btn-sm btn-exibir" style="color:black"><i class="fas fa-list-alt"></i> &nbsp; &nbsp; Detalhes</a></abbr>
                                </div>
                            </td>
                        </tr>
                        @endforeach 
                    </tbody>
                </table>
                <br>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="dialog_exibir">
        <div class="modal-dialog" role="document" style="width:80vw;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                
                </div>
                <div class="modal-footer">
                    <a class="btn btn-danger" data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i> Fechar</a>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="{{ asset('vendor/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/icheck-1.0.2/icheck.js') }}"></script>
    <script src="{{ asset('vendor/select2-4.0.5/dist/js/select2.min.js')}}"></script>
    <script>
        function startDatatablesWithSearch(){
            var tabela = $('#tb_filmes').DataTable({
                "language": {
                    "decimal":        "",
                    "emptyTable":     "Não existem registros para exibir.",
                    "info":           "Exibindo _START_ até _END_ de _TOTAL_ registros",
                    "infoEmpty":      "Exibindo 0 até 0 de 0 registros",
                    "infoFiltered":   "(Fitrado a partir de _MAX_ registros)",
                    "infoPostFix":    "",
                    "thousands":      ",",
                    "lengthMenu":     "Exibir _MENU_ registros",
                    "loadingRecords": "Carregando...",
                    "processing":     "Processando...",
                    "search":         "Buscar:",
                    "zeroRecords":    "Nenhum regsitro encontrado",
                    "paginate": {
                        "first":      "Primeiro",
                        "last":       "Último",
                        "next":       "Próximo",
                        "previous":   "Anterior"
                    },  
                },
                "columnDefs": [ {
                    "targets": 5,
                    "orderable": false
                    } 
                ]
            });
            return tabela;
        }

        function startDatatablesWithoutSearch(){
            var tabela = $('#tb_filmes').DataTable({
                "searching": false,
                "language": {
                    "decimal":        "",
                    "emptyTable":     "Não existem registros para exibir.",
                    "info":           "Exibindo _START_ até _END_ de _TOTAL_ registros",
                    "infoEmpty":      "Exibindo 0 até 0 de 0 registros",
                    "infoFiltered":   "(Fitrado a partir de _MAX_ registros)",
                    "infoPostFix":    "",
                    "thousands":      ",",
                    "lengthMenu":     "Exibir _MENU_ registros",
                    "loadingRecords": "Carregando...",
                    "processing":     "Processando...",
                    "search":         "Buscar:",
                    "zeroRecords":    "Nenhum regsitro encontrado",
                    "paginate": {
                        "first":      "Primeiro",
                        "last":       "Último",
                        "next":       "Próximo",
                        "previous":   "Anterior"
                    },  
                },
                "columnDefs": [ {
                    "targets": 5,
                    "orderable": false
                    } 
                ]
            });
            return tabela;
        }

        $(document).ready( function () {
            
            var tabela = startDatatablesWithSearch();

            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue'
            });

            $("#tb_filmes").on("click", ".btn-exibir", function() {
                var key = $(this).attr('chave');
                $("#dialog_exibir .modal-body").load(key, function(){
                    $("#dialog_exibir").modal({show:true});
                });
            });

            $("#divSearch").on("click", "#btnSearch", function() {
                var key = $(this).attr('chave');
                $("#dialog_exibir .modal-body").load(key, function(){
                    $("#dialog_exibir").modal({show:true});
                });
            });

            $('#radioBS').on('ifChecked', function(event){
                tabela.destroy();
                tabela = startDatatablesWithSearch();
                $('#btnSearch').hide();
            });

            $('#radioBA').on('ifChecked', function(event){
                tabela.destroy();
                tabela = startDatatablesWithoutSearch();
                $('#btnSearch').show();
            });

        });

    </script>
@stop