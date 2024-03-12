<div class="title">
    <h1>Hash password</h1>
</div>

<div class="content">
    <form action="" method="post" style="margin-bottom: 40px;">
        <label for="password">Password</label>
        <input type="text" id="password" name="password">
        <input type="submit">
    </form>

    <?= $this->getArg('password') ?? '' ?>
</div>