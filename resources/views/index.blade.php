<style>

.message-wrapper{
border: 1px solid #dddddd;
overflow-y:auto;
    padding: 10px;
    height: 400px;
    background: #eeeeee;
    max-width: 1000px;

    /* additional */
    word-wrap: break-word;



}
.date{
    background: #eeeeee;
}

.active{
    background: #8492af;
}
</style>

<div class="message-wrapper">
        <ul class ="messages">
            @foreach($messages as $message)
            <li class="message clearfix">
                {{--                if message from id is equal to auth id then it is sent by logged in user--}}
                <div class="{{($message->from == Auth::id())  ? 'sent' : 'received'  }}">
                    <p>{{$message -> message}}</p>
                    <p class="date">{{date ('d M y, h:i a', strtotime($message->created_at))}}</p>

                </div>
            </li>
            @endforeach
        </ul>
</div>
<form id="idd">
    <div class="input-text">
        <input type="text" name="message" class="submit" placeholder="Ievadiet tekstu un nospiežat ENTER">
    </div>
</form>








