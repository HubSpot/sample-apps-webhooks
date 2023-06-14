<?php use Helpers\OAuth2Helper;

include __DIR__.'/../_partials/header.php';
?><script type="application/javascript" src="/js/login.js?<?php echo filemtime('./js/login.js'); ?>"></script>
<pre>
// src/actions/oauth/authorize.php - Generate URL for OAuth
$authUrl = HubSpot\Utils\OAuth2::getAuthUrl(
    'ClientID',
    'Redirect Uri',
    ['Scopes']
);
</pre>
<div class="text-center">
    <h3>In order to continue please update the redirect URL on Auth settings page  of your app</h3>
    <h4>Redirect URL</h3>
    <pre id="redirectURL"><?php echo OAuth2Helper::getRedirectUri(); ?></pre>
    <div class="row justify-content-center">
        <button class="button-primary" onclick="copyRedirectURL()">Copy</button>
    </div>
    <h3>After that authorize via OAuth</h3>
    <div class="row justify-content-center">
        <a class="button" href="/oauth/authorize">Authorize</a>
    </div>
</div>
<?php include __DIR__.'/../_partials/footer.php'; ?>
