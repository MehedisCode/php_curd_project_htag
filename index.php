<!-- Important Note:  -->
<!-- You have to create a database name : curd_notes_h -->
<!-- and table name : curd_notes_h  -->

<?php
$alert_message = false;
$update_message = false;
$delete_message = false;
// INSERT INTO `curd_notes_h` (`No`, `Note TItle`, `Note Description`, `Time Stamp`) VALUES (NULL, 'Buy book', 'Buy book for me.', current_timestamp());
// Connecting to database 
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'curd_notes_h';
$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
  echo 'Sorry we failed to connect';
}

if(isset($_GET['delete'])){
  $serialno = $_GET['delete'];
  // echo $serialno;

  $sql = "DELETE FROM `curd_notes_h` WHERE `curd_notes_h`.`No` = $serialno;";
  $result = mysqli_query($conn, $sql);
  $delete_message = true;
  
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['serialEdit'])) {
    $serialEdit = $_POST['serialEdit'];
    $title = $_POST['titleEdit'];
    $description = $_POST['desEdit'];
    $sql = "UPDATE `curd_notes_h` SET `Note Title` = '$title', `Note Description` = '$description' WHERE `curd_notes_h`.`No` = $serialEdit;";
    $result = mysqli_query($conn, $sql);
    $update_message = true;

  } else {
    
    $title = $_POST['title'];
    $description = $_POST['description'];
    $sql = "INSERT INTO `curd_notes_h` (`Note TItle`, `Note Description`) VALUES ('$title', '$description')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
      // echo "Form submit successfully";
      $alert_message = true;
    } else {
      echo "Form dose not submited";
    }
  }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous" />
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">

  <title>Hello, world!</title>
</head>
<body>
  <!-- Navbar Start  -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">PHP CURD</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact us</a>
        </li>
      </ul>

      <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" />
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
          Search
        </button>
      </form>
    </div>
  </nav>
  <?php
  if ($alert_message) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success!</strong> Your note has been inserted successfully.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
  }
  ?>
  <?php
  if ($update_message) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success!</strong> Your note has been Updated successfully.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
  }
  ?>
  <?php
  if ($delete_message) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Success!</strong> Your note has been deleted successfully.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
  }
  ?>
  <!-- End navbar  -->
  <!-- Form start  -->
  <div class="container my-4">
    <h2 class="my-3">Add a Note </h2>
    <form action="/curd_notes_h/index.php" method="POST">
      <div class="form-group">
        <label for="title">Note Title</label>
        <input type="text" class="form-control" name="title" id="title" aria-describedby="emailHelp" />
        <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
      </div>
      <div class="form-group">
        <label for="desc">Note Description</label>
        <textarea class="form-control" name="description" id="desc" rows="3"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
  <!-- END FORM  -->
  <!-- Note display start  -->
  <div class="container my-5">

    <table class="table" id="myTable">
      <thead class="thead-dark">
        <tr>
          <th scope="col">Serial</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT * FROM `curd_notes_h`";
        $result = mysqli_query($conn, $sql);
        $i = 1;
        while ($row = mysqli_fetch_assoc($result)) {
          // echo $row['No'] . ". Title is " . $row['Note Title']. ". Description is ". $row['Note Description'];
          $html = '<tr>
      <th scope="row">' . $i . '</th>
      <td>' . $row["Note Title"] . '</td>
      <td>' . $row["Note Description"] . '</td>
      <td>' . ' <a href="del" type="button" id=" ' . $row['No'] . '" class="edit btn btn-sm btn-primary" data-toggle="modal" data-target="#exampleModal" >Edit</a> <a type="button" id="G' . $row['No'] . '" class="delete btn btn-sm btn-primary">Delete</a>
      
      <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> 
      </div>
      <form action="/curd_notes_h/index.php" method="POST">
      <div class="modal-body">

        <input type="hidden" name="serialEdit" class="serialEdit" id="serialEdit">
          <div class="form-group">
            <label for="title">Note Title</label>
            <input type="text" class="form-control" name="titleEdit" id="titleEdit" aria-describedby="emailHelp" /> 
          </div>
          <div class="form-group">
            <label for="desc">Note Description</label>
            <textarea class="form-control" name="desEdit" id="desEdit" rows="3"></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        
      </form>
    </div>
  </div>
</div>
      
      
      ' . '</td>
      </tr>';

          echo $html;
          $i++;
        }

        ?>

      </tbody>
    </table>

  </div>
  <hr>


  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
    integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
  </script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
    integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous">
  </script>
  <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#myTable').DataTable();
    });

    let edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach(element => {
      element.addEventListener('click', (e) => {
        // console.log(e.target.parentNode.parentNode)
        let tr = e.target.parentNode.parentNode;
        let tit = tr.getElementsByTagName('td')[0].innerText;
        let des = tr.getElementsByTagName('td')[1].innerText;
        console.log(tit, des);
        titleEdit = document.getElementById('titleEdit');
        desEdit = document.getElementById('desEdit');
        titleEdit.value = tit;
        desEdit.value = des;
        serialEdit = document.getElementById('serialEdit')
        serialEdit.value = e.target.id;
        console.log(e.target.id)

      })
    })

    let deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach(element => {
      element.addEventListener('click', (e) => {
        // console.log(e.target.parentNode.parentNode)
        let tr = e.target.parentNode.parentNode;
        let tit = tr.getElementsByTagName('td')[0].innerText;
        let des = tr.getElementsByTagName('td')[1].innerText;

        let serialno = e.target.id.substr(1, );
        if (confirm('Are you sure You want to delete note')) {
          console.log("Yes");
          window.location = `http://localhost/curd_notes_h/index.php?delete=${serialno}`;
        } else {
          console.log('No')
        }

      })
    })





    // $('#myModal').modal(options)
  </script>
</body>

</html>