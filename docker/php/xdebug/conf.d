; Xdebug
; See https://xdebug.org/docs/all_settings

zend_extension=xdebug
;PHPStorm
[xdebug]
xdebug.mode=develop, debug
xdebug.start_with_request=yes
xdebug.discover_client_host=0
xdebug.client_host=host.docker.internal
xdebug.log=/var/log/xdebug/xdebug.log