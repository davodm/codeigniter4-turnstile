<!-- Cloudflare Captcha -->
<script src="https://challenges.cloudflare.com/turnstile/v0/api.js?onload=turnstileReady" defer></script>
<script type="text/javascript">
    function turnstileReady() {
        var fields = <?php echo json_encode($fields); ?>;
        fields.forEach(function(field) {
            turnstile.render('#' + field.fieldName, {
                sitekey: <?php echo htmlspecialchars($siteKey, ENT_QUOTES, 'UTF-8'); ?>,
                'response-field-name': field.fieldName,
                size: field.size,
                theme: field.theme
            });
        });
    }
</script>