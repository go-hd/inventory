{{ $company->name }}から招待が届いています。<br>
<br>
以下のURLから本登録を完了させてください。<br>
<a href="{{ env('CORS_URL', ''). '/register/invited/'. $company->company_code. '?token='. $token. '&email='. $email }}">本登録を完了する</a>
