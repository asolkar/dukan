<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_DEFAULT);

  require(DIR_WS_INCLUDES . 'template_top.php');
?>
<link rel="stylesheet"
      type="text/css"
      href="http://look.mahesha.com/ext/jquery/lofslidernews/css/style6.css" />
<script language="javascript"
        type="text/javascript"
        src="http://look.mahesha.com/ext/jquery/lofslidernews/js/jquery.easing.js"></script>
<script language="javascript"
        type="text/javascript"
        src="http://look.mahesha.com/ext/jquery/lofslidernews/js/script.js"></script>

<script type="text/javascript">
$(document).ready( function(){
  var buttons = { previous  : $('#lofslidecontent45 .lof-previous') ,
                  next      : $('#lofslidecontent45 .lof-next') };

  $obj = $('#lofslidecontent45').lofJSidernews( {
    interval        : 6000,
    easing          : 'easeInOutQuad',
    duration        : 1200,
    auto            : false,
    maxItemDisplay  : 5,
    mainWidth       : 950,
    navPosition     : 'horizontal', // horizontal
    navigatorHeight : 15,
    navigatorWidth  : 25,
    buttons         : buttons} );
});
</script>
<style>
ul.lof-main-wapper li {
  position:relative;
  display: inline;
}
</style>

<?php
  if ( (!isset($new_products_category_id)) || ($new_products_category_id == '0') ) {
    $new_products_query =
      tep_db_query("select  p.products_id,
                            p.products_image,
                            p.products_tax_class_id,
                            pd.products_name,
                            if( s.status,
                                s.specials_new_products_price,
                                p.products_price)
                            as products_price
                            from " . TABLE_PRODUCTS .
                              " p left join " . TABLE_SPECIALS .
                              " s on p.products_id = s.products_id, " .
                              TABLE_PRODUCTS_DESCRIPTION . " pd
                            where p.products_status = '1' and
                                  p.products_id = pd.products_id and
                                  pd.language_id = '" . (int)$languages_id . "'
                            order by p.products_date_added desc
                            limit " . MAX_DISPLAY_NEW_PRODUCTS);
  } else {
    $new_products_query =
      tep_db_query("select distinct p.products_id,
                                    p.products_image,
                                    p.products_tax_class_id,
                                    pd.products_name,
                                    if( s.status,
                                        s.specials_new_products_price,
                                        p.products_price)
                                    as products_price
                                    from " . TABLE_PRODUCTS .
                                      " p left join " . TABLE_SPECIALS .
                                      " s on p.products_id = s.products_id, " .
                                      TABLE_PRODUCTS_DESCRIPTION . " pd, " .
                                      TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " .
                                      TABLE_CATEGORIES . " c
                                    where p.products_id = p2c.products_id and
                                          p2c.categories_id = c.categories_id and
                                          c.parent_id = '" . (int)$new_products_category_id . "' and
                                          p.products_status = '1' and
                                          p.products_id = pd.products_id and
                                          pd.language_id = '" . (int)$languages_id . "'
                                    order by p.products_date_added desc
                                    limit " . MAX_DISPLAY_NEW_PRODUCTS);
  }

  $num_new_products = tep_db_num_rows($new_products_query);

  if ($new_products_query > 0) {
    $counter = 0;
    $nav_counter = 0;

    //
    // Generating New Products Content (npc)
    //
    $npc = '<div id="lofslidecontent45" class="lof-slidecontent grid_24" style="height:340px;margin: 2.5em 0 2.5em 0;"><div class="preload"><div></div></div> <div class="lof-main-outer grid_24 alpha omega" style="height:340px;">' . "\n";
    $npc .= '    <div onclick="return false" href="" class="lof-previous">Previous</div>' . "\n";
    $npc .= '<ul class="lof-main-wapper">' . "\n";
    while ($new_products = tep_db_fetch_array($new_products_query)) {
      $counter++;

      $npc .= '<li class="grid_24 alpha omega">' . tep_image(DIR_WS_IMAGES . $new_products['products_image'], $new_products['products_name'], "950px", "340px"). "\n";
      $npc .= '<div class="lof-main-item-desc grid_24 alpla omega">' . "\n";
      $npc .= '  <h3 class="grid_20"><a target="_parent" title="Newsflash ' . $counter . '" href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $new_products['products_id']) . '">' . $new_products['products_name'] . '</a> <i>' . $currencies->display_price($new_products['products_price'], tep_get_tax_rate($new_products['products_tax_class_id'])) . '</i></h3>' . "\n";
      $npc .= '  <h2 class="grid_20">Content of Newsflash  ' . $counter . '</h2>' . "\n";
      $npc .= '  <p class="grid_20">The one thing about a Web site, it always changes! Joomla! makes it easy to add Articles, content,...' . "\n";
      $npc .= '  <a class="readmore" href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $new_products['products_id']) . '">Read more </a>'. "\n";
      $npc .= "  </p>\n";
      $npc .= "</div>\n";
      $npc .= "</li>\n";
    }

    $npc .= "</ul>\n";
    $npc .= '<div onclick="return false" href="" class="lof-next">Next</div>' . "\n";
    $npc .= "</div>\n";

    $npc .= "<div class=\"lof-navigator-wapper\">\n";
    $npc .= "  <div class=\"lof-navigator-outer\">\n";
    $npc .= "    <ul class=\"lof-navigator\">\n";
    while ($nav_counter < $counter) {
      $nav_counter++;
      $npc .= "      <li><span>" . $nav_counter . "</span></li>\n";
    }
    $npc .= "    </ul>\n";
    $npc .= "  </div>\n";
    $npc .= "</div>\n";
?>

  <div class="contentText grid_24 alpha omega">
    <?php echo $npc; ?>
  </div></div>
<?php
  }

  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
