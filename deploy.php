<?php

require 'recipe/symfony3.php';

set('repository', 'git@github.com:luklewluk/gamespoint.git');
set('shared_files', ['app/config/parameters.yml']);
set('shared_dirs', ['var/logs']);
set('writable_dirs', ['var/cache', 'var/logs', 'var/sessions']);
set('keep_releases', 3);
set('writable_use_sudo', false);

serverList('servers.yml');

