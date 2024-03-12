<div class="title">
    <h1>Register override</h1>
</div>

<div class="content">
    <form action="">
        <div>
            <label for="username">Username</label>
            <input type="text" id="username" name="username">
        </div>
        <div>
            <label for="email">Email</label>
            <input type="text" id="email" name="email">
        </div>
        <div>
            <label for="password">Password</label>
            <input type="text" id="password" name="password">
        </div>
        <input type="submit">
    </form>

    <pre id="response" style="font-family: monospace; margin-top: 50px"></pre>
</div>

<script>
    let queryNum = 0;
    let queryHead = '';

    document.querySelector('form').addEventListener('submit', (event) => {
        event.preventDefault();
        queryNum++;
        queryHead = `[${queryNum}]:\n\n`;

        const request = {
            username: document.getElementById('username').value,
            email: document.getElementById('email').value,
            password: document.getElementById('password').value,
            tos: true
        }

        register(request).then((data) => {
            document.getElementById('response').textContent = queryHead + JSON.stringify(data, undefined, 2);
        }).catch((err) => {
            document.getElementById('response').textContent = queryHead + 'error';
            console.log(err)
        })
    });

    async function register(data = {}) {
        const response = await fetch('/json/register', {
            method: "POST",
            mode: "cors",
            cache: "no-cache",
            credentials: "same-origin",
            headers: {
                "Content-Type": "application/json",
            },
            redirect: "follow",
            referrerPolicy: "no-referrer",
            body: JSON.stringify(data)
        });

        return response.json();
    }
</script>