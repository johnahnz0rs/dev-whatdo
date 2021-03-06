<?php
session_start();

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

// get user's reminders
function getUsersReminders( $userId ) {
    global $db;
    $sqlReminders = $db->prepare( "SELECT id, title, note FROM reminders WHERE user_id = :userId and active = 1" );
    try {
        $sqlReminders->execute( [
            'userId' => $userId
        ] );
    } catch( PDOException $e ) {
        $output = $e->getMessage();
        echo $output;
        die();
    }
    $reminders = $sqlReminders->rowCount() ? $sqlReminders->fetchAll( PDO::FETCH_ASSOC ) : null;
    return $reminders;
}

// get ALL of user's reminders (active and inactive)
function getAllUsersReminders( $userId ) {
    global $db;
    $sqlAllReminders = $db->prepare( "SELECT id, title, note, active FROM reminders WHERE user_id = :userId" );
    try {
        $sqlAllReminders->execute( [
            'userId' => $userId
        ] );
    } catch( PDOException $e ) {
        $output = $e->getMessage();
        echo $output;
        die();
    }
    $allReminders = $sqlAllReminders->rowCount() ? $sqlAllReminders->fetchAll( PDO::FETCH_ASSOC ) : null;
    return $allReminders;
}

// get user's program (what should all be done everyday)
function getUsersProgram( $userId ) {
    global $db;
    $sqlProgram = $db->prepare( "SELECT id, title, note FROM programs WHERE user_id = :userId and active = 1" );
    try {
        $sqlProgram->execute([
            'userId' => $userId
        ]);
    } catch( PDOException $e ) {
        $output = $e->getMessage();
        echo $output;
        die();
    }
    $program = $sqlProgram->rowCount() ? $sqlProgram->fetchAll( PDO::FETCH_ASSOC ) : null;
    return $program;
}

// get ALL of a user's programs (including the inactive ones)
function getAllUsersProgram( $userId ) {
    global $db;
    $sqlAllPrograms = $db->prepare( "SELECT id, title, note, active FROM programs WHERE user_id = :userId" );
    try {
        $sqlAllPrograms->execute( [
            'userId' => $userId
        ] );
    } catch( PDOException $e ) {
        $output = $e->getMessage();
        echo $output;
        die();
    }
    $allPrograms = $sqlAllPrograms->rowCount() ? $sqlAllPrograms->fetchAll( PDO::FETCH_ASSOC ) : null;
    // echo '<div style"margin-top: 300px;">lol wtf<br>';
    // var_dump($allProgram);
    // die();
    return $allPrograms;
}

// get user's wins for $date
function getUsersWins( $userId, $date ) {
    global $db;
    $sqlWins = $db->prepare( "SELECT id, program_id, whatdo_id, title, note, user_note, stacked FROM wins WHERE user_id = :userId and date = :date" );
    try {
        $sqlWins->execute( [
            'userId' => $userId,
            'date' => $date
        ] );
    } catch( PDOException $e) {
        $output = $e->getMessage();
        echo $output;
        die();
    }
    $wins = $sqlWins->rowCount() ? $sqlWins->fetchAll( PDO::FETCH_ASSOC ) : null;
    return $wins;
}

// if any program items are missing from wins (date = today), then add them.
function addWinsAsNecessary( $userId, $program, $wins, $date ) {
    global $db;
    // program_id's of user's existing wins
    $programIdsWins = [];
    foreach( $wins as $win ) {
        if( $win['program_id'] ) {
            $programIdsWins[] = $win['program_id'];
        }
    }
    // program items that need to be added to user's wins (for today)
    $winsToAdd = [];
    foreach( $program as $prog ) {
        if( !in_array( $prog['id'], $programIdsWins ) ) {
            $winsToAdd[] = $prog;
        }
    }
    // add wins as necessary
    if( count( $winsToAdd ) ) {
        $stringWinsToAdd = "INSERT INTO wins (user_id, date, program_id, title, note, stacked) VALUES ";
        foreach( $winsToAdd as $win ) {
            $stringWinsToAdd .= '(' . $userId . ', \'' . $date . '\', ' . $win['id'] . ', \'' . addslashes( $win['title'] ) . '\', \'' . addslashes($win['note'] ) . '\', 0), ';
        }
        $stringWinsToAdd = rtrim( $stringWinsToAdd, ', ' );
        $sqlWinsToAdd = $db->prepare( $stringWinsToAdd );
        try {
            $sqlWinsToAdd->execute();
        } catch( PDOException $e ) {
            $output = $e->getMessage();
            echo $output;
            die();
        }
        // $headerString = 'Location: /dash/?date=' . $date;
        // header( $headerString );
    }
    return count( $winsToAdd ) ? true : false;
}

// get user's vices (array of vices)
function getUsersVices( $userId ) {
    // get user's vices
    global $db;
    $sqlVices = $db->prepare( "SELECT id, title, note FROM vices WHERE user_id = :userId AND active = 1" );
    try {
        $sqlVices->execute( [
            'userId' => $userId
        ] );
    } catch( PDOException $e) {
        $output = $e->getMessage();
        echo $output;
        die();
    }
    $vices = $sqlVices->rowCount() ? $sqlVices->fetchAll( PDO::FETCH_ASSOC ) : null;
    return $vices;
}

function getAllUsersVices( $userId ) {
    global $db;
    // echo 'starting getAllUsersVices';
    $sqlAllVices = $db-> prepare( "SELECT id, title, note, active, created_at FROM vices WHERE user_id = :userId" );
    try {
        $sqlAllVices->execute( [
            'userId' => $userId
        ] );
    } catch( PDOException $e ) {
        $output = $e->getMessages();
        echo $output;
        die();
    }
    $allVices = $sqlAllVices->rowCount() ? $sqlAllVices->fetchAll( PDO::FETCH_ASSOC ) : null;
    return $allVices;
}

// get user's viceCounts for $date (array of viceCounts)
function getUsersViceCounts( $userId, $date ) {
    global $db;
    $sqlViceCounts = $db->prepare( 'SELECT id, vice_id, title, note, user_note, count FROM vice_counts WHERE user_id = :userId AND date = :date' );
    try {
        $sqlViceCounts->execute( [
            'userId' => $userId,
            'date' => $date
        ] );
    } catch( PDOException $e) {
        $output = $e->getMessage();
        echo $output;
        die();
    }
    $viceCounts = $sqlViceCounts->rowCount() ? $sqlViceCounts->fetchAll( PDO::FETCH_ASSOC ) : null;
    return $viceCounts;
}

// if vices are missing from today's viceCounts, then add them (adds vices and returns true/false)
function addViceCountsAsNecessary( $userId, $vices, $viceCounts, $date ) {
    global $db;
    // vice_id's of user's existing viceCounts
    $viceIdsViceCounts = [];
    foreach( $viceCounts as $count ) {
        if( $count['vice_id'] ) {
            $viceIdsViceCounts[] = $count['vice_id'];
        }
    }
    // viceCounts that need to be added to user's viceCounts (for today)
    $vicesToAdd = [];
    foreach( $vices as $vice ) {
        if( !in_array( $vice['id'], $viceIdsViceCounts ) ) {
            $vicesToAdd[] = $vice;
        }
    }
    // add vices as necessary
    if( count( $vicesToAdd ) ) {
        $stringVicesToAdd = "INSERT INTO vice_counts (user_id, date, vice_id, title, note, count) VALUES ";
        foreach( $vicesToAdd as $vice ) {
            $stringVicesToAdd .= '(' . $userId . ', \'' . $date . '\', ' . $vice['id'] . ', \'' . addslashes( $vice['title'] ) . '\', \'' . addslashes( $vice['note'] ) . '\', 0), ';
        }
        $stringVicesToAdd = rtrim( $stringVicesToAdd, ', ' );
        $sqlVicesToAdd = $db->prepare( $stringVicesToAdd );
        try {
            $sqlVicesToAdd->execute();
        } catch( PDOException $e ) {
            $output = $e->getMessage();
            echo $output;
            die();
        }
        // $headerString = 'Location: /dash/?date=' . $date;
        // header( $headerString );
    }

    return count( $vicesToAdd ) ? true : false;
}

// get user's whatdos (array)
function getUsersWhatDos( $userId ) {
    global $db;
    $sqlWhatDos = $db->prepare( 'SELECT id, title, note, created_at FROM whatdos WHERE user_id = :userId and active = 1' );
    try {
        $sqlWhatDos->execute( [
            'userId' => $userId
        ] );
    } catch( PDOException $e ) {
        $output = $e->getMessage();
        echo $output;
        die();
    }
    $whatDos = $sqlWhatDos->rowCount() ? $sqlWhatDos->fetchAll( PDO::FETCH_ASSOC ) : null;
    return $whatDos;
}

// get all of a user's whatdos (including inactive whatdos)
function getAllUsersWhatDos( $userId ) {
    global $db;
    $sqlAllWhatDos = $db->prepare( "SELECT id, title, note, active, created_at FROM whatdos WHERE user_id = :userId" );
    try {
        $sqlAllWhatDos->execute( [
            'userId' => $userId
        ] );
    } catch( PDOException $e ) {
        $output = $e->getMessage();
        echo $output;
        die();
    }
    $allWhatDos = $sqlAllWhatDos->rowCount() ? $sqlAllWhatDos->fetchAll( PDO::FETCH_ASSOC ) : null;
    return $allWhatDos;
}

// get an array of id's of whatdos that are marked as STACKED wins
function getUsersWhatDones( $wins, $whatDos ) {
    $whatDosIds = [];
    foreach( $whatDos as $whatDo ) {
        $whatDosIds[] = $whatDo['id'];
    }
    $whatDones = [];
    foreach( $wins as $win ) {
        if( $win['whatdo_id'] != 0 ) {
            $whatDones[] = $win['whatdo_id'];
        }
    }
    return count( $whatDones ) ? $whatDones : null;
}
