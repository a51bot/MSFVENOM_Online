This project probably exists somewhere else and definitly is not production code.  
Seriously ****DONT RUN THIS ON A WEB FACING SERVER****

The idea is why cant I have a easy way to run msfvenom without having to remember the exact syntax

Anyway do whatever you want with the code, but I am not responsible for doing something stupid.


PRE REQS
1. LAMP Server (Apache/nginx & php)
2. Metasploit


INSTALL
1. Install a lamp server, you just need php and apache/nginx
2. git clone ... /var/www/html/
3. install metasploit https://www.rapid7.com/products/metasploit/download.jsp and make sure you can run msfvenom
4. (now the sketchy part) visudo /etc/sudoers allow the www-data user to run msfvenom as root
5. enjoy :)

