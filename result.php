<?php include 'header.php'; ?>
<h2>Результати аналізу</h2>

<?php
    $df = $_GET['df'];
    $dg = $_GET['dg'];
    $cl = $_GET['cl'];
    $eff = round(($df / $dg) * ($cl / 10), 1);
?>

<div style="display: flex; gap: 30px; align-items: center;">
    <img src="generator.php?df=<?php echo $_GET['df']; ?>&dg=<?php echo $_GET['dg']; ?>&cl=<?php echo $_GET['cl']; ?>" alt="Діаграма">
    
    <div style="background: #f9f9f9; padding: 20px; border-radius: 10px;">
        <h3>Вердикт:</h3>
        <p>Коефіцієнт: <strong><?=$eff?></strong></p>
        <?php if($eff > 15): ?>
            <p style="color: green;">Чудове налаштування! Болід готовий до перемоги.</p>
        <?php elseif($eff > 8): ?>
            <p style="color: orange;">Середні показники. Можна покращити опір повітря.</p>
        <?php else: ?>
            <p style="color: red;">Погана конфігурація. Болід буде занадто повільним.</p>
        <?php endif; ?>
    </div>
</div>

<p><a href="test.php">← Змінити налаштування</a></p>
<?php include 'footer.php'; ?>