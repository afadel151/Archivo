<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div>
        <form action="{{ route('file.upload')}}" enctype="multipart/form-data" method="POST">
            @csrf
            <input type="file" name="file">
            <button type="submit">Submit</button>
        </form>
        @if(auth()->user()->hasRole('super_admin'))
            I am a super admin
        @elseif(auth()->user()->hasRole('admin')))
            i am an admin
        @else
            i am a student
        @endif
    </div>
</body>
</html>