<script type="text/javascript">
    alert('<?= $msg ?>');

    <? if ($url) : ?>
        document.location.href = '<?= $url ?>';
    <? else : ?>
        history.go(-1)
    <? endif; ?>
</script>
