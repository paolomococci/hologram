# Composer setup

If you want to add support to Composer, dependency manager for PHP, it is best to follow the instructions offered on the official website under the heading `download`.

## small inconvenience found with `Xdebug`

To minimize the verbosity of debug messages when using PHP from the command line you can use the following `Xdebug` settings on `php.ini` configuration file:

```text
...
;;;;;;;;;;;;;;;;;;
; Xdebug         ;
;;;;;;;;;;;;;;;;;;

zend_extension=xdebug

; xdebug.mode=[off,develop,coverage,debug,gcstats,profile,trace]

xdebug.mode=debug,trace
xdebug.start_with_request=trigger
xdebug.discover_client_host=1
xdebug.remote_enable=1
xdebug.client_host=192.168.122.1
xdebug.client_port=9003
xdebug.connect_timeout_ms=2000
xdebug.idekey=VSCODE
;xdebug.log_level=0
...
``` 
