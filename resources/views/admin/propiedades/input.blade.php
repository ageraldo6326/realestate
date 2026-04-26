<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>    
    <title>Document</title>
</head>
<body>
    Input:<input type="text" id="monto">
</body>

<script>
    $(document).ready(function ($) {
        // Aplicar máscara de dinero al campo de monto
        $('#monto').mask('000,000,000,000,000', { reverse: true });
    });
</script>

</html>