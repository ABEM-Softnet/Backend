<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome Mail</title>
</head>
<body>
    <h1>Welcome to Our Platform</h1>
    <p>Dear {{ $user->email }},</p>
    <p>Thank you for registering with us! Here are your login details:</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Password:</strong> {{ $password }}</p>
    <p><strong>Url:</strong> {{ $url }}</p>
    <p>You can log in to your account using the following link:</p>
    <a href="{{ url('/login') }}">Login to your account</a>
</body>

<script>
    useEffect(()=>{

    },[])
</script>
</html>
