<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
      body { font-family:verdana; background-color: #ffd670 }
      * { margin: 0; padding: 0; box-sizing: border-box; }
      header { background-color: #41708E; height: 50px;  padding: 5px;}
      header img { height: 100%; margin-left: 20px;}
      .container { margin: 15px; }
      .title { text-align: center; margin-bottom: 25px; }
      .subtitle { margin-bottom: 25px; }
      ul { list-style: none; margin-bottom: 25px; margin-left: 20px }
      li { margin-bottom: 10px;  }
    </style>
    <title>Messaggio</title>
  </head>
  <body>

    <div>
      <header>
        <img src="{{asset('/images/logo.png')}}" alt="logo-image">
      </header>
      <div class="container">
        <h1 class="title"> Nuovo messaggio ricevuto da {{ $data['name'] }} </h1>
        <div class="subtitle"> Email: {{ $data['email'] }} </div>
        <div> Corpo del messaggio: {{ $data['message'] }} </div>
      </div>
    </div>

  </body>
</html>