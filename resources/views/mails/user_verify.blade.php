{{ $userVerification->company->name }}から招待が届いています。<br>
<br>
以下のURLから本登録を完了させてください。<br>
<a href="{{ url('users/verify?token='. $userVerification->token. '&email='. $userVerification->email) }}">本登録を完了する</a>
