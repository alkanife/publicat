<div class="title">
    <h1>Dictionary</h1>
</div>

<div class="content lang">
    <div class="tables">
        <?php foreach (LANG as $key => $value) { ?>
            <div class="table-collection">
                <h2><?= $key ?></h2>
                <div class="table">
                    <?php $this->printArrayValuesRow($value, $key); ?>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
