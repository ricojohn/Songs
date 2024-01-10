<?php
include ('conn.php');
if(isset($_POST['song_id'])){
    $id = $_POST['song_id'];
    
    $query = "SELECT * FROM songs WHERE id = '$id'";
    $run = $conn->query($query);
    $row = $run->fetch_assoc();

    $title = $row['title'];
    $artist = $row['artist'];
    $lyrics = $row['lyrics'];

    $result = array($title, $artist ,$lyrics);

    // Send in JSON encoded form
    $myJSON = json_encode($result);
    echo $myJSON;
}


if(isset($_POST['del_id'])){
    $id = $_POST['del_id'];
    
    $query2 = "DELETE FROM `songs` WHERE id = '$id'";
    
    if($conn->query($query2)){
        echo "Song Deleted!";
    }else{
        echo "Error in ".$conn->error."";
    }

}
?>