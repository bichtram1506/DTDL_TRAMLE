<!DOCTYPE html>
<html>
<head>
    <title>Chatbox</title>
    <style>
        /* CSS styles for the chatbox */
    </style>
</head>
<body>
    <div id="chatbox">
        <ul id="message-list">
            @foreach($messages as $message)
                <li>
                    <span class="sender">{{ $message->sender->name }}:</span>
                    <span class="content">{{ $message->message }}</span>
                </li>
            @endforeach
        </ul>
        <form id="message-form" action="{{ route('message.store') }}" method="POST">
            @csrf
            <input type="text" name="message" placeholder="Message">
            <button type="submit">Send</button>
        </form>
    </div>

</body>
</html>
