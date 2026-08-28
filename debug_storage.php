<?php
$p = 'public/storage';
echo "File exists: " . (file_exists($p) ? 'YES' : 'NO') . "\n";
if (file_exists($p)) {
    echo "Is link: " . (is_link($p) ? 'YES' : 'NO') . "\n";
    echo "Is dir: " . (is_dir($p) ? 'YES' : 'NO') . "\n";
    echo "Link target: " . (is_link($p) ? readlink($p) : 'N/A') . "\n";
}
echo "Real path storage/app/public: " . realpath('storage/app/public') . "\n";
