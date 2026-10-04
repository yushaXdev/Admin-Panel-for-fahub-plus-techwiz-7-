<?php
// UINIVERSAL FOOTER
?>
</div><!-- /.content -->
</main><!-- /.main -->
</div><!-- /.shell -->

<!-- Chart.js  -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<!--  JS -->
<script src="assets/js/admin-core.js"></script>
<script src="assets/js/admin-theme.js"></script>
<script src="assets/js/admin-sidebar.js"></script>
<script src="assets/js/admin-navigation.js"></script>
<script src="assets/js/admin-modal.js"></script>
<script src="assets/js/admin-toast.js"></script>
<script src="assets/js/admin-table.js"></script>

<?php if (!empty($page_js)): ?>
  <script src="assets/js/<?= e($page_js) ?>"></script>
<?php endif; ?>
</body>
</html>