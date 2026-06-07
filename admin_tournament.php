<?php 
// Підключення до бази даних
$conn = mysqli_connect("localhost", "root", "", "f1_racing");
if (!$conn) {
    die("Помилка з'єднання: " . mysqli_connect_error());
}

// Початкові змінні для форми 
$edit_id = 0;
$edit_name = "";
$edit_car = "";
$edit_country = "";
$update_mode = false;

// Видалення учасника
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM participants WHERE id = $id");
    header("Location: admin_tournament.php");
    exit();
}

//Підготовка до редагування 
if (isset($_GET['edit'])) {
    $edit_id = (int)$_GET['edit'];
    $res = mysqli_query($conn, "SELECT * FROM participants WHERE id = $edit_id");
    if ($row = mysqli_fetch_assoc($res)) {
        $edit_name = $row['pilot_name'];
        $edit_car = $row['car_model'];
        $edit_country = $row['country'];
        $update_mode = true; // Перемикаємо форму в режим оновлення
    }
}

//Збереження (Додавання або Оновлення)
if (isset($_POST['save_pilot'])) {
    $id = (int)$_POST['id'];
    $name = mysqli_real_escape_string($conn, $_POST['p_name']);
    $car = mysqli_real_escape_string($conn, $_POST['c_model']);
    $country = mysqli_real_escape_string($conn, $_POST['country']);
    
    if ($id == 0) {
        $sql = "INSERT INTO participants (pilot_name, car_model, country) VALUES ('$name', '$car', '$country')";
    } else {
        $sql = "UPDATE participants SET pilot_name='$name', car_model='$car', country='$country' WHERE id=$id";
    }
    
    mysqli_query($conn, $sql);
    header("Location: admin_tournament.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Турнір - F1 Fan Shop</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .admin-box { padding: 40px; max-width: 900px; margin: 0 auto; min-height: 500px; }
        .f1-form { background: #f9f9f9; padding: 25px; border-left: 5px solid #e10600; margin-bottom: 30px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .f1-form input { padding: 10px; margin-right: 10px; border: 1px solid #ccc; width: 180px; }
        .f1-table { width: 100%; border-collapse: collapse; background: #fff; }
        .f1-table th, .f1-table td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        .f1-table th { background: #15151e; color: #fff; }
        .btn-add { background: #e10600; color: #fff; border: none; padding: 10px 25px; cursor: pointer; font-weight: bold; }
        .btn-del { color: #e10600; text-decoration: none; font-size: 0.9em; margin-left: 10px; }
        .btn-edit { color: #2e5bff; text-decoration: none; font-size: 0.9em; }
        .cancel-link { font-size: 0.9em; color: #666; text-decoration: none; margin-left: 10px; }
    </style>
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="admin-box">
        <div class="f1-form">
            <h2><?php echo $update_mode ? "Редагувати учасника №$edit_id" : "Реєстрація учасника"; ?></h2>
            
            <form method="POST">
                <input type="hidden" name="id" value="<?php echo $edit_id; ?>">
                
                <input type="text" name="p_name" placeholder="Ім'я пілота" value="<?php echo $edit_name; ?>" required>
                <input type="text" name="c_model" placeholder="Болід" value="<?php echo $edit_car; ?>" required>
                <input type="text" name="country" placeholder="Країна" value="<?php echo $edit_country; ?>" required>
                
                <button type="submit" name="save_pilot" class="btn-add">
                    <?php echo $update_mode ? "Зберегти зміни" : "Додати"; ?>
                </button>

                <?php if ($update_mode): ?>
                    <a href="admin_tournament.php" class="cancel-link">Скасувати</a>
                <?php endif; ?>
            </form>
        </div>

        <h2>Список пілотів у базі</h2>
        <table class="f1-table">
            <thead>
                <tr>
                    <th>№</th>
                    <th>Пілот</th>
                    <th>Болід</th>
                    <th>Країна</th>
                    <th>Дії</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = mysqli_query($conn, "SELECT * FROM participants ORDER BY id DESC");
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['pilot_name']}</td>
                        <td>{$row['car_model']}</td>
                        <td>{$row['country']}</td>
                        <td>
                            <a href='?edit={$row['id']}' class='btn-edit'>📝 редагувати</a>
                            <a href='?delete={$row['id']}' class='btn-del' onclick='return confirm(\"Видалити цього пілота?\")'>❌ видалити</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php include 'footer.php'; ?>

</body>
</html>