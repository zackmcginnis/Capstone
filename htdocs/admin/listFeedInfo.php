<?php

    include("../mysql_constants.php");

    // Create connection
    $conn = new mysqli($servername, $username, $password);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    mysqli_query($conn, "USE carebank");

    $result = mysqli_query($conn, "SELECT username, FeedInfo.gatewayNodeUid, nodeUid, feedId, feedType
                                   FROM FeedInfo
                                   JOIN Users
                                     ON Users.gatewayNodeUid = FeedInfo.gatewayNodeUid
                                   ");
    
    $column = mysqli_fetch_fields($result);

    $columnNames = array();
    $rows = array();

    for($x = 0; $x < count($column); $x++) {
        $columnNames[$x] = $column[$x]->name;     
    }
    
    // Fetch one and one row
    while ($row=mysqli_fetch_row($result)) {
        $tempRow = array("$columnNames[0]"=>$row[0], 
                         "$columnNames[1]"=>$row[1], 
                         "$columnNames[2]"=>$row[2], 
                         "$columnNames[3]"=>$row[3],
                         "$columnNames[4]"=>$row[4]
                  );
        array_push($rows, $tempRow);
    }

    mysqli_close($conn);

    $result = array("columnNames"=>$columnNames, "rows"=>$rows); 
    $json = json_encode($result);
    print_r($json);
?>
