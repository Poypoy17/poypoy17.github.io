<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Gestionnaire de mot de passe</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>

<body>

    <form action="" method="post">
        <input type="text" name="account" placeholder="Compte" autocomplete="off" required>
        <input type="password" name="key" placeholder="Clé" autocomplete="off" required>
        <input type="submit" name="submit" value="Générer le mot de passe">
    </form>

    <div id="password">
        Le mot de passe est :<br>
        <?php
        $errorcompte = 0;
        $errorcle = 0;
        if (isset($_POST['submit']) and isset($_POST['account']) and $_POST['account'] != '' and isset($_POST['key']) and $_POST['key'] != '') {
            //compte - 6 char
            if (strlen($_POST['account']) >= 6) {
                function cesar($char)
                {
                    $char = ord($char) - ord('a') + 1;
                    if ($char < 10)
                        return chr(ord('x') - $char);
                    else {
                        while ($char >= 10)
                            $char = floor($char / 10) + $char % 10;
                        return chr($char + ord('a') - 1);
                    }
                }
                $compte = str_split(strtolower(substr($_POST['account'], 0, 6)));
                foreach ($compte as $key => $value)
                    $compte[$key] = cesar($value);
                $compte = implode($compte);
            } else
                $errorcompte = 1;

            //perso - 6 char
            $cle = str_replace(' ', '_', ucwords(strtolower($_POST['key'])));
            $bash = substr(shell_exec('sh ./mdp.sh ' . $cle), 0, -1);
            if ($bash != '') {
                $element = explode(' ', $bash)[0];
                $listelement = array('#', '?', '!', '@', '$', '%', '^', '&', '*', '_', '.', ',', '-');
                switch ($element) {
                    case 'pyro':
                        $element = $listelement[4];
                        break;
                    case 'hydro':
                        $element = $listelement[3];
                        break;
                    case 'anemo':
                        $element = $listelement[12];
                        break;
                    case 'electro':
                        $element = $listelement[7];
                        break;
                    case 'dendro':
                        $element = $listelement[0];
                        break;
                    case 'cryo':
                        $element = $listelement[8];
                        break;
                    case 'geo':
                        $element = $listelement[9];
                        break;
                }
                $mdp = $compte . $element . substr($cle, 0, 1) . explode(' ', $bash)[1];
            } else
                $errorcle = 1;
            if ($errorcompte == 1 or $errorcle == 1)
                echo '<span id="error">Le compte ou la clé est incorrecte</span>';
            else
                echo '<span><button type="button" id="copy" onclick="copyToClipboard(\'copy\')">' . $mdp . '</button></span>';
        } else
            echo '';
        unset($_POST['submit']);
        unset($_POST['account']);
        unset($_POST['key']);
        ?>
    </div>
</body>

</html>