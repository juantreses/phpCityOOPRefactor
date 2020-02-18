Installing PHP Unit
===================

Installation in the root folder
---------------------------------
* First check if you have composer  is installed on your machine
* test this by typing ` composer -V ` in your CLI
if you need to install composer:
https://getcomposer.org/download/
* Install php unit:
    * i made a litle program that wil install (or update)php unit in this folder
    and creates a alias for testing the software
    * if you wont to run the code yourself: `composer require --dev phpunit/phpunit
                                             echo @php "%~dp0vendor\phpunit\phpunit\phpunit" %*> phpunit.cmd`
    * go to the root folder of the project and open de CLI
    *run this command: `phpunitinstall.sh`
    
* system settings (php.ini):   
    >To use the IDE debugger change the php.ini: 
                                 
    [XDebug]  
    ; Only Zend OR (!) XDebug (in comment)  
    zend_extension="C:/Bitnami/wampstack-7.3.13-0/php\ext\php_xdebug.dll"
    xdebug.remote_enable=true
    xdebug.remote_host=127.0.0.1
    xdebug.remote_port=9000
    xdebug.remote_handler=dbgp
    xdebug.profiler_enable=1
    xdebug.profiler_output_dir=C:\Windows\Temp
    

 
running the test
---------------
> U can use the comand line or the IDE debugger  
*  CLI:  
    * Tests wil be written in the folder tests
    * open explorer and go to the root folder of this project. select the directory path and type cmd, then press enter
    * your CLI wil open in this dir.
    * in de CLI type: `phpunit tests\ExamoleTest.php` so: the folder and class you want to run
* IDE
    * run the test by clicking on the green arrows in the testclass file and choose your options