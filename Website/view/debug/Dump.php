<div class="title">
    <h1>Variable dump</h1>
</div>

<div class="content lang">
    <div class="tables">
        <div class="table-collection">
            <h2>SESSION</h2>
            <div class="table">
                <?php
                var_dump($_SESSION);
                ?>
            </div>
        </div>
        <div class="table-collection">
            <h2>COOKIE</h2>
            <div class="table">
                <?php
                var_dump($_COOKIE);
                ?>
            </div>
        </div>
        <div class="table-collection">
            <h2>SERVER</h2>
            <div class="table">
                <?php $this->printArrayValuesRow($_SERVER); ?>
            </div>
        </div>
        <div class="table-collection">
            <h2>ENV</h2>
            <div class="table">
                <?php
                var_dump($_ENV);
                ?>
            </div>
        </div>
    </div>
</div>
