<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            /* border: 1px solid black; */
        }

        body {
            padding-bottom: 30px;
        }

        #header {
            width: 100vw;
            height: 400px;
            filter: brightness(60%);
            display: flex;
            z-index: 0;
        }
        #header img{
            width: 100%;
            height: 100%;
        }

        #page-title{
            width: auto; /* Need a specific value to work */
            position: absolute;
            margin-top: 125px;
            left: 0; 
            right: 0; 
            margin-left: auto; 
            margin-right: auto; 
            text-align: center;
            color: white;
            z-index: 1;
        }

        #page-title button{
            padding: 7px;
            margin-top: 10px;
        }

        #page-message {
            text-align: center;
            margin-top: 50px;
        }

        #card-container {
            display: flex;
            justify-content: start;
        }

        .card {
            width: 200px;
            margin: auto;
            margin-top: 30px;
            border: 1px solid rgba(0, 0, 0, 0.425);
            border-radius: 5px;
            box-shadow: 5px 5px lightgray;
            padding: 5px;
        }

        .card .chair-image {
            width: 200px;
        }
    </style>
</head>
<body>
    <div id="page-title">
        <h1>Check out our new chairs</h1>
        <button>Look at a chair</button>
    </div>
    <header id="header">
        <img src="{{asset('/images/mail/email-header-newchair.webp')}}" alt="">
    </header>

    <h2 id="page-message">We got a new chair</h2>

    <div id="card-container">
        <div class="card">
            <img src="{{asset('/storage/chairImages/'.$chair->image.'')}}" class="chair-image" alt="{{$chair->name}}">
            <div class="card-body">
                <h3>{{$chair->name}}</h3>
                <br>
                <h4>&euro; {{$chair->amount}}</h4>
            </div>
        </div>
    </div>
</body>
</html>