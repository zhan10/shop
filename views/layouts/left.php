<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
    <!--    <div class="user-panel">
            <div class="pull-left image">
                <img src="<?/*= $directoryAsset */?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>-->

        <!-- search form -->
        <!--<form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>-->
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => '菜单', 'options' => ['class' => 'header']],
                    ['label' => '首页', 'icon' => 'fa fa-file-code-o', 'url' => ['/dashboard/show']],
                    /*[   'label' => '模块管理',
                        'icon' => 'fa fa-dashboard',
                        'url' => ['/debug'],
                        'items'=> [
                            ['label' => '模块管理', 'icon' => 'fa fa-circle-o', 'url' => ['/module']],
                            ['label' => '模块订购记录', 'icon' => 'fa fa-circle-o', 'url' => ['/module/history']],
                        ]
                    ],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],*/
                    [
                        'label' => '公司管理',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'items' => [
                            ['label' => '公司列表', 'icon' => 'fa fa-circle-o', 'url' => ['/management/company']],
                            ['label' => '来访记录', 'icon' => 'fa fa-circle-o', 'url' => ['/visitors-record']],
                            ['label' => '授权记录', 'icon' => 'fa fa-circle-o', 'url' => ['/authorise-record']],
                            /* ['label' => '功能图表', 'icon' => 'fa fa-circle-o', 'url' => ['/statistics/func']],*/
                        ],
                    ],
                    [
                        'label' => '手机管理',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'items' => [
                            ['label' => '角色管理', 'icon' => 'fa fa-circle-o', 'url' => ['/phone-manage/role-manage']],
                            ['label' => '菜单管理', 'icon' => 'fa fa-circle-o', 'url' => ['/phone-manage/menu-manage']],
                        ],
                    ],
                    [
                        'label' => '统计',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'items' => [
                            [
                                'label' => '用户数据',
                                'icon' => 'fa fa-share',
                                'url' => '#',
                                'items' => [
                                    ['label' => '公司图表', 'icon' => 'fa fa-circle-o', 'url' => ['/statistics/company']],
                                    ['label' => '用户图表', 'icon' => 'fa fa-circle-o', 'url' => ['/statistics/user']],
                                ]
                            ],
                            [
                                'label' => '基本数据',
                                'icon' => 'fa fa-share',
                                'url' => '#',
                                'items' => [
                                    ['label' => '行业分析', 'icon' => 'fa fa-circle-o', 'url' => ['/industry']],
                                    ['label' => '规模分析', 'icon' => 'fa fa-circle-o', 'url' => ['/scale']],
                                    //['label' => '注册资本分析', 'icon' => 'fa fa-circle-o', 'url' => ['/registered-capital']],
                                ]
                            ],
                            [
                                'label' => '行为数据',
                                'icon' => 'fa fa-share',
                                'url' => '#',
                                'items' => [
                                    ['label' => '门禁分析', 'icon' => 'fa fa-circle-o', 'url' => ['/behavioral-data/door']],
                                    ['label' => '停车分析', 'icon' => 'fa fa-circle-o', 'url' => ['/behavioral-data/park']],
                                ]
                            ]
                           /* ['label' => '功能图表', 'icon' => 'fa fa-circle-o', 'url' => ['/statistics/func']],*/
                        ],
                    ],
                    [
                        'label' => '系统管理',
                        'icon' => 'fa fa-file-code-o',
                        'url' => ['/gii'],
                        'items' => [
                            ['label' => '用户管理', 'icon' => 'fa fa-circle-o', 'url' =>['/user/list']],
                            ['label' => '消息通知', 'icon' => 'fa fa-circle-o', 'url' => ['/message/index']],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
