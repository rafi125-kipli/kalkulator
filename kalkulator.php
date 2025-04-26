<?php
$hasil = "";

function hitung($ekspresi) {
    // Ganti ÷ dan × ke operator PHP
    $ekspresi = str_replace(['÷', '×'], ['/', '*'], $ekspresi);

    // Validasi hanya angka, operator dasar, titik, kurung, dan spasi
    if (preg_match('~^[0-9+\-*/().\s]+$~', $ekspresi)) {
        try {
            $hasil = @eval("return ($ekspresi);");
            if ($hasil === false) {
                return "Error";
            }
            return $hasil;
        } catch (Throwable $e) {
            return "Error";
        }
    } else {
        return "Input tidak valid";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ekspresi = $_POST["ekspresi"] ?? '';
    $hasil = hitung($ekspresi);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kalkulator Aman + Dark Mode</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: var(--background);
            color: var(--text);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            transition: 0.3s;
        }
        :root {
            --background: #e0eafc;
            --text: #000;
            --container-bg: #fff;
            --button-bg: #007bff;
            --button-text: #fff;
            --operator-bg: #ff9500;
            --clear-bg: #ff3b30;
            --equals-bg: #34c759;
            --screen-bg: #f7f7f7;
        }
        .dark {
            --background: #1e1e1e;
            --text: #fff;
            --container-bg: #2c2c2c;
            --button-bg: #3a3a3a;
            --button-text: #fff;
            --operator-bg: #ff9500;
            --clear-bg: #ff3b30;
            --equals-bg: #34c759;
            --screen-bg: #3a3a3a;
        }
        .kalkulator {
            background: var(--container-bg);
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
            width: 320px;
            text-align: center;
        }
        .layar {
            width: 100%;
            height: 60px;
            background: var(--screen-bg);
            border-radius: 10px;
            margin-bottom: 15px;
            text-align: right;
            font-size: 28px;
            padding: 10px;
            box-sizing: border-box;
            overflow-x: auto;
        }
        .buttons {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
        }
        button {
            padding: 20px;
            font-size: 20px;
            border: none;
            border-radius: 50%;
            background: var(--button-bg);
            color: var(--button-text);
            cursor: pointer;
            transition: 0.2s;
        }
        button.operator {
            background: var(--operator-bg);
        }
        button.clear {
            background: var(--clear-bg);
        }
        button.equals {
            background: var(--equals-bg);
            grid-column: span 2;
            border-radius: 30px;
        }
        button:hover {
            opacity: 0.9;
        }
        .mode-toggle {
            margin-bottom: 15px;
            cursor: pointer;
            background: none;
            border: 2px solid var(--button-bg);
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="kalkulator">
    <button class="mode-toggle" onclick="toggleMode()">🌙 / ☀️</button>

    <form method="post" id="formKalkulator">
        <input type="text" name="ekspresi" id="ekspresi" class="layar" value="<?= htmlspecialchars($_POST["ekspresi"] ?? '') ?>" readonly>

        <div class="buttons">
            <button type="button" class="clear" onclick="hapus()">AC</button>
            <button type="button" onclick="tambahInput('(')">(</button>
            <button type="button" onclick="tambahInput(')')">)</button>
            <button type="button" class="operator" onclick="tambahInput('÷')">÷</button>

            <button type="button" onclick="tambahInput('7')">7</button>
            <button type="button" onclick="tambahInput('8')">8</button>
            <button type="button" onclick="tambahInput('9')">9</button>
            <button type="button" class="operator" onclick="tambahInput('×')">×</button>

            <button type="button" onclick="tambahInput('4')">4</button>
            <button type="button" onclick="tambahInput('5')">5</button>
            <button type="button" onclick="tambahInput('6')">6</button>
            <button type="button" class="operator" onclick="tambahInput('-')">−</button>

            <button type="button" onclick="tambahInput('1')">1</button>
            <button type="button" onclick="tambahInput('2')">2</button>
            <button type="button" onclick="tambahInput('3')">3</button>
            <button type="button" class="operator" onclick="tambahInput('+')">+</button>

            <button type="button" onclick="tambahInput('0')">0</button>
            <button type="button" onclick="tambahInput('.')">.</button>
            <button type="submit" class="equals">=</button>
        </div>
    </form>

    <div class="layar" style="margin-top: 15px; background: var(--screen-bg);">
        <?= $hasil !== "" ? "Hasil: " . htmlspecialchars($hasil) : "" ?>
    </div>
</div>

<script>
    function tambahInput(value) {
        document.getElementById('ekspresi').value += value;
    }

    function hapus() {
        document.getElementById('ekspresi').value = '';
    }

    function toggleMode() {
        document.body.classList.toggle('dark');
    }
</script>

</body>
</html>
