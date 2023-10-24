<?php
session_start(); 
include('api/database_config.php');

if (!isset($_SESSION['user_email_todo'])) {

    header("Location: login.php");

    exit(); 
}else{

  $user = $_SESSION['user_email_todo'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDo List</title>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        
       #editForm {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 80%; 
    max-width: 550px;
    height: 150px;
    background-color: white;
    padding: 15px;
}
    </style>
</head>
<body style="background-color: #f7f8fa;">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">To-Do App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav justify-content-end">
                    <li class="nav-item">
                        <button class="btn btn-danger" id="redirectButton">Logout</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Body -->
    <form id="InsertForm">
      
        <div class="container mt-3">
          <div id="result"></div>
            <div class="input-group">
                <textarea id="data" class="form-control" name="data" placeholder="Insert Data" aria-describedby="Insert_button"></textarea>
                <button type="submit" name="Insert_button" id="Insert_button" class="btn btn-primary text-white btn-outline-success">Save</button>
            </div>
        </div>
    </form>
                      
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <!-- edit Form -->
            <div id="editForm" style="display: none;">
                <form id="editItemForm">
                    <input type="hidden" id="editItemId" name="editItemId" value="">
                    <textarea id="editItemData" class="form-control" name="data" placeholder="Edit Data" aria-describedby="Edit_button"></textarea>
                    <button type="submit" id="saveEdit" class="mt-3 w-100 btn btn-primary text-white btn-outline-success">Save</button>
                </form>
            </div>
            <!-- /edit Form -->
        </div>
    </div>
</div>

    <!-- table -->
      <div class="container mt-3">
        <h1>To-Do Items</h1>
        <table  class="table table-dark table-hover rounded-2">
            <thead>
                <tr>
                    <th>#</th>
                    <th>To-Do Items</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody id="todo-table">
                
            </tbody>
        </table>
    </div>
    <!-- /table -->

    <!-- /Main Body -->
    <script>
      //create api
        $(document).ready(function() {
          $("#InsertForm").on("submit", function(event) {
            event.preventDefault(); 

            var todo = $("#data").val();
            var user = "<?php echo $user; ?>";
            

            $.ajax({
              type: "POST",
              url: "api/create.php", 
              data: {
                todo: todo,
                user: user
              },
              success: function(response) {
                if (response.message === "Inserted") {
                  $("#result").html('<div class="alert alert-success">' + response.message + '</div>');
                  $("#data").val("");
                  Loaddata();
                } else {
                  $("#result").html('<div class="alert alert-danger">' + response.message + '</div>');
                }
              }
            });
          });
        });
    </script>


        <script>
          //function to load data
        function Loaddata() {
                $.ajax({
                    type: "GET",
                    url: "api/fetchapi.php",
                    dataType: "json",
                    success: function(response) {
                        const todoTable = $("#todo-table");
                        todoTable.empty();

                        if (response.data && response.data.length > 0) {
                            response.data.forEach(function(item, index) {
                                const row = $("<tr>");
                                row.append($("<td>").text(index + 1));
                                row.append($("<td>").text(item.Todo_Data));
                                row.append($("<td>").html('<button class="btn btn-warning" onclick="editItem(' + item.Item_Id + ')">Edit</button>'));
                                row.append($("<td>").html('<button class="btn btn-danger" onclick="deleteItem(' + item.Item_Id + ')">Delete</button>'));
                                todoTable.append(row);
                            });
                        } else {
                            todoTable.append("<tr><td colspan='4'>No to-do items found.</td></tr>");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX request failed: " + error);
                    }
                });
            }

            
            Loaddata();


        function deleteItem(itemId) {
            //delete api
             $.ajax({
                    type: "POST",
                    url: "api/delete.php",
                    data: { Item_Id: itemId },
                    dataType: "json",
                    success: function(response) {
                        if (response.message === "Deleted") {
                            // Reload data after deletion
                            Loaddata();
                        } else {
                            console.error("Deletion failed: " + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX request failed: " + error);
                    }
                });
        }
    </script>


    <script>
      //fetch api
function editItem(itemId) {
    
    $.ajax({
        type: "GET",
        url: "api/fetchapi.php", 
        data: { item_id: itemId },
        success: function(response) {
            if (response.data) {
                
                $("#editItemId").val(itemId);
                $("#editItemData").val(response.data.Todo_Data);

                $("#editForm").show();
            } else {
                console.log("Item not found.");
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX request failed: " + error);
        }
    });
}


$("#editItemForm").on("submit", function(event) {
    event.preventDefault(); 

    var itemId = $("#editItemId").val();
    var editedData = $("#editItemData").val();

    
    $.ajax({
        type: "POST",
        url: "api/update.php", 
        data: {
            item_id: itemId,
            data: editedData
        },
        success: function(response) {
            if (response.message === "Updated") {
                
                $("#editForm").hide();

              
                Loaddata();
            } else {
          
                console.log("Update failed: " + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX request failed: " + error);
        }
    });
});

    </script>


    <script>
      //form show
    $(document).ready(function() {
  
        $("#showForm").click(function() {
            $("#editForm").show();
        });

        //hide
        $(document).mouseup(function(e) {
            var form = $("#editForm");
            if (!form.is(e.target) && form.has(e.target).length === 0) {
                form.hide();
            }
        });
    });
</script>

 <script>
        //Logout
        var button = document.getElementById("redirectButton");

      
        button.addEventListener("click", function() {
      
            var redirectUrl = "logout.php";

          
            window.location.href = redirectUrl;
        });
    </script>


  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
