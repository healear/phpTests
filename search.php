<?php
function read_dir($dir)
{
    $files = array();
    if (is_dir($dir) AND ($handle = opendir($dir)))
    {
        while (false !== ($fname = readdir($handle)))
        {
            if ($fname != "." && $fname != "..") {
                $files[$fname] = filetype($dir.$fname);
            }
        }
        closedir($handle);
    }
    return $files;
}

function DFS($dir, ?int &$count)
{
    echo "Entry point: ".$dir."\n";
    if (NULL === $count)
        $count = 0;
    $files = read_dir($dir);
    foreach ($files as $fname=>$ftype)
    {
        echo "Elem: ".$fname."\n";
        echo "Type: ".$ftype."\n\n";
        if ($ftype == "dir")
            {
                DFS($dir.$fname."/", $count);
            }
        else
            if ($fname == "test")
            {
                $values = file($dir.$fname);
                if (!empty($values))
                    foreach ($values as $value)
                    {
                        echo "Value: ".$value."\n";
                        $count+=$value;
                    }
            }
    }
    return $count;
}

$count = 0;
$files = read_dir("conts/contsinclude/");
echo DFS("conts/", $count);