<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        @page{
            margin: 0cm 0cm;
        }
        body{
            margin: 1cm;
            font-family: Arial, Helvetica, sans-serif;
        }
        .watermaker{
            position: fixed;
            top: 13cm;
            left: 1cm;
            width: 19.5cm;
            z-index: -1000;
        }
        label{
            position: fixed;
            top: 15cm;
            left: 10cm;
        }
        .header-left{
            position: fixed;
            top: 1cm;
            left: 1.2cm;
            font-size: 14px;            
        }
        .fecha{
            position: fixed;
            top: 1.7%;
            width: 40%;
            left: 12cm;
            text-align: right;

        }
        .header-right{
            position: fixed;
            top:2cm;
            left: 12cm;
        }
        .header-right p {
            margin: 1px;
        }
        p{
            margin: 0.1cm;
        }
        .text-small{
            font-size: 12px;
        }

        table{
            width: 100%;
            position: fixed;
            top: 5cm;
            left: 1cm;
            border-collapse: collapse;
        }
        td{
            padding: 5px;
            font-size: 12px;
            border: 1px solid rgb(150, 150, 150);
        }
        .table-title{
            padding-top: 10px;
            padding-bottom: 10px;
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
        }
        .contenido{
            height: 8cm;
            vertical-align: top;
        }
        .col-15{
            width: 15cm;
        }

        .footer-left{
            text-align: left;
            font-size: 13px;
            position: fixed;
            top: 25.5cm;
            left: 1cm;
        }
        .footer-center{
            text-align: left;
            font-size: 13px;
            position: fixed;
            top: 25.5cm;
            left: 8cm;
        }
        .footer-left p{
            margin: 0px;
            width: 10cm;
        }
        .footer-center p {
            margin: 0px;
        }

        /* logo de redes sociales */
        .footer-right{
            width: 6.5cm;
            position: fixed;
            top: 25.5cm;
            left: 13.6cm;
            font-size: 14px;
        }
        .footer-right p{
            margin: 10px;
        }
        /* texto de redes sociales */
        .footer-right-text{
            width: 6.5cm;
            position: fixed;
            top: 25.6cm;
            left: 14.5cm;
            font-size: 13px;
        }
        .footer-right-text p{
            margin: 6px;
        }

        /* texto formato */
        p span{
            font-weight: bold;
        }
        a{
            text-decoration: none;
            color: black
        }
        .bold{
            font-weight: bold;
        }
        .imgTop {
            position: fixed;
            top: 7.9cm;
            left: 1.1cm;
            z-index: -1000;          
        }
        .txt1, .txt2, .txt3{
            position: fixed;
            top: 11.5cm;
            font-size: 12px;
            width: 6.4cm;
            text-align: center;
        }
        .txt1, .txt4{
            left: 1.1cm;
        }
        .txt2, .txt5{
            left: 7.6cm;
        }
        .txt3, .txt6{
            left: 14.1cm;
        }
        .txt4, .txt5, .txt6{
            position: fixed;
            top:16.6cm;
            font-size: 12px;
            width: 6.4cm;
            text-align: center;
        }


        .imgBottom{
            position: fixed;
            top: 13cm;
            left: 1.1cm;
            z-index: -1000;
        }
        .imgTop img, .imgBottom img {
            width: 6.38cm;
            height: 4.5cm;
        }
        .firma{
            position: fixed;
            top: 23.8cm;
            left: 14.5cm;
            text-align: center;
            font-size: 14px;
            color: rgb(120, 120, 120)
        }
        .clinica{
          
            position: fixed;
            top: 3.8cm;
            left: 0.9cm;    
            width: 6cm;        
        }
        .jotavepene{
            position: fixed;
            top: 4.3cm;
            left: 0.9cm;    
            width: 6cm;        
        }
    </style>
</head>
<body>
    <div class="header-left">
        <img class="imgg" src="{{ public_path($doctor->logo) }}" width="400" height="130">    
    </div>

    
    <div class="footer-right">
        @if($clinica->facebook!=null)<p><img src="{{ public_path('procedimientos/plantilla/pacheco/facebook.png') }}" height="14px" > </p>@endif
        @if($clinica->paginaWeb!=null)<p><img src="{{ public_path('procedimientos/plantilla/pacheco/web-icon.png') }}" height="14px"> </p>@endif
    </div>
    <div class="footer-right-text">
        @if($clinica->facebook!=null)<p>{{$clinica->facebook}}</p>@endif
         @if($clinica->paginaWeb!=null)<p>
            <a href="{{$clinica->paginaWeb}}" >{{$clinica->paginaWeb}}</a>
        </p>@endif
    </div>
    <div class="fecha">
        <p>FECHA: {{$fecha['fecha']}}</p>
    </div>
    <table>
        <tr>
            <td colspan="2" class="table-title">
                {{ $tipo->procedimiento_nombre }}
            </td>
        </tr>
        <tr>
            <td class="col-15">NOMBRE: {{ $pacientes->nombre.' '.$pacientes->apellidos }}</td>
            <td>EDAD: {{$edad}} años </td>
        </tr>
        <tr>
            <td colspan="2" height="280"></td>
        </tr>
        <tr>
            <td colspan="2" class="contenido">
                {!! $procedimiento->contenido !!}
            </td>
        </tr>
    </table>
    <div class="imgTop">
        @if(isset($img[0]))<img src="{{public_path()}}/capturas/{{$procedimiento->id.'/'.$img[0]}}" alt="">@endif
        @if(isset($img[1]))<img src="{{public_path()}}/capturas/{{$procedimiento->id.'/'.$img[1]}}" alt="">@endif
        @if(isset($img[2]))<img src="{{public_path()}}/capturas/{{$procedimiento->id.'/'.$img[2]}}" alt="">@endif
    </div>

    <div class="imgBottom">
        @if(isset($img[3]))<img src="{{public_path()}}/capturas/{{$procedimiento->id.'/'.$img[3]}}" alt="">@endif
        @if(isset($img[4]))<img src="{{public_path()}}/capturas/{{$procedimiento->id.'/'.$img[4]}}" alt="">@endif
        @if(isset($img[5]))<img src="{{public_path()}}/capturas/{{$procedimiento->id.'/'.$img[5]}}" alt="">@endif
    </div>

    @if(isset($des[0]))<div class="txt1">{{ $des[0] }}</div>@endif
    @if(isset($des[1]))<div class="txt2">{{ $des[1] }}</div>@endif
    @if(isset($des[2]))<div class="txt3">{{ $des[2] }}</div>@endif
    @if(isset($des[3]))<div class="txt4">{{ $des[3] }}</div>@endif
    @if(isset($des[4]))<div class="txt5">{{ $des[4] }}</div>@endif
    @if(isset($des[5]))<div class="txt6">{{ $des[5] }}</div>@endif

    <div class="firma">
        <p>____________________</p>
        <p>FIRMA Y SELLO</p>
    </div>
    <div class="footer-left">
        @if($clinica->direccion!=null)<p><span>Dirección:</span></p>
        <p>{{$clinica->direccion}}</p><br>@endif
        @if($clinica->telefonos!=null)<p><span>Tel. {{$clinica->telefonos}}</span></p>@endif
    </div>
</body>
</html>
