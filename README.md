# При звертанні до curl.php, вказуємо змінні GET
link: http://test.ihousesmart.com/curl.php

* method= p - POST, g - GET 
* form= y - відправка форми, n - без форми
* formdata[ключ без скобок]= змінна (необмежена кількість) - передача input
* dest= http://yousite.com/ - лінк до якого будемо звертатись
* cookie= my=123 - передача cookie

Відправка cUrl на http://test.ihousesmart.com/enter.php ,отримуємо у відповідь: 
# Відправляємо GET:
GET /curl.php?method=g&amp;form=y&amp;formdataname=hi&amp;formdatadescription=mynameis&amp;dest=http://test.ihousesmart.com/enter.php&amp;cookie=my=123 HTTP/1.1
Host: test.ihousesmart.com
Cache-Control: no-cache
Postman-Token: bf858aa0-0acb-429a-a522-264d694b39c9

# Відповідь:
cookie: 123
method: GET
name: hi
description: mynameis

# Відправляємо POST:
POST /curl.php?method=p&amp;form=y&amp;formdataname=hi&amp;formdatadescription=mynameis&amp;dest=http://test.ihousesmart.com/enter.php&amp;cookie=my=123 HTTP/1.1
Host: test.ihousesmart.com
Cache-Control: no-cache
Postman-Token: bc0230b4-797a-a399-6848-bf7e8030f246
Content-Type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW

# Відповідь:
cookie: 123
method: POST
name: hi
description: mynameis


