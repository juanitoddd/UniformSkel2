<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?php echo Router::url('/',true); ?></loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    <!-- static pages -->
    <?php //foreach ($pages as $page):?>
        <!--<url>
            <loc><?php //echo Router::url(array('controller'=>'pages','action'=>'index',"slug"=>Inflector::slug($post["Page"]["slug"],"-"),'ext'=>'html'),true); ?></loc>
            <lastmod><?php //echo $this->Time->toAtom($post['Page']['modified']); ?></lastmod>
            <priority>0.8</priority>
        </url>-->
    <?php //endforeach; ?>
    <!-- posts-->
    <?php //foreach ($garages as $garage):?>
        <!--<url>
            <loc><?php //echo Router::url(array('controller'=>'garages','action'=>'view','id'=>$garage['Garage']['id'],"slug"=>Inflector::slug($garage['Garage']['id'],"-"),'ext'=>'html'),true); ?></loc>
            <loc><?php //echo Configure::read('domain.app'); ?></loc>
            <lastmod><?php //echo $this->Time->toAtom($garage['Garage']['modified']); ?></lastmod>
            <priority>0.8</priority>
        </url>-->
    <?php //endforeach; ?>
</urlset>