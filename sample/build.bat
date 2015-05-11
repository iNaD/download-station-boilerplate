:: Delete old data
del HOSTER.host

:: get recent version of the provider base class
copy /Y ..\provider-boilerplate\src\provider.php provider.php

:: create the .tar.gz
7z a -ttar -so HOSTER INFO HOSTER.php provider.php | 7z a -si -tgzip HOSTER.host

del provider.php