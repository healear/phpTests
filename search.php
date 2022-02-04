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

function DFS($dir, int &$count)
{
    $files = read_dir($dir);
    foreach ($files as $fname=>$ftype)
    {
        if ($ftype == "dir")
            {
                DFS($dir.$fname."/", $count);
            }
        else
            if ($fname == "count")
            {
                $values = file($dir.$fname);
                if (!empty($values))
                    foreach ($values as $value)
                    {
                        $count+=$value;
                    }
            }
    }
    return $count;
}

$count = 0;
echo DFS("conts/", $count);