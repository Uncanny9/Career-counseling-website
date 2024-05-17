<?php
    session_start();
    if(!isset($_SESSION['user_id']) || $_SESSION['usertype'] !== 'Admin'){
        header('Location: index1.php'); // Redirect if not logged in as admin
        exit();
    }
    include 'config1.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    
    <style>
        .user-table {
            border-collapse: collapse;
            width: 100%;
        }

        .user-table th, .user-table td {
            border: 1px solid black;
            padding: 8px;
        }

        .user-table th {
            background-color: #f2f2f2;
        }

        .btn-delete {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 4px;
            font-size: 14px;
        }

        .btn-delete:hover {
            background-color: #ff6659;
        }

        .btn-logout {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
            font-size: 16px;
            margin-top: 10px;
        }

        .btn-logout:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Welcome, Admin!</h1>
    
    <!-- Display Users Table -->
    <h2>Users</h2>
    <table class="user-table">
        <tr>
            <th>User ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        <?php
            $select_users = "SELECT * FROM login WHERE usertype = 'user'";
            $result_users = mysqli_query($conn, $select_users);

            while($row = mysqli_fetch_assoc($result_users)){
                echo "<tr>";
                if(isset($row['id'])) {
                    echo "<td>".$row['id']."</td>";
                } else {
                    echo "<td> N/A </td>"; // Handle the case where user_id is not set
                }
                echo "<td>".$row['username']."</td>";
                echo "<td>".$row['email']."</td>";
                echo "<td><button class='btn-delete' onclick='confirmDelete({$row['id']})'>Delete</button></td>";
                echo "</tr>";
            }
        ?>
    </table>

    <button class="btn-logout" onclick="logout()">Logout</button>

    <?php
        // Delete User
        if(isset($_GET['delete'])){
            $user_id = $_GET['delete'];
            $delete_user = "DELETE FROM login WHERE id = $user_id";
            mysqli_query($conn, $delete_user);
            header('Location: admin.php'); // Redirect after deletion
            exit();
        }
    ?>

    <script>
        function confirmDelete(userId) {
            if (confirm("Are you sure you want to delete this user?")) {
                window.location.href = `admin.php?delete=${userId}`;
            }
        }

        function logout() {
            window.location.href = 'index1.php';
        }
    </script>
</body>
</html>
