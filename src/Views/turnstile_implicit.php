<!-- Cloudflare Captcha -->
<?php if($init):?>
<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
<?php endif;?>
<div class="cf-turnstile" 
     data-sitekey="<?php echo htmlspecialchars($siteKey, ENT_QUOTES, 'UTF-8'); ?>" 
     data-theme="<?php echo htmlspecialchars($theme, ENT_QUOTES, 'UTF-8'); ?>" 
     data-response-field-name="<?php echo htmlspecialchars($fieldName, ENT_QUOTES, 'UTF-8'); ?>" 
     data-size="<?php echo htmlspecialchars($size, ENT_QUOTES, 'UTF-8'); ?>">
</div>