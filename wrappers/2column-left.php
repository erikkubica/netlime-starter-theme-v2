<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?php wp_head() ?>
    </head>
    <body>
        <div id="wrapper">
            <?php theme()->getContent("top"); ?>
            <div id="main">
                <main role="main" class="container">
                    <div class="row">
                        <div class="col-sm-12 col-md-3">
                            <?php theme()->getContent("left"); ?>
                        </div>
                        <div class="col-sm-12 col-md-9">
                            <?php theme()->getContent("content"); ?>
                        </div>
                    </div>
                </main>
            </div>
            <?php theme()->getContent("bottom"); ?>
        </div>
        <?php wp_footer(); ?>
    </body>
</html>
