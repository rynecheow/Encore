echo -e "\e[32mDump assets..."
php app/console assetic:dump
php app/console assets:install --symlink
echo -e "\e[32mDone."
tput sgr0 