<!-- SIDEBAR -->
<aside id="main-sidebar" class="nicescroll">
    <div class="menu-section">
        <ul class="nav side-menu">
            <li class="active"><a href="<?php echo site_url('admin/dashboard'); ?>"><i class="icon ion-home"></i> <span class="title"><?php echo lang('text_dashboard') ?></span></a></li>
            <?php if ($this->session->userdata['user_privilege'] == (int) 1) : ?>
                <li><a><i class="icon ion-ios-paper"></i> <span class="title"><?php echo lang('text_posts') ?></span> <i class="icon ion-ios-arrow-left menu-carret"></i></a>
                    <ul class="nav child-menu">
                        <li><a href="<?php echo site_url('admin/blog/blogs') ?>"><?php echo lang('text_all_posts') ?></a></li>
                        <li><a href="<?php echo site_url('admin/blog/blogs/edit') ?>"><?php echo lang('text_add_post') ?></a></li>
                        <li><a href="<?php echo site_url('admin/blog/category') ?>"><?php echo lang('text_categories') ?></a></li>
                        <li><a href="<?php echo site_url('admin/blog/tag') ?>"><?php echo lang('text_tags') ?></a></li>
                        <li><a href="<?php echo site_url('admin/blog/comment') ?>"><?php echo lang('text_comments') ?></a></li>
                    </ul>
                </li>
                <li><a><i class="icon ion-clipboard"></i> <span class="title">Agenda</span><i class="icon ion-ios-arrow-left menu-carret"></i></a>
                    <ul class="nav child-menu">
                        <li><a href="<?php echo site_url('admin/agenda') ?>">Semua Agenda</a></li>
                        <li><a href="<?php echo site_url('admin/agenda/edit') ?>">Tambah Agenda</a></li>
                    </ul>
                </li>
                <li><a><i class="icon ion-settings"></i></i> <span class="title">Layanan</span><i class="icon ion-ios-arrow-left menu-carret"></i></a>
                    <ul class="nav child-menu">
                        <li><a href="<?php echo site_url('admin/layanan') ?>">Semua Layanan</a></li>
                        <li><a href="<?php echo site_url('admin/layanan/edit') ?>">Tambah Layanan</a></li>
                    </ul>
                </li>
                <li><a><i class="icon ion-ios-photos"></i> <span class="title"><?php echo lang('text_pages') ?></span> <i class="icon ion-ios-arrow-left menu-carret"></i></a>
                    <ul class="nav child-menu">
                        <li><a href="<?php echo site_url('admin/page/pages') ?>"><?php echo lang('text_all_pages') ?></a></li>
                        <li><a href="<?php echo site_url('admin/page/pages/edit') ?>"><?php echo lang('text_add_page') ?></a></li>
                    </ul>
                </li>
                <li><a><i class="icon ion-android-download"></i> <span class="title">Download</span> <i class="icon ion-ios-arrow-left menu-carret"></i></a>
                    <ul class="nav child-menu">
                        <li><a href="<?php echo site_url('admin/download') ?>">Semua Download</a></li>
                        <li><a href="<?php echo site_url('admin/download_category') ?>">Kategori Download</a></li>
                    </ul>
                </li>
            <?php endif; ?>
            <?php //$allValues = array('19','20','21','22');
            //if(in_array($this->session->userdata['user_group_id'],$allValues, true)): 
            ?>
            <li><a><i class="icon ion-chatboxes"></i> <span class="title">Pengaduan</span> <i class="icon ion-ios-arrow-left menu-carret"></i></a>
                <ul class="nav child-menu">
                    <li><a href="<?php echo site_url('admin/pengaduan') ?>">Semua Pengaduan</a></li>
                    <li><a href="<?php echo site_url('admin/pengaduan/arsip') ?>">Arsip Pengaduan</a></li>
                </ul>
            </li>
            <li><a><i class="icon ion-chatboxes"></i> <span class="title">Konsultasi</span> <i class="icon ion-ios-arrow-left menu-carret"></i></a>
                <ul class="nav child-menu">
                    <li><a href="<?php echo site_url('admin/konsultasi') ?>">Semua Konsultasi</a></li>
                    <li><a href="<?php echo site_url('admin/konsultasi/arsip') ?>">Arsip Konsultasi</a></li>
                </ul>
            </li>
            <?php //endif 
            ?>
            <?php if ($this->session->userdata['user_privilege'] == (int) 1) : ?>
                <li><a><i class="icon ion-chatboxes"></i> <span class="title">SKM</span> <i class="icon ion-ios-arrow-left menu-carret"></i></a>
                    <ul class="nav child-menu">
                        <li><a href="<?php echo site_url('admin/skm') ?>">Pertanyaan</a></li>
                        <li><a href="<?php echo site_url('admin/skm/penilaian') ?>">Hasil Penilaian</a></li>
                    </ul>
                </li>
                <li><a><i class="icon ion-images"></i> <span class="title"><?php echo lang('text_media') ?></span> <i class="icon ion-ios-arrow-left menu-carret"></i></a>
                    <ul class="nav child-menu">
                        <li><a href="<?php echo site_url('admin/media') ?>"><?php echo lang('text_libraries') ?></a></li>
                        <li><a href="<?php echo site_url('admin/media/add') ?>"><?php echo lang('text_add_media') ?></a></li>
                    </ul>
                </li>
                <li><a><i class="icon ion-tshirt"></i> <span class="title"><?php echo lang('text_plugins') ?></span> <i class="icon ion-ios-arrow-left menu-carret"></i></a>
                    <ul class="nav child-menu">
                        <li><a href="<?php echo site_url('admin/plugin') ?>"><?php echo lang('text_all_plugins') ?></a></li>
                        <li><a href="<?php echo site_url('admin/plugin/add') ?>"><?php echo lang('text_add_plugin') ?></a></li>
                    </ul>
                </li>
                <li><a><i class="icon ion-paintbrush"></i> <span class="title"><?php echo lang('text_themes') ?></span> <i class="icon ion-ios-arrow-left menu-carret"></i></a>
                    <ul class="nav child-menu">
                        <li><a href="<?php echo site_url('admin/theme/theme') ?>"><?php echo lang('text_all_themes') ?></a></li>

                        <?php if (is_array($theme_options)) : foreach ($theme_options as $option) { ?>
                                <li><a href="<?php echo $option['theme_option_url'] ?>"><?php echo $option['themename'] ?></a></li>
                        <?php }
                            endif ?>

                        <li><a href="<?php echo site_url('admin/theme/widget') ?>"><?php echo lang('text_widgets') ?></a></li>
                        <li><a href="<?php echo site_url('admin/theme/menu') ?>"><?php echo lang('text_menus') ?></a></li>
                    </ul>
                </li>
                <li><a><i class="icon ion-wrench"></i> <span class="title"><?php echo lang('text_tools') ?></span> <i class="icon ion-ios-arrow-left menu-carret"></i></a>
                    <ul class="nav child-menu">
                        <li><a href="<?php echo site_url('admin/tool/backup') ?>"><?php echo lang('text_backup') ?></a></li>
                    </ul>
                </li>
                <li><a><i class="icon ion-gear-a"></i> <span class="title"><?php echo lang('text_settings') ?></span> <i class="icon ion-ios-arrow-left menu-carret"></i></a>
                    <ul class="nav child-menu">
                        <li><a href="<?php echo site_url('admin/setting/general') ?>"><?php echo lang('text_general') ?></a></li>
                    </ul>
                </li>
                <li><a><i class="icon ion-earth"></i> <span class="title"><?php echo lang('text_localisation') ?></span> <i class="icon ion-ios-arrow-left menu-carret"></i></a>
                    <ul class="nav child-menu">
                        <li><a href="<?php echo site_url('admin/localisation/language') ?>"><?php echo lang('text_language') ?></a></li>
                    </ul>
                </li>
            <?php endif ?>
            <?php if ($this->session->userdata['user_privilege'] == (int) 1) : ?>
                <li><a><i class="icon ion-person-stalker"></i> <span class="title"><?php echo lang('text_users') ?></span> <i class="icon ion-ios-arrow-left menu-carret"></i></a>
                    <ul class="nav child-menu">
                        <li><a href="<?php echo site_url('admin/user/user') ?>"><?php echo lang('text_all_users') ?></a></li>
                        <li><a href="<?php echo site_url('admin/user/user_permission') ?>"><?php echo lang('text_user_permission') ?></a></li>
                    </ul>
                </li>
            <?php else : ?>
                <li><a><i class="icon ion-person"></i> <span class="title"><?php echo lang('text_users') ?></span> <i class="icon ion-ios-arrow-left menu-carret"></i></a>
                    <ul class="nav child-menu">
                        <li><a href="<?php echo site_url('admin/user/user/edit/' . $this->session->userdata['user_id']); ?>"><?php echo lang('text_profile') ?></a></li>
                    </ul>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</aside>