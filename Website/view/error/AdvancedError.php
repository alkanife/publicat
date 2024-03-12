<div class="title">
    <h1><span><i>*sad cat*</i></span> A breaking error occurred!</h1>
    <p>You are seeing this page instead of the classic error page because Publicat is in Developer mode.</p>
</div>

<div class="content">
    <div class="tables">
        <?php
        $index = 0;

        if ($this->hasCaughtErrors()) {
            $prettyErrors = $this->getHtmlCaughtErrors();

            foreach ($prettyErrors as $error) {
                $index++;
                ?>

                <div class="table-collection">
                    <h2 class="red">Error <?= $index ?> <span>(caught)</span></h2>

                    <div class="table error">
                        <div class="row">
                            <div>
                                Message
                            </div>
                            <div>
                                <p><?= $error['message'] ?></p>
                            </div>
                        </div>

                        <div class="row">
                            <div>
                                Source
                            </div>
                            <div>
                                <p><?= $error['source'] ?></p>
                            </div>
                        </div>
                    </div>

                    <?php if (!empty($error['trace'])) { ?>
                        <div class="table trace">
                            <div class="row">
                                <div class="num">#</div>
                                <div class="file">file</div>
                                <div class="class">class</div>
                                <div class="function">function / line</div>
                            </div>

                            <?php foreach ($error['trace'] as $trace) { ?>
                                <div class="row">
                                    <div class="num"><p><?= $trace['index'] ?></p></div>
                                    <div class="file"><p><?= $trace['file'] ?></p></div>
                                    <div class="class"><p><?= $trace['class'] ?></p></div>
                                    <div class="function"><p><?= $trace['functionAndLine'] ?></p></div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
                <?php
            }
        }

        if ($this->hasErrors()) {
            foreach ($this->getErrors() as $errorKey => $error) {
                $index++;
                ?>

                <div class="table-collection">
                    <h2 class="red">Error <?= $index ?> <span>(encountered)</span></h2>
                    <div class="table error">
                        <?php
                        if (!empty($error)) {
                            $messageIndex = 0;
                            foreach ($error as $message) {
                                $messageIndex++;
                                ?>

                                <div class="row">
                                    <div>
                                        Message <?= $messageIndex ?>
                                    </div>
                                    <div>

                                        <p><span class="red"><b><?= $message ?></b></span></p>
                                    </div>
                                </div>

                                <?php
                            }
                        }
                        ?>
                        <div class="row">
                            <div>
                                Key (source)
                            </div>
                            <div>
                                <p><?= $errorKey ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <?php

            }
        }
        ?>

        <div class="table-collection">
            <h2>Other</h2>
            <div class="table">
                <div class="row">
                    <div>
                        REQUEST / RESPONSE
                    </div>
                    <div>
                        <?= $_SERVER['REQUEST_METHOD'] ?> / <?= http_response_code() ?>
                    </div>
                </div>
                <div class="row">
                    <div>
                        URI
                    </div>
                    <div>
                        <?= $_SERVER['REQUEST_URI'] ?>
                    </div>
                </div>
            </div>

            <div class="table">
                <div class="row">
                    <div>
                        PUBLICAT_PUBLIC_PATH
                    </div>
                    <div>
                        <?= PUBLICAT_PUBLIC_PATH ?>
                    </div>
                </div>
                <div class="row">
                    <div>
                        PUBLICAT_LANG
                    </div>
                    <div>
                        <?= PUBLICAT_LANG ?>
                    </div>
                </div>
            </div>

            <div class="table">
                <div class="row">
                    <div>
                        display code
                    </div>
                    <div>
                        <?= $this->getDisplayError()['code'] ?>
                    </div>
                </div>
                <div class="row">
                    <div>
                        display title
                    </div>
                    <div>
                        <span class="green">[<?= $this->getDisplayError()['title'] ?>]:</span> "<?= $this->t($this->getDisplayError()['title']) ?>"
                    </div>
                </div>
                <div class="row">
                    <div>
                        display message
                    </div>
                    <div>
                        <span class="green">[<?= $this->getDisplayError()['message'] ?>]:</span> "<?= $this->t($this->getDisplayError()['message']) ?>"
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>