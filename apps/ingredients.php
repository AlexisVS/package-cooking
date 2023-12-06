<?php
// the dispatcher (index.php) is in charge of setting the context and should include the equal library
defined('__equal_LIB') or die(__FILE__ . ' cannot be executed directly.');

// we'll need to format some dates
load_class('utils/DateFormatter');

// get the value of the ingredient_id parameter (set it to 1 if not present), and put it in the $params array
$params = get_params(array('ingredient_id' => 1));

/*
* A small html parser that replaces 'var' tags with their associated content.
*
* @param string $template    the full html code of a page, containing var tags to be replaced by content
* @param function $decorator    the function to use in order to return html code matching a var tag
*/
function decorate_template($template, $decorator)
{
    $previous_pos = 0;
    $html = '';
    // use regular expression to locate all 'var' tags in the template
    preg_match_all("/<var([^>]*)>.*<\/var>/iU", $template, $matches, PREG_OFFSET_CAPTURE);
    // replace 'var' tags with their associated content
    for ($i = 0, $j = count($matches[1]); $i < $j; ++$i) {
        // 1) get tag attributes
        $attributes = array();
        $args = explode(' ', ltrim($matches[1][$i][0]));
        foreach ($args as $arg) {
            if (!strlen($arg)) continue;
            list($attribute, $value) = explode('=', $arg);
            $attributes[$attribute] = str_replace('"', '', $value);
        }
        // 2) get content pointed by var tag, replace tag with content and build resulting html
        $pos = $matches[0][$i][1];
        $len = strlen($matches[0][$i][0]);
        $html .= substr($template, $previous_pos, ($pos - $previous_pos)) . $decorator($attributes);
        $previous_pos = $pos . $len;
    }
    // add trailer
    $html .= substr($template, $previous_pos);
    return $html;
}

/**
 * Returns html part specified by $attributes (from a 'var' tag) and associated with current post id
 * (here come the calls to equal API)
 *
 * @param array $attributes
 * @return string
 */
$get_html = function (array $attributes) {
    global $params;
    $html = "<h1>hello world</h1>";
//    switch ($attributes['id']) {
//        case 'name':
//            if (is_int($post_values = &browse('cooking\Ingredient', [$params['ingredient_id']], ['id', 'created', 'name', 'description'])) break;
//            $name = $post_values[$params['ingredient_id']]['name'];
//            $description = $post_values[$params['ingredient_id']]['description'];
//            $dateFormatter = new DateFormatter();
//            $dateFormatter->setDate($post_values[$params['ingredient_id']]['created'], DATE_TIME_SQL);
//            $date = ucfirst(strftime("%A %d %B %Y", $dateFormatter->getTimestamp()));
//            $html = "
//                <h2 class=\"title\">$name</h2>
//                <div class=\"meta\"><p>$date</p></div>
//                <div class=\"entry\">$description</div>
//            ";
//            break;
//        case 'recent_posts':
//            $ids = search('blog\Post', array(array(array())), 'created', 'desc', 0, 5);
//            $recent_values = &browse('blog\Post', $ids, array('id', 'title'));
//            foreach ($recent_values as $values) {
//                $name = $values['title'];
//                $id = $values['id'];
//                $html .= "<li><a href=\"index.php?show=blog_display&ingredient_id={$id}\">$name</a></li>";
//            }
//            break;
//    }
    return $html;
};

//` if we got the ingredient_id and if the template file can be found, read the template and decorate it with current post values
if (!is_null($params['ingredient_id']) && file_exists('packages/blog/html/template.html'))
    print(decorate_template(file_get_contents('packages/blog/html/template.html'), $get_html));
