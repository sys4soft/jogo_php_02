<?php

defined('CONTROL') or die('Acesso negado');

// go to the next game
if (isset($_GET['next'])) {

    // increment the game number
    $_SESSION['game_number']++;

    // reset the game board
    $_SESSION['game_board'] = [
        ['', '', ''],
        ['', '', ''],
        ['', '', '']
    ];

    // reset the game turn
    $_SESSION['game_turn'] = 1;

    // alternate the active player
    $_SESSION['active_player'] = $_SESSION['active_player'] == 1 ? 2 : 1;

    // go to the game
    header('Location: index.php?route=game');
}

// when the player clicks on a cell 
if (isset($_GET['player']) && isset($_GET['x']) && isset($_GET['y'])) {

    $player = $_GET['player'];
    $x = $_GET['x'];
    $y = $_GET['y'];
    $winner = null;

    // check if there is already a symbol in the cell
    if (empty($_SESSION['game_board'][$x][$y])) {

        // defines the symbol of the player
        $_SESSION['game_board'][$x][$y] = $player == 1 ? 'X' : 'O';

        // check if the player won
        $status = check_game_status($player);

        if (!empty($status)) {

            // who is the winner? is there a draw?
            $winner = $player == 1 ? $_SESSION['player_1_name'] : $_SESSION['player_2_name'];
            if ($winner != 'draw') {
                $_SESSION[$player == 1 ? 'player_1_score' : 'player_2_score']++;
            }
        }

        // check for a draw
        if ($_SESSION['game_turn'] == 9 && empty($winner)) {
            $winner = 'Empate!';
        }

        if (empty($winner)) {

            // change the active player
            $_SESSION['active_player'] = $player == 1 ? 2 : 1;

            // increment the turn
            $_SESSION['game_turn']++;
        }
    }
}

function check_game_status($player)
{
    /* 

    check if the player won

        1       2       3       4       5       6       7       8
    | x x x | - - - | - - - | x - - | - x - | - - x | x - - | - - x |  
    | - - - | x x x | - - - | x - - | - x - | - - x | - x - | - x - |
    | - - - | - - - | x x x | x - - | - x - | - - x | - - x | x - - |

    */

    $mark = $player == 1 ? 'X' : 'O';
    $game_board = $_SESSION['game_board'];
    $status = null;

    // 1
    if ($game_board[0][0] == $mark && $game_board[0][1] == $mark && $game_board[0][2] == $mark) {
        $status = 'win1';
    }

    // 2
    if ($game_board[1][0] == $mark && $game_board[1][1] == $mark && $game_board[1][2] == $mark) {
        $status = 'win2';
    }

    // 3
    if ($game_board[2][0] == $mark && $game_board[2][1] == $mark && $game_board[2][2] == $mark) {
        $status = 'win3';
    }

    // 4
    if ($game_board[0][0] == $mark && $game_board[1][0] == $mark && $game_board[2][0] == $mark) {
        $status = 'win4';
    }

    // 5
    if ($game_board[0][1] == $mark && $game_board[1][1] == $mark && $game_board[2][1] == $mark) {
        $status = 'win5';
    }

    // 6
    if ($game_board[0][2] == $mark && $game_board[1][2] == $mark && $game_board[2][2] == $mark) {
        $status = 'win6';
    }

    // 7
    if ($game_board[0][0] == $mark && $game_board[1][1] == $mark && $game_board[2][2] == $mark) {
        $status = 'win7';
    }

    // 8
    if ($game_board[0][2] == $mark && $game_board[1][1] == $mark && $game_board[2][0] == $mark) {
        $status = 'win8';
    }

    return $status;
}

?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col">
            <h3 class="text-center">Tic Tac Toe</h3>
            <hr>
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="text-center <?= $_SESSION['active_player'] == 1 ? 'text-warning' : '' ?>"><?php echo $_SESSION['player_1_name']; ?></h3>
                    <h3 class="text-center"><?php echo $_SESSION['player_1_score']; ?></h3>
                </div>
                <div class="col">
                    <h3 class="text-center"><span class="text-info">JOGO</span> <?php echo $_SESSION['game_number']; ?></h3>
                </div>
                <div class="col text-end">
                    <h3 class="text-center <?= $_SESSION['active_player'] == 2 ? 'text-warning' : '' ?>"><?php echo $_SESSION['player_2_name']; ?></h3>
                    <h3 class="text-center"><?php echo $_SESSION['player_2_score']; ?></h3>
                </div>
            </div>
            <hr>

            <?php for ($row = 0; $row <= 2; $row++) : ?>
                <div class="d-flex justify-content-center">
                    <?php for ($col = 0; $col <= 2; $col++) : ?>
                        <a href="index.php?route=game&player=<?= $_SESSION['active_player'] ?>&x=<?= $row ?>&y=<?= $col ?>">
                            <div class="board-cell text-center">
                                <?php if ($_SESSION['game_board'][$row][$col] == 'X') : ?>
                                    <img src="assets/images/times.png">
                                <?php elseif ($_SESSION['game_board'][$row][$col] == 'O') : ?>
                                    <img src="assets/images/circle.png">
                                <?php endif; ?>
                            </div>
                        </a>
                    <?php endfor; ?>
                </div>
            <?php endfor; ?>

            <?php if (!empty($winner)) : ?>
                <div class="text-center mt-3">
                    <h3 class="text-center text-warning"><?= $winner ?></h3>
                    <div class="text-center mt-3">
                        <a href="index.php?route=game&next=1" class="btn btn-success w-25">PRÓXIMO JOGO</a>
                    </div>
                </div>
            <?php endif; ?>

            <div class="text-center mt-3">
                <a href="index.php?route=start" class="btn btn-dark w-25">REINICIAR</a>
            </div>

        </div>
    </div>
</div>