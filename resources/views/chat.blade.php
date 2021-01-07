@extends('profile')
@section('database')

{{-- css --}}
    <style>


    ul{
    margin:0;
    padding:0;
    }
    li{
    list-style: none;
    }

    .user-wrapper {
    border: 1px solid #dddddd;
    overflow-y:auto;
    }
    .user-wrapper{
    height: 450px;
    }
    .user {
    cursor: pointer;
    padding: 5px 0;
    position: relative;
    }
    .user:hover {
    background: #eeeeee;
    }
    .user:last-child{
    margin-bottom:0 ;
    }
    .pending{
    position: absolute;
    left: 13px;
    top: 9px;
    background: #b600ff;
    margin: 0;
    border-radius: 50%;
    width: 18px;
    height: 18px;
    line-height: 18px;
    padding-left:5px;
    color: #ffffff;
    font-size: 12px;
    }
    .media-left{
    margin:0 10px;
    }
    .media-left img {
    width:64px;
    border-radius: 64px;
    }
    .media-body p {
    margin: 6px ;
    }
    .messages .message{
    margin-bottom: 15px;

    }
    .messages .message:last-child {
    margin-bottom: 0;

    }
    .received, .sent{
        width: 45%;
    padding: 3px 10px;
    border-radius: 10px;
        word-wrap: break-word;
        overflow: hidden; /* palīdz saisīnāt */
        text-overflow: ellipsis; /* pievienojām ... */
    }
    .received{
    background: #ffffff;
    }
    .sent {
    background: #3bebff;
    float: right;
    text-align: right;
    }
    .message p{
    margin: 5px 0;
    }

    .active{
    background: #8492af;
    }
    input[type=text]{
    width: 70%;
    padding: 12px 20px;
    margin: 15px 0 0 0;
    display: inline-block;
    border-radius: 4px;
    box-sizing: border-box;
    outline:none;
    border: 1px solid #cccccc;
    }
    input[type=text]:focus{
    border: 1px solid #aaaaaa;


    }

    </style>

    <h3 align="center">Vēstules</h3>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="user-wrapper">
                <ul class="users">
{{-- attēlojās visi lietotāji, kurus atgriež funkcija 'selectUsers'--}}
                    @foreach($users as $row)
                    <li class="user" id="{{$row->id}}">
                        @foreach($message as $messages)

{{--     ja ziņa ir 'saņemtā', nevis 'nosūtītā' un tā vēl nav izlasīta, tad pie lietotāja parādās ikona 'new'--}}
                            @if( $row['id']!==$messages['to'] AND $messages['is_read']===0)
                        <span class="pending">new</span>
                            @endif

                        @endforeach
                        <div class="media">
                            <div class="media-left">
                                <i class="fa fa-user"></i>
                            </div>
                            <div class="media-body">
                                <p class="name">{{$row->name}}</p>
                                <p class="email">{{$row->email}}</p>
                            </div>
                        </div>
                    </li>

                    @endforeach
                </ul>
            </div>
        </div>

        <div class="col-md-8" id="messages">
{{--    te tiek atspoguļotas visas ziņas, kad uzspiež uz kādu lietotāju no saraksta --}}
        </div>

    </div>
</div>


@endsection

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

<script>
    var receiver_id ='';
    var my_id="{{Auth::id()}}";
    $(document).ready(function() {
        // ajax uzstādījums priekš csrf token
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': '{{ csrf_token() }}',
            },
        });


        $('.user').click(function () {
            $('.user').removeClass('active');
            $(this).addClass('active');
            receiver_id = $(this).attr('id');
            $.ajax({
                type: "get",
                url: "/message/" + receiver_id ,//pāreja uz 'routes'
                data: "",
                cache: false,
                success: function (data) {
                    $('#messages').html(data);

                }
            });
        }); //funckcija palidz attēlot bloku ar ziņām


        $(document).on('keyup', '.input-text input', function(e){
            var message=$(this).val();
            var status=$(this).attr('is_read');
            // pārbauda, vai ievadīšanas taustiņš (ENTER) ir nospiests un ziņojums nav tukšs, kā arī ir izvēlēts saņēmējs (lietotājs)
            if(e.keyCode === 13   && message !== ' ' && receiver_id !==''){

                $(this).val(''); //kad būs nospiests ENTER, teksta lodziņš būs tukšs
                var datastr="receiver_id=" + receiver_id + " & message=" + message + status;

                $.ajax({
                    type:"post",
                    url: 'message', //pāreja uz route
                    data: datastr,
                    cache:false,
                    success: function (data) {
                    },
                    error: function (jqXHR, status, err){

                    },
                    complete: function (){

                    }

                })

            }
            });

    });
</script>


