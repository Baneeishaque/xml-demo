 <?php
$a = parse_xml(file_get_contents('strings.xml'));
print_r ($a);

function parse_xml($xml_file_contents = '') {
    // remove whitespace and return carriages in between tags
    $xml_file_contents = preg_replace("#\>((\n|\r)\s+)\<#","><",$xml_file_contents);
    // remove any left over return carriages and tabs
    $xml_file_contents = preg_replace("#\n|\r|\t#","",$xml_file_contents);
    // remove comments
    $xml_file_contents = preg_replace("#\<\!\-(.*?)\-\>#","",$xml_file_contents);
    // explode the data
    $xml_explode = explode('><',$xml_file_contents);
    $xml_data = [];
    foreach ($xml_explode as &$line) {
        $line = trim($line);
        $line = preg_replace('#^\<|\>$#','',$line);
        $line = sprintf("<%s>",$line);
        if (preg_match('#\>.*?\<#',$line,$matches)) {
            // valid
            $xml_data[] = json_decode(json_encode(simplexml_load_string($line)),true);
        }
    }
    return $xml_data;
}
?>