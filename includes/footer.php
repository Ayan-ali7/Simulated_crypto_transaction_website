    </main>
    <footer class="main-footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> <?php echo $site_name; ?> - Cryptocurrency Trading Simulation</p>
        </div>
    </footer>
    <script src="assets/js/main.js"></script>
    <?php if (isset($extra_js)): ?>
        <?php foreach ($extra_js as $js): ?>
            <script src="<?php echo $js; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
