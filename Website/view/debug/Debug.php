<div class="title">
    <h1>Publicat debug panel</h1>
    <div class="tools">
        <a href="/debug/phpinfo">PHP Info</a>
        <a href="/debug/lang">Language / keys</a>
        <a href="/debug/dump">Dump variables</a>
        <a href="/debug/destroy-session">Destroy session</a>
        <a href="/debug/hash-password">Hash password</a>
    </div>
</div>

<div class="content">
    <div id="routes">
    </div>
</div>

<script>
    const routes = [
        {
            name: 'Debug tools',
            routes: [
                'debug/phpinfo',
                'debug/lang',
                'debug/dump',
                'debug/destroy-session',
                'debug/hash-password'
            ]
        },
        {
            name: 'Debug errors',
            routes: [
                'debug/test-advanced-error',
                'debug/view-error/0',
                'debug/view-error/400',
                'debug/view-error/401',
                'debug/view-error/403',
                'debug/view-error/404',
                'debug/view-error/405',
                'debug/view-error/406',
                'debug/view-error/407',
                'debug/view-error/412',
                'debug/view-error/414',
                'debug/view-error/415',
                'debug/view-error/418',
                'debug/view-error/500',
                'debug/view-error/501',
                'debug/view-error/502',
                'debug/view-error/503'
            ]
        },
        {
            name: 'Debug JSON',
            routes: [
                'debug/register',
                'debug/login',
            ]
        },
        {
            name: 'JSON routes',
            routes: [
                'json/verify_username',
                'json/verify_email',
                'json/register',
                'json/login',
                'json/follow',
                'json/unfollow'
            ]
        },
        {
            name: 'Routes',
            routes: [
                'home',
                'register',
                'login',
                'user/publicat',
                'user/publicat/followers',
                'user/publicat/following',
                'user-settings',
                'write'
            ]
        }
    ];

    const routesDiv = document.getElementById('routes');
    let routesDivs = '';

    for (const route of routes) {
        let title = '<h3>' + route.name + '</h3>';
        let links = '';

        for (const routeString of route.routes) {
            links += `<li><a href="/${routeString}">/${routeString}</a></li>`
        }

        routesDivs += `<div style="margin-bottom: 50px;">${title}<ul>${links}</ul></div>`;
    }

    routesDiv.innerHTML = routesDivs;
</script>


















