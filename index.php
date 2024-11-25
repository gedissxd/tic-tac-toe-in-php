<?php
session_start();

if (isset($_GET['reset'])) {
    $_SESSION['grid'] = array_fill(0, 9, ""); 
    $_SESSION['winner'] = "";
    $_SESSION['gameOver'] = false;
    $_SESSION['draw'] = false;
    $_SESSION['currentPlayer'] = 'X'; 
    $_SESSION['xWins'];
    $_SESSION['oWins'];
    $_SESSION['winCombo'] = "";
    $_SESSION['drawCount'];
}

if (!isset($_SESSION['grid'])) {
    $_SESSION['grid'] = array_fill(0, 9, ""); 
    $_SESSION['winner'] = "";
    $_SESSION['gameOver'] = false;
    $_SESSION['draw'] = false;
    $_SESSION['currentPlayer'] = 'X'; 
    $_SESSION['xWins'] = 0;
    $_SESSION['oWins'] = 0;
    $_SESSION['winCombo'] = "";
    $_SESSION['drawCount'] =0;
}

if (isset($_GET['position'])) {
    $position = $_GET['position'];
    if ($_SESSION['grid'][$position] === '' && !$_SESSION['gameOver']) { 
        $_SESSION['grid'][$position] = $_SESSION['currentPlayer']; 
        win(); 
        $_SESSION['currentPlayer'] = $_SESSION['currentPlayer'] === 'X' ? 'O' : 'X'; 
    }
}

function win()
{
    $winningNumbers = [[0, 1, 2], [3, 4, 5], [6, 7, 8], [0, 3, 6], [1, 4, 7], [2, 5, 8], [0, 4, 8], [2, 4, 6]];

    foreach ($winningNumbers as $win) 
    {
        $letter1 = $_SESSION['grid'][$win[0]];
        $letter2 = $_SESSION['grid'][$win[1]];
        $letter3 = $_SESSION['grid'][$win[2]];

        if ($letter1 != "" && $letter1 == $letter2 && $letter1 == $letter3) 
        {
            $_SESSION['winner'] = $letter1;
            $_SESSION['gameOver'] = true;
            $_SESSION['winCombo'] = $win;
            $letter1 === 'X' ? $_SESSION['xWins']++ : $_SESSION['oWins']++;
            return;
        }
    }
}

if (!in_array("", $_SESSION['grid']) && !$_SESSION['winner'] && !$_SESSION['gameOver']) {
    $_SESSION['draw'] = true;
    $_SESSION['gameOver'] = true;
    $_SESSION['drawCount']++;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#1E1B18] h-screen flex flex-col justify-center items-center">
    <form method="get">
    <h1 class="text-white font-bold"><?php  echo 'win count for x:' . $_SESSION['xWins']; ?></h1>
    <h1 class="text-white font-bold"><?php  echo 'win count for o:' . $_SESSION['oWins']; ?></h1>
    <h1 class="text-white font-bold"><?php  echo 'draw count:' . $_SESSION['drawCount']; ?></h1>
    <h1 class="text-white font-bold"><?php  echo 'current player:' . $_SESSION['currentPlayer']; ?></h1>
    <h1 class="text-white text-4xl text-center font-bold mb-4"><?php if ($_SESSION['winner']) echo $_SESSION['winner'].' wins!';?></h1>
    <h1 class="text-white text-4xl text-center font-bold mb-4"><?php if ($_SESSION['draw']) echo 'its a draw!';?></h1>
        <div class="grid grid-cols-3 gap-4 place-content-center mb-4">
            <?php for ($i = 0; $i <= 8; $i++): ?>

                <button name="position" value="<?= $i ?>" 
                    class="bg-[#C2B280] hover:bg-[#C2B280]/50 h-[150px] w-[150px] rounded gap-3 text-center  font-bold text-3xl <?= isset($_SESSION['winCombo']) && ($_SESSION['winCombo'][0] === $i || $_SESSION['winCombo'][1] === $i || $_SESSION['winCombo'][2] === $i) ? 'text-[#772E25]' : 'text-[#FFFAFF]' ?>"
                    <?= $_SESSION['gameOver'] || $_SESSION['grid'][$i] !== '' ? 'disabled' : '' ?>>
                    <?= $_SESSION['grid'][$i] ?>
                </button>
            <?php endfor; ?>
        </div>
    </form>

    <form method="get">
        <button name="reset" class="bg-[#D8315B] h-[50px] w-[100px] rounded hover:bg-[#D8315B]/50 mt-10 text-white font-bold">Reset</button>
    </form>
</body>
</html>