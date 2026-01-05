<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Areeba Gul Project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">

 <hr>
 <h3>Front End </h3>
 <hr>
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <h4>Add User</h4>
        </div>
        <div class="card-body">

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contact</label>
                    <input type="text" name="contact" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <textarea name="address" class="form-control" required></textarea>
                </div>

                <button type="submit" name="save" class="btn btn-success">
                    Save User
                </button>
            </form>

            <?php
            if (isset($_POST['save'])) {
                $name = $_POST['name'];
                $email = $_POST['email'];
                $contact = $_POST['contact'];
                $address = $_POST['address'];

                mysqli_query($conn, "INSERT INTO users (name,email,contact,address)
                VALUES ('$name','$email','$contact','$address')");
            }
            ?>

        </div>
    </div>

 <hr>
 <h3>Back End </h3>
 <hr>
    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            <h4>User List</h4>
        </div>
        <div class="card-body">

            <table class="table table-bordered table-hover text-center">
                <thead class="table-secondary">
                    <tr>
                        <th>ID</th><th>Name</th><th>Email</th>
                        <th>Contact</th><th>Address</th><th>Action</th>
                    </tr>
                </thead>
                <tbody>

                <?php
                $result = mysqli_query($conn, "SELECT * FROM users");
                
                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['contact'] ?></td>
                    <td><?= $row['address'] ?></td>
                    <td>
                        <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete.php?id=<?= $row['id'] ?>" 
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Are you sure?')">
                           Delete
                        </a>
                    </td>
                </tr>
                <?php } ?>

                </tbody>
            </table>

        </div>
    </div>

</div>

</body>
</html>

<?php
include 'db.php';

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM users WHERE id=$id");
$data = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];

    mysqli_query($conn, "UPDATE users SET
        name='$name',
        email='$email',
        contact='$contact',
        address='$address'
        WHERE id=$id");

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-warning">
            <h4>Edit User</h4>
        </div>
        <div class="card-body">

            <form method="POST">
                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" value="<?= $data['name'] ?>" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" value="<?= $data['email'] ?>" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Contact</label>
                    <input type="text" name="contact" value="<?= $data['contact'] ?>" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Address</label>
                    <textarea name="address" class="form-control"><?= $data['address'] ?></textarea>
                </div>

                <button type="submit" name="update" class="btn btn-success">Update</button>
                <a href="index.php" class="btn btn-secondary">Back</a>
            </form>

        </div>
    </div>
</div>

</body>
</html>

<?php
$conn = mysqli_connect("localhost", "root", "", "crud_db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

<?php
include 'db.php';

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM users WHERE id=$id");

header("Location: index.php");
?>



