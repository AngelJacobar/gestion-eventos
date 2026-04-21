<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Constancia</title>

<style>
    @page{
        margin: 20px 25px;
    }

    body{
        font-family: DejaVu Sans, sans-serif;
        margin:0;
        padding:0;
        color:#0b1f5c;
    }

    .pagina{
        width:100%;
        text-align:center;
    }

    .contenido{
        width:92%;
        margin:0 auto;
        text-align:center;
    }

    .logo{
        margin-bottom:12px;
    }

    .logo img{
        width:75px;
        height:auto;
    }

    .linea{
        border-top:1px solid #0b1f5c;
        width:78%;
        margin:0 auto 18px auto;
    }

    .titulo{
        font-size:34px;
        font-weight:bold;
        letter-spacing:4px;
        margin-bottom:16px;
    }

    .sublinea{
        border-top:1px solid #0b1f5c;
        width:38%;
        margin:0 auto 28px auto;
    }

    .texto{
        font-size:22px;
        color:#222;
        margin:16px 0;
    }

    .nombre{
        font-size:28px;
        font-weight:bold;
        text-transform:uppercase;
        margin:26px 0;
    }

    .evento{
        font-size:24px;
        font-weight:bold;
        margin:24px 0;
    }

    .fecha{
        font-size:22px;
        color:#222;
        margin-top:24px;
    }

    .lugar-label{
        font-size:22px;
        color:#222;
        margin-top:24px;
    }

    .lugar{
        font-size:28px;
        font-weight:bold;
        margin-top:16px;
    }

    .footer-linea{
        border-top:1px solid #0b1f5c;
        width:38%;
        margin:40px auto 18px auto;
    }

    .footer{
        font-size:24px;
        font-weight:bold;
    }
</style>
</head>

<body>

<div class="pagina">
<div class="contenido">

    <div class="logo">
        <img src="{{ public_path('img/UNAMLogo.png') }}">
    </div>

    <div class="linea"></div>

    <div class="titulo">
        CONSTANCIA
    </div>

    <div class="sublinea"></div>

    <div class="texto">
        Se otorga la presente a:
    </div>

    <div class="nombre">
        {{ $nombreUsuario }}
    </div>

    <div class="texto">
        Por su participación en el evento:
    </div>

    <div class="evento">
        {{ $nombreEvento }}
    </div>

    <div class="fecha">
        Realizado del {{ $fechaInicio }} al {{ $fechaFin }}
    </div>

    <div class="lugar-label">
        Que se llevó a cabo en:
    </div>

    <div class="lugar">
        {{ $lugar }}
    </div>

    <div class="footer-linea"></div>

    <div class="footer">
        Sistema de Eventos
    </div>

</div>
</div>

</body>
</html>