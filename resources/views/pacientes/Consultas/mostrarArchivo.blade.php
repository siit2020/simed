<!DOCTYPE html>
<html lang="en">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{$paciente->Apellidos}}</title>
    <style>
        #content img {
    max-width:100%;
    min-width:350px;
    max-height:700px;
};



    </style>
</head>
<body>
      <div id="marco" style="border:1px solid black; padding: 25px 50px 75px 100px;  height: 80%; width: 100%;">
            <div>
                    <table >
                            <thead>
                                <tr >
                                  <td>
                                        <h2>Descripción:</h2>
                                        {!!$adjunto->descripcion!!}
                                  </td>
                                </tr>
                            </thead>
                    </table>
                </div>
            <div>
                    <table >
                            <thead>
                                <tr id="content">

                                            <img src="{{$url}}" alt="" >
                                </tr>
                            </thead>
                    </table>
                </div>
      </div>

</body>
</html>
