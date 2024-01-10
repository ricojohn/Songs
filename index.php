<?php
include ('conn.php');
if(isset($_POST['addsong'])){
    $artist = $conn -> real_escape_string($_POST['artist']);
    $title = $conn -> real_escape_string($_POST['title']);
    $lyrics = $conn -> real_escape_string($_POST['lyrics']);

    $query = "INSERT INTO `songs`(`title`, `artist`, `lyrics`) VALUES ('$title','$artist',' $lyrics ')";
    
    if($conn->query($query)){
        echo '<script>alert("Song Added")</script>';  
        header("Refresh: 1;url=index.php");
    }
    
}


if(isset($_POST['editsong'])){
    $song_id = $_POST['song_id'];
    $artist = $conn -> real_escape_string($_POST['artist']);
    $title = $conn -> real_escape_string($_POST['title']);
    $lyrics = $conn -> real_escape_string($_POST['lyrics']);

    $edit_query = "UPDATE `songs` SET`title`='$title',`artist`='$artist',`lyrics`='$lyrics' WHERE id = '$song_id'";
    
    if($conn->query($edit_query)){
        echo '<script>alert("Song Edited")</script>';  
        header("Refresh: 1;url=index.php");
    }
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Songs</title>
    <!-- Adding Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            padding-top: 50px; /* To account for the fixed navbar */
        }

        h1 {
            text-align: center;
            color: #333;
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 80%;
            max-width: 100%;
            margin: 0 auto;
        }

        li {
            border-bottom: 1px solid #ddd;
            padding: 12px;
        }

        li:last-child {
            border-bottom: none;
        }

        span {
            font-weight: bold;
            color: #333;
        }

        .lyrics {
            font-style: italic;
            color: #555;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#">Song List</a>
    </nav>

        <h1 class="mt-3">List of Songs</h1>
        <div class="text-center mb-3"> 
            <button type="button" class="btn btn-success text-center newsong" data-toggle="modal" data-target=".bd-example-modal-lg">Add Songs</button>
        </div>
        <div class="row gy-3 justify-content-center">
        <?php
        $get_songs = "SELECT * FROM songs";
        $get_songs_run = $conn ->query($get_songs);
        if($get_songs_run-> num_rows > 0){
            while( $get_songs_row = $get_songs_run->fetch_assoc()){
                echo '
                <div class="col-12 m-2">
                    <ul class="list-group">
                        <li class="list-group-item">
                        <button type="button" class="btn btn-warning " id="'.$get_songs_row['id'].'" data-toggle="modal" data-target=".bd-edit-modal-lg" onclick="modal(this)">Edit Songs</button> 
                        <button type="button" class="btn btn-danger " id="'.$get_songs_row['id'].'" onclick="del(this)">Delete Songs</button> 
                        <br>
                        <span>Artist:</span> '.$get_songs_row['artist'].' <br>
                        <span>Title:</span> '.$get_songs_row['title'].' <br>
                        <span>Created: </span> '.$get_songs_row['stamp'].'
                        
                        <p class="lyrics mt-3">
                        <span>Lyrics:</span><br>
                        '.$get_songs_row['lyrics'].'
                        </p>
                    </li>
                    </ul>
                </div>';
            }
        }else{
            echo '
                <div class="col-12 m-2">
                    <ul class="list-group text-center">
                        <li class="list-group-item">
                        <h3>No Songs Uploaded!</h3>
                        </li>
                    </ul>
                </div>';
        }
        ?>
        </div>

    <!-- Modal -->
    <!-- Large modal -->
    <form action="" method="post">
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Song</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <div class="row">
                                <div class="col-6 col-12-sm">
                                    <div class="form-group">
                                        <label for="artist" class="col-form-label">Artist</label>
                                        <input type="text" class="form-control" name="artist" placeholder="Artist Name">
                                    </div>
                                </div>
                                <div class="col-6 col-12-sm">
                                    <div class="form-group">
                                        <label for="title" class="col-form-label">Title</label>
                                        <input type="text" class="form-control" name="title" placeholder="Song Title">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="lyrics" class="col-form-label">Song Lyrics</label>
                                    <textarea name="lyrics" cols="30" rows="10" class="form-control"></textarea>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="addsong">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form action="" method="post">
        <input type="hidden" id="song_id" name="song_id">
        <div class="modal fade bd-edit-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Song</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <div class="row">
                                <div class="col-6 col-12-sm">
                                    <div class="form-group">
                                        <label for="artist" class="col-form-label">Artist</label>
                                        <input type="text" class="form-control" id="artist" name="artist" placeholder="Artist Name">
                                    </div>
                                </div>
                                <div class="col-6 col-12-sm">
                                    <div class="form-group">
                                        <label for="title" class="col-form-label">Title</label>
                                        <input type="text" class="form-control" id="title" name="title" placeholder="Song Title">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="lyrics" class="col-form-label">Song Lyrics</label>
                                    <textarea name="lyrics" id="lyrics" cols="30" rows="10" class="form-control"></textarea>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="editsong">Save Edit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>



    <!-- Adding Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        function modal(data){
            var song_id = data.id;

            $.ajax({
                type: "POST",
                url: 'query.php',
                data: {song_id:song_id},
                success: function(data){
                    console.log(data);
                    var myObj = JSON.parse(data);
                    $('#title').val(myObj[0]);
                    $('#artist').val(myObj[1]);
                    $('#lyrics').val(myObj[2]);
                    $('#song_id').val(song_id);
                }
            });
        }

        function del(data){
            let text = confirm('Are you sure to delete this comment?');
            if (text) {
                var del_id = data.id;
                $.ajax({
                    type: "POST",
                    url: 'query.php',
                    data: {del_id:del_id},
                    success: function(data){
                        alert(data);
                        location.reload(true);
                    }
                });
            } else {

            }
        }



        $(".newsong").on("click", function(){
            $('#title').val('');
            $('#artist').val('');
            $('#lyrics').val('');
        });
    </script>
</body>
</html>
