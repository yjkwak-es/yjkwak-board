<script type="text/javascript">
    alert('<?= $msg ?>');

    <? if ($url) : ?>
        document.location.href = '<?= $url ?>';
    <? endif; ?>
</script>