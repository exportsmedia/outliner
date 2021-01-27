<?php
/** Outliner - Compact List Outlining
* @link https://github.com/exportsmedia/outliner
* @author Michael Markoski, https://exportsmedia.com
* @copyright 2020 Michael Markoski
* @license https://opensource.org/licenses/MIT
* @version 0.0.1
*/
?>
<!doctype html>
<html lang="en">

<?php
$files = get_file_names();
$outlineItem = isset($_GET['outline']) ? (int) $_GET['outline'] : (isset($files[0]['id']) ? (int) $files[0]['id']: 0);
$currentItem = get_item($outlineItem);

$parsed = myParse($currentItem['content'], '    ');
// remove title from first line, reset keys, and move array up one level
unset($parsed[0]);
$parsed = array_values($parsed);
if(!empty($parsed[0])) {
    $parsed = $parsed[0];
} else {
    $parsed = ["" => ""];
}



//echo "<pre>", print_r($parsed,1), "</pre>";

?>

<head>
    <meta charset="utf-8">
    <title>Outliner</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="materialdesignicons.min.css">
    <link rel="stylesheet" href="app.css">

</head>

<body>

    <div class="list-manager">
        <div class="left-bar">
            <section class="upper-part">
                <div class="actions">
                    <div class="circle-2"></div>
                </div>
            </section>
            <section class="left-content">
                <h1>
                    <a href="/" title="My Outlines">
                        My Outlines
                        <svg id="add-new" style="width:24px;height:24px" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M19,19V5H5V19H19M19,3A2,2 0 0,1 21,5V19A2,2 0 0,1 19,21H5A2,2 0 0,1 3,19V5C3,3.89 3.9,3 5,3H19M11,7H13V11H17V13H13V17H11V13H7V11H11V7Z" />
                        </svg>
                    </a>
                </h1>
                <ul class="action-list">
                    <?php if(!empty($files)) { ?>
                        <?php foreach($files as $file) { ?>
                        <li class="item <?php echo check_active_link( $file['id'], $outlineItem); ?>">
                            <a href="/?outline=<?php echo $file['id']; ?>">
                                <i class="mdi mdi-file-document-outline"></i>
                                <?php echo $file['title']; ?>
                            </a>
                        </li>
                        <?php } ?>
                    <?php } ?>
                </ul>
                <ul class="category-list">
                    <li class="item">
                        <a href="#" id="settings">
                            <i class="mdi mdi-cog"></i>
                            Settings
                        </a>
                    </li>
                </ul>
            </section>
        </div>
        <div class="page-content">
            <div class="header" contenteditable="true"><?php echo $currentItem['title']; ?></div>
            <div class="outline-content">
                <?php displayArrayRecursively($parsed); ?>
            </div>
        </div>
    </div>

    <script src="jquery-3.5.1.min.js"></script>
    <script src="app.js"></script>
</body>

</html>


<?php


function check_active_link( int $item, int $outlineItem ) {
    if($item == $outlineItem) {
        return "active";
    }
}

function get_file_names() {
    $path = 'outlines';
    $files = scandir($path);
    $files = array_diff(scandir($path), array('.', '..'));
    $outlines = [];
    if(!empty($files)) {
        foreach($files as $file) {
            $parts = explode("-", $file, 2);
            $outlines[] = [
                'id' => (int) $parts[0],
                'title' => get_outline_title("outlines/" . $file),
            ];
        }
    }
    return $outlines;
}

function convert_name_to_nice( string $name ) {
    return ucwords(str_replace("-", " ", substr($name, 0, -4)));
}

function get_outline_title( $path ) {
    return fgets(fopen($path, 'r'));
}

function get_item( int $id ) {
    $files = array_values(preg_grep('~^'.$id.'-.*\.txt$~', scandir("outlines")));
    if(empty($files)) {
        return;
    }
    $rawContents = file("outlines/" . $files[0]);
    return [
        'title' => get_outline_title("outlines/" . $files[0]),
        'content' => $rawContents,
    ];
}


/**
* Sanitizes a filename replacing whitespace with dashes
*
* Removes special characters that are illegal in filenames on certain
* operating systems and special characters requiring special escaping
* to manipulate at the command line. Replaces spaces and consecutive
* dashes with a single dash. Trim period, dash and underscore from beginning
* and end of filename.
*
* @link https://developer.wordpress.org/reference/functions/sanitize_file_name/
* @param string $filename The filename to be sanitized
* @return string The sanitized filename

*/
function sanitize_file_name( $filename ) {
    $special_chars = array("?", "[", "]", "/", "\\", "=", "<", ">" , ":" , ";" , "," , "'" , "\"", " &", "$" , "#" , "*", "(" , ")" , "|" , "~" , "`" , "!" , "{" , "}" );  
    $filename=str_replace($special_chars, '' , $filename);
    $filename=preg_replace('/[\s-]+/', '-' , $filename); $filename=trim($filename, '.-_' ); 
    return strtolower($filename); 
}


// Turn formatted file in to PHP array
// https://stackoverflow.com/a/17016078/8034588
/**
* Recognising level of current header and header itself by counting prefixes
* before header
* @param string $string
* @param string $prefix
* @param &int $level
* @param &string $header
*/
function myGetLevelAndHeader($string, $prefix, &$level, &$header) {
    preg_match('/^((?:' . preg_quote($prefix) . ')*)(.*)$/', $string, $match);
    $header = $match[2];
    $level = strlen($match[1]) / strlen($prefix);
}

/**
* Adding to headers array to the desired dimension without recursion
* @param &array $headers ere
* @param integer $level
* @param string $header
*/
function myAddToHeaders(array &$headers, $level, $header) {
    $array = &$headers;
    while ($level--) {
        //adding new dimension
        is_null($array) ? $array = array() : end($array);

        $last_key = key($array);
        if (!is_null($last_key) && is_array($array[$last_key])) {
            $array = &$array[$last_key]; // going deeper
        } else {
            $array = &$array[]; // create new element and going deeper
        }
    }  
    $array[] = $header;
}

/**
* Simple parsing function
* @param array $lines
* @param string $prefix
* @return array
*/
function myParse(array $lines, $prefix = ' ') {
    $headers = array();
    foreach ($lines as $line) {
        myGetLevelAndHeader($line, $prefix, $level, $header);
        myAddToHeaders($headers, $level, $header);
    }
    return $headers;
}


// Turn formatted file in to PHP array
// https://stackoverflow.com/a/17016078/8034588
/**
* Recursive function to display members of array with indentation
*
* @param array $arr Array to process
* @param string $indent indentation string
*/
function displayArrayRecursively($arr) {
    if ($arr) {
        foreach ($arr as $value) {
            if (is_array($value)) {
                //
                echo '<div class="node node-children">';
                displayArrayRecursively($value);
                echo '</div>';
            } else {
                // Output

                echo '<div class="node node-self">';
                echo '<a class="node-link bullet mdi mdi-checkbox-blank-circle" tabindex="-1" title="Created at 8:36:31 PM on 10/24/2018, last edited at 8:36:31 PM on 10/24/2018" href="#"></a>';
                echo '<div class="node-line" contenteditable="true">';
                echo "$value";
                echo '</div>';
                echo '</div>';
            }
        }
    }
}
