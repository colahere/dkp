# dkp
测试dkp

sudo -H -u www-data bash -c 'php artisan down'

sudo -H -u www-data bash -c 'composer require dkp/csqy-dkp'

sudo -H -u www-data bash -c 'php artisan vendor:publish --force --all'

sudo -H -u www-data bash -c 'php artisan migrate'

sudo -H -u www-data bash -c 'php artisan route:cache'

sudo -H -u www-data bash -c 'php artisan config:cache'

sudo -H -u www-data bash -c 'php artisan seat:cache:clear'

sudo -H -u www-data bash -c 'php artisan up'

