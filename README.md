# Login project

### Installation

git clone https://github.com/torrodo/login.git

cd login  
make install

When configuring parameters, please enter the following values:


Creating the "app/config/parameters.yml" file 
Some parameters are missing. Please provide them.  
database_driver (pdo_mysql): 
database_host (127.0.0.1):   
database_port (null): 
database_name (symfony): login_project  
database_user (root): root  
database_password (null):  
mailer_transport (smtp):  
mailer_host (127.0.0.1):  
mailer_user (null):   
mailer_password (null): 


### Usage

To test, just start the built in server from the project root:

php app/console server:start

###### Links:  

http://127.0.0.1:8000/ => homepage, authentication requierd  
http://127.0.0.1:8000/admin => admin page, admin authentication requierd  
http://127.0.0.1:8000/user/login => login page  
http://127.0.0.1:8000/user/logout => logout page  
http://127.0.0.1:8000/user/register => sign-up page  

###### Users:  

user: test / password: test => common user  
user: admin / password: admin => admin user  