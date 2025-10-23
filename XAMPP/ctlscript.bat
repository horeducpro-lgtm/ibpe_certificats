@echo off
rem START or STOP Services
rem ----------------------------------
rem Check if argument is STOP or START

if not ""%1"" == ""START"" goto stop

if exist D:\bitap\IBPE\code\XAMPP\hypersonic\scripts\ctl.bat (start /MIN /B D:\bitap\IBPE\code\XAMPP\server\hsql-sample-database\scripts\ctl.bat START)
if exist D:\bitap\IBPE\code\XAMPP\ingres\scripts\ctl.bat (start /MIN /B D:\bitap\IBPE\code\XAMPP\ingres\scripts\ctl.bat START)
if exist D:\bitap\IBPE\code\XAMPP\mysql\scripts\ctl.bat (start /MIN /B D:\bitap\IBPE\code\XAMPP\mysql\scripts\ctl.bat START)
if exist D:\bitap\IBPE\code\XAMPP\postgresql\scripts\ctl.bat (start /MIN /B D:\bitap\IBPE\code\XAMPP\postgresql\scripts\ctl.bat START)
if exist D:\bitap\IBPE\code\XAMPP\apache\scripts\ctl.bat (start /MIN /B D:\bitap\IBPE\code\XAMPP\apache\scripts\ctl.bat START)
if exist D:\bitap\IBPE\code\XAMPP\openoffice\scripts\ctl.bat (start /MIN /B D:\bitap\IBPE\code\XAMPP\openoffice\scripts\ctl.bat START)
if exist D:\bitap\IBPE\code\XAMPP\apache-tomcat\scripts\ctl.bat (start /MIN /B D:\bitap\IBPE\code\XAMPP\apache-tomcat\scripts\ctl.bat START)
if exist D:\bitap\IBPE\code\XAMPP\resin\scripts\ctl.bat (start /MIN /B D:\bitap\IBPE\code\XAMPP\resin\scripts\ctl.bat START)
if exist D:\bitap\IBPE\code\XAMPP\jetty\scripts\ctl.bat (start /MIN /B D:\bitap\IBPE\code\XAMPP\jetty\scripts\ctl.bat START)
if exist D:\bitap\IBPE\code\XAMPP\subversion\scripts\ctl.bat (start /MIN /B D:\bitap\IBPE\code\XAMPP\subversion\scripts\ctl.bat START)
rem RUBY_APPLICATION_START
if exist D:\bitap\IBPE\code\XAMPP\lucene\scripts\ctl.bat (start /MIN /B D:\bitap\IBPE\code\XAMPP\lucene\scripts\ctl.bat START)
if exist D:\bitap\IBPE\code\XAMPP\third_application\scripts\ctl.bat (start /MIN /B D:\bitap\IBPE\code\XAMPP\third_application\scripts\ctl.bat START)
goto end

:stop
echo "Stopping services ..."
if exist D:\bitap\IBPE\code\XAMPP\third_application\scripts\ctl.bat (start /MIN /B D:\bitap\IBPE\code\XAMPP\third_application\scripts\ctl.bat STOP)
if exist D:\bitap\IBPE\code\XAMPP\lucene\scripts\ctl.bat (start /MIN /B D:\bitap\IBPE\code\XAMPP\lucene\scripts\ctl.bat STOP)
rem RUBY_APPLICATION_STOP
if exist D:\bitap\IBPE\code\XAMPP\subversion\scripts\ctl.bat (start /MIN /B D:\bitap\IBPE\code\XAMPP\subversion\scripts\ctl.bat STOP)
if exist D:\bitap\IBPE\code\XAMPP\jetty\scripts\ctl.bat (start /MIN /B D:\bitap\IBPE\code\XAMPP\jetty\scripts\ctl.bat STOP)
if exist D:\bitap\IBPE\code\XAMPP\hypersonic\scripts\ctl.bat (start /MIN /B D:\bitap\IBPE\code\XAMPP\server\hsql-sample-database\scripts\ctl.bat STOP)
if exist D:\bitap\IBPE\code\XAMPP\resin\scripts\ctl.bat (start /MIN /B D:\bitap\IBPE\code\XAMPP\resin\scripts\ctl.bat STOP)
if exist D:\bitap\IBPE\code\XAMPP\apache-tomcat\scripts\ctl.bat (start /MIN /B /WAIT D:\bitap\IBPE\code\XAMPP\apache-tomcat\scripts\ctl.bat STOP)
if exist D:\bitap\IBPE\code\XAMPP\openoffice\scripts\ctl.bat (start /MIN /B D:\bitap\IBPE\code\XAMPP\openoffice\scripts\ctl.bat STOP)
if exist D:\bitap\IBPE\code\XAMPP\apache\scripts\ctl.bat (start /MIN /B D:\bitap\IBPE\code\XAMPP\apache\scripts\ctl.bat STOP)
if exist D:\bitap\IBPE\code\XAMPP\ingres\scripts\ctl.bat (start /MIN /B D:\bitap\IBPE\code\XAMPP\ingres\scripts\ctl.bat STOP)
if exist D:\bitap\IBPE\code\XAMPP\mysql\scripts\ctl.bat (start /MIN /B D:\bitap\IBPE\code\XAMPP\mysql\scripts\ctl.bat STOP)
if exist D:\bitap\IBPE\code\XAMPP\postgresql\scripts\ctl.bat (start /MIN /B D:\bitap\IBPE\code\XAMPP\postgresql\scripts\ctl.bat STOP)

:end

