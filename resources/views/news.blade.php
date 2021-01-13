@extends('profile')
@section('database')
    <style>

        /* Create two unequal columns that floats next to each other */
        /* Left column */
        .leftcolumn {
            float: left;
            width: 75%;
        }
        .leftcolumn h3{
            color:blue;
        }

        /* Right column */
        .rightcolumn {
            float: left;
            width: 25%;
            padding-left: 20px;
        }


        /* Add a card effect for articles */
        .card {
            background-color: #BDC4D4 ;
            padding: 20px;
            margin-top: 20px;

            border-radius: 25px;
            border: 2px solid #0d172e;
        }
        .card p {
            font-family: "Times New Roman";
        }

        .card2{
            padding-left: 20px;
        }


        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        .btn-link {
            border: none;
            outline: none;
            background: none;
            cursor: pointer;
            color: #0000EE;
            padding: 0;
            text-decoration: underline;
            font-family: inherit;
            font-size: inherit;
        }

        /* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other */


    </style>
    <body>
    <form class="task_form" method="POST" action="{{route('addNews')}}" novalidate>
        @csrf
    <div id="add_project" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header login-header">
                    <button type="button" class="close" data-dismiss="modal"></button>
                    <h4 class="modal-title">Pievienot jauno ziņu</h4>
                </div>
                <div class="modal-body">
                    <input type="text" placeholder="Tēma" name="news_name">
                    <input type="text" placeholder="Ziņas nosaukums" name="news_title">
                    <textarea type ="text" name="news_content" placeholder="Ziņas saturs"></textarea>
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

    @if (Session::has('message'))
        <div class="alert alert-success">{{ Session::get('message') }}</div>
    @endif

    <h3 align="center">Jaunumi</h3>

    @if(auth()->user()->is_admin == 0)
        <li class="hidden-xs"><a href="#" class="add-project" data-toggle="modal" data-target="#add_project">Pievienot jauno ziņu</a></li>
    @endif
        <?php $rowNumber = 1 ?>
    <div class="row">
        <div class="leftcolumn">
            @foreach($news as $row)
            <div class="card">
                <h3>Tēma: {{$row['news_name']}}</h3>
                <h6>Pievienots: {{$row['created_at']}}</h6>
                <h5>Nosaukums: {{$row['news_title']}}</h5>
                <p>{{$row['news_content']}}</p>
                @if((auth()->user()->is_admin == 0) or (auth()->user()->user_id == 4))
                <form method="POST" action="{{ route('news.delete', $row['id'])}}">
                    @csrf
                    <button type ="submit"  class="btn btn-danger">Izdzēst ziņu</button>
                </form>
                @endif
            </div>
                <?php $rowNumber++ ?>
            @endforeach
            <br>
                <br>
                @if($rowNumber==1)
                    Pašlaik nav ziņu.
                @endif
        </div>
        @if($rowNumber!==1)
        <div class="rightcolumn">
            <div class="card2">
                <h2>Aktuālās tēmas</h2>
                @foreach($allNewsTopic as $row)
                    <div class="row">
                        <form method="POST" action="{{route('showTopicById', $row['id'])}}">
                            @csrf
                            <button type ="submit"  class="btn-link">{{$row['news_name']}}</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
            @endif
    </div>
</div>
    </div>
@endsection
