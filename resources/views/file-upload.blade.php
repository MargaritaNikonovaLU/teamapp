@extends('profile')
@section('database')
{{--    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">--}}

    <style>
        .container {
            max-width: 500px;
        }
        dl, ol, ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }

    </style>

<!-- Modal -->
{{--Modele, kas atvēras, kad uzspiež uz pogas (kā atsevišks logs)--}}
<form class="task_form" method="POST" action="{{route('fileUpload')}}" novalidate   enctype="multipart/form-data">
    @csrf
    <div id="add_project" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header login-header">
                    <button type="button" class="close" data-dismiss="modal"></button>
                    <h4 class="modal-title">Pievienot jauno dokumentu</h4>
                </div>
                <div class="modal-body">
                    <input type="text" placeholder="Dokumenta nosaukums" name="name">
                    <input type="text" placeholder="Tēma" name="subject">
                    <div class="custom-file">
                        <input type="file" name="file" class="custom-file-input" id="chooseFile">
                    </div>
                    <textarea type ="text" name="description" placeholder="Pamatojums"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="cancel" data-dismiss="modal">Aizvērt</button>
                        <button type="submit" class="add-project" >Saglabāt</button>
                </div>
            </div>


        </div>
    </div>
</form>

<div class="row">
    <div class="col-md-12">


        {{--    Šīs palīdz attēlot paziņojumu, kad fails tiks ielādēts      --}}
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <strong>{{ $message }}</strong>
            </div>
        @endif

        {{--    Šīs palīdz attēlot paziņojumu, kad fails tiks ielādēts      --}}
        @if ($message = Session::get('message'))
            <div class="alert alert-danger">
                <strong>{{ $message }}</strong>
            </div>
        @endif

{{-- Ja būs kļūdas, tad šīs palīdz attēlot kļūdas paziņojumus--}}
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

<h3 class="text-center mb-5" align="center">Dokumenti</h3>

{{--        Poga "Pievienot dokumentu" ir pieejama tikai administratoram--}}
@if(auth()->user()->is_admin == 0)
    <li class="hidden-xs"><a href="#" class="add-project" data-toggle="modal" data-target="#add_project">Pievienot dokumentus</a></li>
@endif
        <br>

{{--      Tabula, kur no datu bāzes tiek ņemti ieraksti (faili)  --}}
                <table class="table table-hover">
                    <tr>
                        <th>Nr. </th>
                        <th>Nosaukums</th>
                        <th>Pievienots</th>
                        <th>Pievienotājs</th>
                        <th>Pamatojums</th>
                        <th>Tema</th>
                        <th></th>
                    </tr>
{{--                    rowNumber nepieciešams priekš tā, lai saskaitīt cik ir rindas ar dokumentiem un parādīt to tabulā--}}
                    <?php $rowNumber = 1 ?>
                    @foreach($file as $row)
                        <tr>
                            <td>{{$rowNumber}}</td>
                            @if( empty($row['name']))
                            <td>{{$row['file_path']}}</td>
                            @else
{{--               Vēl tiks koriģēts, bet pašlaik ideja ir iekļaut funkciju, kas paredz: uzspiežot uz failu, tas tiks lejpielādēts      --}}
                                <td><a href="/storage/uploads/{{$row['name']}}"  download>{{$row['name']}} </td>
                            @endif
                            <td> {{$row['created_at']}}</td>
                            <td>{{$row['user_id']}}</td>
                            <td>{{$row['description']}}</td>
                            <td>{{$row['subject']}}</td>
                            <th>
{{--  Poga, lai varētu izdzēst kādu konkrētu failu --}}
                                <form method="POST" class="delete_file" action="{{ route('file.delete', $row['id'])}}">
                                    @csrf
                                    <input type="hidden" name="delete" value="IZDZĒST" />
                                    <button type ="submit" class="btn btn-danger">
                                        Izdzēst
                                    </button>

                                </form>
                            </th>
                        </tr>
                        <?php $rowNumber++ ?>
                    @endforeach
                </table>
{{--    ja nav dokumentu, tad parāda ierakstu: Pašlaik nav dokumentu--}}
        @if($rowNumber==1)
            Pašlaik nav dokumentu.
        @endif

</div>
    </div>

@endsection
