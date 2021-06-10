</div>
<!-- Librairies -->
<script type="text/javascript"
    src="<?= $this->get_Asset('js/librairies/adminlib', 'js') ?? ''?>">
</script>
<!-- Common vendor -->
<script type="text/javascript"
    src="<?= $this->get_Asset('commons/backend/admin/commonVendor', 'js') ?? ''?>">
</script>
<!-- Common custom modules -->
<script type="text/javascript"
    src="<?= $this->get_Asset('commons/backend/admin/commonCustomModules', 'js') ?? ''?>">
</script>
<!-- Plugins -->
<script type="text/javascript"
    src="<?= $this->get_Asset('js/plugins/adminplugins', 'js') ?? ''?>">
</script>
<!-- Mainjs -->
<script type="text/javascript"
    src="<?= $this->get_Asset('js/main/backend/admin/main', 'js') ?? ''?>">
</script>
<?= $this->content('footer');?>
</body>

</html>