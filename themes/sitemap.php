<?php header('Content-type: text/xml'); ?>
<?php echo '<?xml version="1.0" encoding="UTF-8" ?>' ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xhtml="http://www.w3.org/1999/xhtml">

    <!-- Home -->
    <?php if($home) : foreach($home as $url) { ?>
    <url>
        <loc><?php echo $url['main_url']; ?></loc>
        <?php foreach ($url['alt_url'] as $key => $alt_url) { ?>
        <xhtml:link
            rel="alternate"
            hreflang="<?php echo $alt_url['language_code'] ?>"
            href="<?php echo base_url() . $alt_url['language_code'] ?>"
        />
        <?php } ?>
        <priority>1.0</priority>
    </url>
    <?php } endif; ?>

    <!-- Blog -->
    <?php if($posts) : foreach($posts as $post) { ?>
    <url>
        <loc><?php echo $post['main_url']; ?></loc>
        <?php foreach ($post['alt_url'] as $key => $alt_url) { ?>
        <xhtml:link
            rel="alternate"
            hreflang="<?php echo $alt_url['language_code'] ?>"
            href="<?php echo site_url($alt_url['language_code'] . '/blog' . '/' . $alt_url['slug'], TRUE)?>"
        />
        <?php } ?>
        <priority>0.8</priority>
    </url>
    <?php } endif; ?>

    <!-- Page -->
    <?php if($pages) : foreach($pages as $page) { ?>
    <url>
        <loc><?php echo $page['main_url']; ?></loc>
        <?php foreach ($page['alt_url'] as $key => $alt_url) { ?>
        <xhtml:link
            rel="alternate"
            hreflang="<?php echo $alt_url['language_code'] ?>"
            href="<?php echo site_url($alt_url['language_code'] . '/page' . '/' . $alt_url['slug'], TRUE)?>"
        />
        <?php } ?>
        <priority>0.5</priority>
    </url>
    <?php } endif; ?>

    <!-- Category -->
    <?php if($categories) : foreach($categories as $category) { ?>
    <url>
        <loc><?php echo $category['main_url']; ?></loc>
        <?php foreach ($category['alt_url'] as $key => $alt_url) { ?>
        <xhtml:link
            rel="alternate"
            hreflang="<?php echo $alt_url['language_code'] ?>"
            href="<?php echo site_url($alt_url['language_code'] . '/blog/category' . '/' . $alt_url['slug'], TRUE)?>"
        />
        <?php } ?>
        <priority>0.5</priority>
    </url>
    <?php } endif; ?>

    <!-- Tag -->
    <?php if($tags) : foreach($tags as $tag) { ?>
    <url>
        <loc><?php echo $tag['main_url']; ?></loc>
        <priority>0.5</priority>
    </url>
    <?php } endif; ?>

</urlset>