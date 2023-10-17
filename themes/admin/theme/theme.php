<!-- CONTENT -->
<div id="main-content">
    <div id="content">
        <div class="content-wrap scroll-view">
            <!-- <section class="content-header"></section> -->
            <section class="content-body">
                <?php if (isset($this->session->userdata['error'])) {
                    echo '<div class="alert alert-warning alert-dismissable" role="alert">' . $this->session->userdata['error'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>';
                } ?>
                <?php if (isset($this->session->userdata['success'])) {
                    echo '<div class="alert alert-success alert-dismissable" role="alert">' . $this->session->userdata['success'] . '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button></div>';
                } ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-line">
                            <div class="card-header">
                                <div class="card-header-title">
                                    <i class="icon ion-paintbrush"></i><?php echo lang('text_all_themes') ?>
                                </div>
                                <div class="tools">
                                    <div class="btn-group">
                                        <a class="btn btn-default btn-icon-toggle btn-collapse"><i class="icon ion-chevron-down menu-caret"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="themes">
                                    <div class="row">
                                        <?php foreach ($themes as $theme) : ?>
                                            <div class="theme col-md-4">
                                                <div class="image"><img src="<?php echo $theme['theme_thumb']; ?>" alt=""></div>
                                                <div class="caption">
                                                    <div class="theme-name">
                                                        <span><?php echo $theme['theme_name']; ?></span>
                                                        <label class="label <?php echo $theme['activated'] === lang('text_active') ? 'label-success' : 'label-default'; ?>"><?php echo $theme['activated']; ?></label>
                                                    </div>

                                                    <div class="btn-group">
                                                        <button class="btn btn-primary" type="button" onclick="theme.select(this);" data-item="<?php echo $theme['theme_name']; ?>">
                                                            <i class="icon ion-star"></i> <?php echo lang('text_enable') ?>
                                                        </button>
                                                        <button class="btn btn-info" type="button">
                                                            <i class="icon ion-eye"></i> <?php echo lang('text_preview') ?>
                                                        </button>
                                                        <button class="btn btn-warning" type="button" onclick="theme.delete(this);" data-item="<?php echo $theme['theme_path']; ?>">
                                                            <i class="icon ion-trash-a"></i> <?php echo lang('text_delete') ?>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                        <div class="add-theme col-md-4">
                                            <a href="<?php echo site_url('admin/theme/theme/add'); ?>">
                                                <div class="icon"><i class="icon ion-plus-circled"></i></div>
                                                <div class="caption">
                                                    <div class="theme-name">
                                                        <span><?php echo lang('text_add_theme') ?></span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<script type="text/javascript">
    var baseUrl = '<?= base_url() ?>';
    var saveThemeUrl = baseUrl + 'admin/theme/theme/ajax_save_theme/';
    var deleteThemeUrl = baseUrl + 'admin/theme/theme/ajax_delete_theme/';

    var theme = {
        'select': function(elm) {
            var me = $(elm);
            $.ajax({
                url: saveThemeUrl,
                type: 'post',
                data: {
                    active_theme: me.attr('data-item')
                },
                success: function() {
                    window.location.reload();
                }
            });
        },
        'delete': function(elm) {
            var me = $(elm);
            if (confirm('Are you sure you want to delete this?')) {
                $.ajax({
                    url: deleteThemeUrl,
                    type: 'post',
                    data: {
                        delete_theme: me.attr('data-item')
                    },
                    success: function() {
                        window.location.reload();
                    }
                });
            }
        }
    }
</script>