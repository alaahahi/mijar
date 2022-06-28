<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= trans("home"); ?></a></li>
                    <li class="breadcrumb-item active"><?= trans("posts"); ?></li>
                </ol>
            </div>
            <div id="content" class="col-sm-8">
                <div class="row">
                    <div class="col-sm-12"><h1 class="page-title"><?= trans("posts"); ?></h1></div>
                    <?php $count = 0;
                    if (!empty($posts)):
                        foreach ($posts as $post):
                            if ($count != 0 && $count % 2 == 0): ?>
                                <div class="col-sm-12"></div>
                            <?php endif;
                            echo view("post/_post_item_list", ["post" => $post, "showLabel" => true]);
                            if ($count == 1):
                                echo view('partials/_ad_spaces', ['adSpace' => 'posts_top', 'class' => 'p-b-30']);
                            endif;
                            $count++;
                        endforeach;
                    endif;
                    echo view('partials/_ad_spaces', ['adSpace' => 'posts_bottom', 'class' => '']); ?>
                    <div class="col-sm-12 col-xs-12">
                        <?= view('partials/_pagination'); ?>
                    </div>
                </div>
            </div>
            <div id="sidebar" class="col-sm-4">
                <?= view('partials/_sidebar'); ?>
            </div>
        </div>
    </div>
</div>