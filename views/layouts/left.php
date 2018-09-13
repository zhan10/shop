<aside class="main-sidebar">
    <section class="sidebar">
      <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => '菜单', 'options' => ['class' => 'header']],
                    ['label' => '首页', 'icon' => 'fa fa-file-code-o', 'url' => ['/dashboard']],
                    [
                        'label' => '系统管理',
                        'icon' => 'fa fa-file-code-o',
                        'url' => '#',
                        'items' => [
                            ['label' => '用户管理', 'icon' => 'fa fa-circle-o', 'url' =>['/user/list']]
                        ],
                    ],
                ],
            ]
        ) ?>
    </section>
</aside>
