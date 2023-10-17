<?php echo '<?xml version="1.0" encoding="utf-8"?>' . "\n"; ?>
<rss version="2.0"
xmlns:dc="http://purl.org/dc/elements/1.1/"
xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
xmlns:admin="http://webns.net/mvcb/"
xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
xmlns:media="http://search.yahoo.com/mrss/"
xmlns:content="http://purl.org/rss/1.0/modules/content/">

    <channel>
        <title><?php echo $feed_name; ?></title>
        <link><?php echo $feed_url; ?></link>
        <description><?php echo $page_description; ?></description>
        <dc:language><?php echo $page_language; ?></dc:language>
        <dc:creator><?php echo $creator_email; ?></dc:creator>

        <dc:rights>Copyright <?php echo gmdate("Y", time()); ?></dc:rights>
        <admin:generatorAgent rdf:resource="<?php echo base_url(); ?>" />

        <?php foreach($blogs as $blog) : ?>
            <item>
                <title><?php echo $blog['title']; ?></title>
                <link><?php echo $blog['url']; ?></link>
                <guid><?php echo $blog['url']; ?></guid>
                <pubDate><?php echo date('l, F d, Y h:i A', strtotime($blog['date_published']));?></pubDate>
                <description>
                    <![CDATA[
                        <?php echo html_entity_decode(substr($blog['content'],0, 800 )) . '...'; ?>
                        <p xml:base="<?php echo base_url('feed'); ?>">This article is copyright &copy; <?php echo date('Y'); ?>&nbsp; <a href="<?php echo base_url(); ?>"><?php echo base_url(); ?></a></p>
                    ]]>
                </description>
            </item>
        <?php endforeach; ?>
    </channel>
</rss>