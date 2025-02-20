<main>
    <h1>Dashboard</h1>

    <?php session_abort(); session_start() ?>
    <?php echo '<pre>'; var_dump($_SESSION['user']); ?>
</main>