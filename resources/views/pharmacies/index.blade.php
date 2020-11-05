<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
     @if($pharmacy !== null)
        {{ $pharmacy->name }}
        {{ $pharmacy->town }}
        {{ $pharmacy->municipality }}
        {{ $pharmacy->address }}
        {{ $pharmacy->add_address }}
        {{ $pharmacy->phone }}
        {{ $pharmacy->am }}
     @else
        No pharmacies available at the moment
     @endif
</body>
</html>
