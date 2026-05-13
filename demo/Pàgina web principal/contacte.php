<?php
declare(strict_types=1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/phpmailer/Exception.php';
require __DIR__ . '/phpmailer/PHPMailer.php';
require __DIR__ . '/phpmailer/SMTP.php';

$success = false;
$error = '';
$formData = [
    'nom' => '',
    'organitzacio' => '',
    'email' => '',
    'fase' => '',
    'missatge' => '',
];

function clean_input(string $value): string
{
    return trim($value);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData['nom'] = clean_input($_POST['nom'] ?? '');
    $formData['organitzacio'] = clean_input($_POST['organitzacio'] ?? '');
    $formData['email'] = clean_input($_POST['email'] ?? '');
    $formData['fase'] = clean_input($_POST['fase'] ?? '');
    $formData['missatge'] = clean_input($_POST['missatge'] ?? '');

    $honeypot = clean_input($_POST['website'] ?? '');

    if ($honeypot !== '') {
        $error = "No s'ha pogut enviar la sol·licitud.";
    } elseif ($formData['nom'] === '' || $formData['email'] === '') {
        $error = 'Omple com a mínim el nom i el correu electrònic.';
    } elseif (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
        $error = 'Introdueix un correu electrònic vàlid.';
    } else {
        $dataDir = __DIR__ . DIRECTORY_SEPARATOR . 'datos';
        $csvPath = $dataDir . DIRECTORY_SEPARATOR . 'solicitudes.csv';

        if (!is_dir($dataDir)) {
            @mkdir($dataDir, 0775, true);
        }

        $saved = false;

        if (is_dir($dataDir) && is_writable($dataDir)) {
            $isNewFile = !file_exists($csvPath);
            $fp = @fopen($csvPath, 'ab');

            if ($fp !== false) {
                if ($isNewFile) {
                    fputcsv($fp, ['fecha', 'nom', 'organitzacio', 'email', 'fase', 'missatge'], ';');
                }

                fputcsv($fp, [
                    date('Y-m-d H:i:s'),
                    $formData['nom'],
                    $formData['organitzacio'],
                    $formData['email'],
                    $formData['fase'],
                    $formData['missatge'],
                ], ';');

                fclose($fp);
                $saved = true;
            }
        }

        $mailSent = false;
        $smtpError = '';

        try {
            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->Host = 'xvtransit-cat.correoseguro.dinaserver.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'formulari@xvtransit.cat';
            $mail->Password = 'Formulari@4321';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;
            $mail->CharSet = 'UTF-8';

			// fer debug informacio 
            //$mail->SMTPDebug = 2;
            //$mail->Debugoutput = 'html';

            $mail->setFrom('formulari@xvtransit.cat', 'XVtransit Digital');
            $mail->addAddress('vimasp@inspalamos.cat', 'XVtransit Digital');
            $mail->addReplyTo($formData['email'], $formData['nom']);

            $mail->Subject = 'Nova sol·licitud de contacte · XVtransit Digital';
            $mail->Body =
                "Has rebut una nova sol·licitud des del formulari de contacte.\n\n" .
                "Nom: " . $formData['nom'] . "\n" .
                "Organització / Empresa: " . $formData['organitzacio'] . "\n" .
                "Correu electrònic: " . $formData['email'] . "\n" .
                "Fase de digitalització: " . $formData['fase'] . "\n\n" .
                "Missatge:\n" . $formData['missatge'] . "\n\n" .
                "Data: " . date('Y-m-d H:i:s');

            $mail->send();
            $mailSent = true;
        } catch (Exception $e) {
            $smtpError = $mail->ErrorInfo ?? $e->getMessage();
        }

        if ($saved && $mailSent) {
            $success = true;
            $formData = [
                'nom' => '',
                'organitzacio' => '',
                'email' => '',
                'fase' => '',
                'missatge' => '',
            ];
        } elseif ($saved && !$mailSent) {
            $error = "La sol·licitud s'ha guardat, però el correu no s'ha pogut enviar. Revisa la contrasenya SMTP o activa el debug temporalment.";
            if ($smtpError !== '') {
                $error .= ' Error SMTP: ' . $smtpError;
            }
        } elseif (!$saved && $mailSent) {
            $success = true;
            $formData = [
                'nom' => '',
                'organitzacio' => '',
                'email' => '',
                'fase' => '',
                'missatge' => '',
            ];
        } else {
            $error = "No s'ha pogut guardar ni enviar la sol·licitud.";
            if ($smtpError !== '') {
                $error .= ' Error SMTP: ' . $smtpError;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="utf-8">
    <title>Contacte · XVtransit Digital</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
    <div class="container d-flex align-items-center">
        <a class="navbar-brand d-flex align-items-center" href="index.html">
            <img src="logo-xvtransit.png" alt="Logo XVtransit" class="navbar-logo">
            <span>XVtransit · Contacte</span>
        </a>

        <div class="ms-auto d-flex align-items-center">
            <button id="themeToggle" type="button" class="btn btn-theme-icon btn-sm" aria-label="Canviar tema">🌙</button>
        </div>
    </div>
</nav>

<header class="section-dark py-5">
    <div class="container">
        <h1 class="h3 mb-2">Parlem del teu projecte de transport</h1>
        <p class="section-subtitle mb-0">
            Explica’ns com funciona la teva xarxa i en quina fase de digitalització esteu.
        </p>
    </div>
</header>

<section class="section-alt py-5">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-body">
                        <h2 class="h6 mb-3">Formulari de contacte</h2>

                        <?php if ($success): ?>
                            <div class="alert alert-success py-2 small" role="alert">
                                La teva sol·licitud s’ha enviat correctament.
                            </div>
                        <?php elseif ($error !== ''): ?>
                            <div class="alert alert-danger py-2 small" role="alert">
                                <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
                            </div>
                        <?php endif; ?>

                        <form action="" method="post" novalidate>
                            <input type="text" name="website" tabindex="-1" autocomplete="off" style="display:none">

                            <div class="mb-3">
                                <label for="nom" class="form-label small">Nom i cognoms</label>
                                <input
                                    type="text"
                                    id="nom"
                                    name="nom"
                                    class="form-control form-control-sm"
                                    required
                                    value="<?php echo htmlspecialchars($formData['nom'], ENT_QUOTES, 'UTF-8'); ?>"
                                >
                            </div>
                            <div class="mb-3">
                                <label for="organitzacio" class="form-label small">Organització / Empresa</label>
                                <input
                                    type="text"
                                    id="organitzacio"
                                    name="organitzacio"
                                    class="form-control form-control-sm"
                                    value="<?php echo htmlspecialchars($formData['organitzacio'], ENT_QUOTES, 'UTF-8'); ?>"
                                >
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label small">Correu electrònic</label>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    class="form-control form-control-sm"
                                    required
                                    value="<?php echo htmlspecialchars($formData['email'], ENT_QUOTES, 'UTF-8'); ?>"
                                >
                            </div>
                            <div class="mb-3">
                                <label for="fase" class="form-label small">Fase de digitalització actual</label>
                                <select id="fase" name="fase" class="form-select form-select-sm">
                                    <option value="">Selecciona una opció</option>
                                    <option <?php echo ($formData['fase'] === 'Encara sense web ni sistema digital') ? 'selected' : ''; ?>>Encara sense web ni sistema digital</option>
                                    <option <?php echo ($formData['fase'] === 'Tenim web bàsica, però poc integrada') ? 'selected' : ''; ?>>Tenim web bàsica, però poc integrada</option>
                                    <option <?php echo ($formData['fase'] === 'Tenim sistemes interns, però poc connectats amb flota') ? 'selected' : ''; ?>>Tenim sistemes interns, però poc connectats amb flota</option>
                                    <option <?php echo ($formData['fase'] === 'Tenim bastanta digitalització, volem millorar i afegir IA') ? 'selected' : ''; ?>>Tenim bastanta digitalització, volem millorar i afegir IA</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="missatge" class="form-label small">Explica’ns breument la teva situació</label>
                                <textarea id="missatge" name="missatge" rows="4" class="form-control form-control-sm"><?php echo htmlspecialchars($formData['missatge'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">
                                Enviar sol·licitud
                            </button>
                            <p class="small text-muted-custom mt-2 mb-0">
                                Les dades s’utilitzaran únicament per contactar amb tu i valorar una possible proposta.
                            </p>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card card-soft h-100">
                    <div class="card-body">
                        <h2 class="h6 mb-3">Què ens va bé saber abans?</h2>
                        <ul class="small text-muted-custom mb-3">
                            <li>Quin tipus de servei de transport gestioneu (urbà, interurbà, llançadora...).</li>
                            <li>Si ja teniu web, intranet o sistemes de venda implementats.</li>
                            <li>Si disposeu de GPS/IoT als vehicles o teniu previst afegir-ne.</li>
                            <li>Si us interessa sobretot millorar l’experiència del viatger, el control intern o ambdós.</li>
                        </ul>
                        <p class="small text-muted-custom mb-3">
                            Amb aquesta informació podem imaginar una proposta de fases d’XVtransit més realista per al vostre cas.
                        </p>

                        <div class="d-flex flex-wrap gap-2">
                            <a href="serveis.html" class="btn btn-accent btn-sm">
                                Revisar els serveis disponibles
                            </a>
                            <a href="metodologia.html" class="btn btn-outline-light btn-sm">
                                Veure la metodologia
                            </a>
                            <a href="index.html" class="btn btn-outline-light btn-sm">
                                Tornar a la pàgina principal
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<footer class="footer-bar py-3">
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
        <div>© 2025 XVtransit Digital · Nestor &amp; Xincheng</div>
        <div class="d-flex flex-wrap gap-3">
            <a href="avis-legal.html">Avís legal</a>
            <a href="privacitat.html">Política de privacitat</a>
            <a href="cookies.html">Política de cookies</a>
        </div>
    </div>
</footer>

<script>
(function () {
  const root = document.documentElement;
  const btn = document.getElementById('themeToggle');
  const saved = localStorage.getItem('xv-theme');

  if (saved === 'dark') {
    root.setAttribute('data-theme', 'dark');
    if (btn) btn.textContent = '🔆';
  } else {
    if (btn) btn.textContent = '🌙';
  }

  if (btn) {
    btn.addEventListener('click', function () {
      const isDark = root.getAttribute('data-theme') === 'dark';
      if (isDark) {
        root.removeAttribute('data-theme');
        localStorage.setItem('xv-theme', 'light');
        btn.textContent = '🌙';
      } else {
        root.setAttribute('data-theme', 'dark');
        localStorage.setItem('xv-theme', 'dark');
        btn.textContent = '🔆';
      }
    });
  }
})();
</script>

</body>
</html>
