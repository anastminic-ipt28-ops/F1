<?php include 'header.php'; ?>
<h2>Конфігуратор аеродинаміки боліда</h2>
<h4>Спробуй себе у ролі інженера та створи ідеальні налаштування для боліду. Вводь параметри боліда в пунктах/points (0-100 pts), щоб розрахувати фінальний коефіцієнт ефективності</h4>
<form action="result.php" method="GET">
    <label>Притискна сила (Downforce) [0-100]:</label><br>
    <input type="number" name="df" value="80" min="0" max="100"><br><br>
    
    <label>Лобовий опір (Drag) [1-100]:</label><br>
    <input type="number" name="dg" value="40" min="1" max="100"><br><br>
    
    <label>Рівень охолодження (Cooling) [0-100]:</label><br>
    <input type="number" name="cl" value="60" min="0" max="100"><br><br>
    
    <input type="submit" value="Розрахувати ефективність">
</form>
<?php include 'footer.php'; ?>