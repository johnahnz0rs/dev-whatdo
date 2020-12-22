<?php

function validateUserCookie( $userId, $username, $passHash ) {
    global $db;
    $sqlUser = $db->prepare( "SELECT id, username, pass_hash FROM users WHERE id = :userId" );
    try {
        $sqlUser->execute([
            'userId' => $userId
        ]);
    } catch( PDOException $e ) {
        $output = $e->getMessage();
        echo $output;
        die();
    }
    $user = $sqlUser->rowCount() ? $sqlUser->fetch( PDO::FETCH_ASSOC ) : null;
    // if missing user cookies (3), then sign out
    if( strtolower( $username ) != strtolower( $user['username'] ) or $passHash != $user['pass_hash'] ) {
        setcookie( 'login_result', 'Please log in to continue.', time() + 15, '/' );
        $headerString = 'Location: ../signout';
        header( $headerString );
        die();
    }
    return $user;
}



function getArrayOfDateStringsForYesterdayTodayTomorrow( $date ) {
    $dateToday = $date ? strval( $date ) : strval( date( 'Y-m-d' ) );
    $dateYesterday = strval( date('Y-m-d', (strtotime('-1 day', strtotime( $dateToday )) )) );
    $dateTomorrow = strval( date('Y-m-d', ( strtotime('+1 day', strtotime( $dateToday )) )) );
    $dates = [
        'yesterday' => $dateYesterday,
        'today' => $dateToday,
        'tomorrow' => $dateTomorrow
    ];
    return $dates;
}



function getUsersDailyWins( $id ) {
    // get dailyWins - this is a list of wins that should appear daily
    global $db;
    $sqlDailyWins = $db->prepare( "SELECT id, win, note FROM daily_wins WHERE user_id = :userId" );
    try {
        $sqlDailyWins->execute([
            'userId' => $id
        ]);
    } catch( PDOException $e ) {
        $output = $e->getMessage();
        echo $output;
        die();
    }
    $dailyWins = $sqlDailyWins->rowCount() ? $sqlDailyWins->fetchAll( PDO::FETCH_ASSOC ) : null;
    return $dailyWins;
}



function getUsersTodayWins( $userId, $dateToday ) {
    global $db;
    $sqlTodayWins = $db->prepare( "SELECT id, user_id, win_id, win, note, date, stacked FROM wins WHERE user_id = :userId AND date = :dateToday" );
    try {
        $sqlTodayWins->execute([
            'userId' => $userId,
            'dateToday' => $dateToday
        ]);
    } catch( PDOException $e ) {
        $output = $e->getMessage();
        echo $output;
        die();
    }
    $todayWins = $sqlTodayWins->rowCount() ? $sqlTodayWins->fetchAll( PDO::FETCH_ASSOC ) : null;
    return $todayWins;
}



function getUsersDailyWinsIds( $dailyWins ) {
    $dailyWinsIds = [];
    foreach( $dailyWins as $win ) {
        $dailyWinsIds[] = $win['id'];
    }
    return $dailyWinsIds;
}



function getUsersTodayWinsIds( $todayWins ) {
    $todayWinsIds = [];
    foreach( $todayWins as $win ) {
        $todayWinsIds[] = $win['id'];
    }
    return $todayWinsIds;
}



function getUsersTodayWinsWinIds( $todayWins ) {
    $todayWinsWinIds = [];
    foreach( $todayWins as $win ) {
        $todayWinsWinIds[] = $win['win_id'];
    }
    return $todayWinsWinIds;
}



function getRemainingDailyWinsIdsToBeAddedToToday( $dailyWins, $todayWins ) {
    $dailyWinsIds = getUsersDailyWinsIds( $dailyWins );
    $todayWinsWinIds = getUsersTodayWinsWinIds( $todayWins );
    $remainingDailyWinsIdsToBeAddedToToday = [];
    foreach( $dailyWinsIds as $id ) {
        if( !in_array( $id, $todayWinsWinIds ) ) {
            $remainingDailyWinsIdsToBeAddedToToday[] = $id;
        }
    }
    return $remainingDailyWinsIdsToBeAddedToToday;
}



function getArrayOfWinsToAddToToday( $winIds, $wins ) {
    $arrayOfWinsToAddToToday = [];
    foreach( $wins as $win ) {
        if( in_array( $win['id'], $winIds ) ) {
            $arrayOfWins[] = $win;
        }
    }
    return $arrayOfWinsToAddToToday;
}

// above is keep
// above is keep
// above is keep
// above is keep
// above is keep
// above is keep
// above is keep
// above is keep
// above is keep
// above is keep
// above is keep
// above is keep

