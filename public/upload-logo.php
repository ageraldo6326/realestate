<?php
// Script simple para cargar nuevo logo
// Acceso: http://127.0.0.1:8000/upload-logo.php

$error = null;
$message = null;
$filename = null;
$command = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['logo'])) {
    $file = $_FILES['logo'];
    
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $error = "Error en la carga del archivo";
    } else {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        
        if (!in_array($mime, ['image/png', 'image/jpeg'])) {
            $error = "Solo PNG o JPG. Tipo: $mime";
        } elseif ($file['size'] > 5 * 1024 * 1024) {
            $error = "Archivo > 5MB";
        } else {
            $ext = ($mime === 'image/png') ? 'png' : 'jpg';
            $filename = 'logo.' . $ext;
            $uploadDir = __DIR__ . '/assets/inmobiliaria/';
            
            if (!is_dir($uploadDir)) {
                @mkdir($uploadDir, 0755, true);
            }
            
            $destination = $uploadDir . $filename;
            
            if (move_uploaded_file($file['tmp_name'], $destination)) {
                $message = "✓ Guardado como: inmobiliaria/$filename";
                $command = "php artisan tinker --execute=\"App\\\\Models\\\\Inmobiliaria::first()->update(['logo' => 'inmobiliaria/$filename']);\"";
            } else {
                $error = "Error al guardar archivo";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cargar Logo - Portal Inmobiliario</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Inter', sans-serif;
            background: linear-gradient(135deg, #1C1C2E 0%, #2D2D3F 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 1rem;
        }
        .container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .3);
            padding: 2.5rem;
            max-width: 500px;
            width: 100%;
        }
        .header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .header h1 {
            font-size: 1.6rem;
            color: #1C1C2E;
            margin-bottom: .5rem;
        }
        .header p {
            color: #6B7280;
            font-size: .95rem;
        }
        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: .9rem;
            border-left: 4px solid;
        }
        .alert.error {
            background: #FEE2E2;
            color: #991B1B;
            border-left-color: #DC2626;
        }
        .alert.success {
            background: #DBEAFE;
            color: #1E40AF;
            border-left-color: #0284C7;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        label {
            display: block;
            font-weight: 600;
            margin-bottom: .75rem;
            color: #1C1C2E;
            font-size: .95rem;
        }
        input[type="file"] {
            width: 100%;
            padding: .75rem;
            border: 2px dashed #C9A84C;
            border-radius: 8px;
            background: #F9F8F6;
            cursor: pointer;
            font-size: .9rem;
            transition: all .25s ease;
        }
        input[type="file"]:hover {
            background: rgba(201, 168, 76, .1);
            border-color: #b8943e;
        }
        button {
            background: #C9A84C;
            color: #1C1C2E;
            border: none;
            padding: .85rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            font-size: 1rem;
            transition: all .25s ease;
        }
        button:hover {
            background: #b8943e;
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(201, 168, 76, .3);
        }
        .info-box {
            background: #F3F4F6;
            border-left: 4px solid #C9A84C;
            padding: 1rem;
            border-radius: 6px;
            font-size: .85rem;
            color: #4B5563;
            margin-top: 1.5rem;
            line-height: 1.6;
        }
        .info-box strong {
            color: #1C1C2E;
            display: block;
            margin-bottom: .5rem;
        }
        .command {
            background: #1C1C2E;
            color: #C9A84C;
            padding: .75rem;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            font-size: .8rem;
            margin-top: .75rem;
            word-break: break-all;
            border: 1px solid #C9A84C;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏠 Nuevo Logo</h1>
            <p>Reemplaza tu logo con la versión mejorada</p>
        </div>
        
        <?php if ($error): ?>
            <div class="alert error">
                <strong>❌ Error:</strong> <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <?php if ($message): ?>
            <div class="alert success">
                <strong>✓ ¡Listo!</strong> <?php echo htmlspecialchars($message); ?><br><br>
                <strong>Próximo paso:</strong> Ejecuta en terminal:
                <div class="command"><?php echo htmlspecialchars($command); ?></div>
            </div>
        <?php endif; ?>
        
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="logo">Selecciona tu nuevo logo:</label>
                <input type="file" id="logo" name="logo" accept=".png,.jpg,.jpeg" required>
            </div>
            <button type="submit">Cargar Logo</button>
        </form>
        
        <div class="info-box">
            <strong>📌 Después de cargar:</strong><br>
            1️⃣ Se guardará en <code>assets/inmobiliaria/</code><br>
            2️⃣ Copia el comando que aparece arriba<br>
            3️⃣ Abre terminal y pégalo<br>
            4️⃣ ¡Listo! Tu logo estará actualizado
        </div>
    </div>
</body>
</html>
