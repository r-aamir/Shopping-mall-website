#shopping

##Cấu hình project
###1. Các package php cần thiết:
sudo apt install php-mbstring

sudo apt install php-mcrypt

###2. Cấu hình Database:
- Mở thư mục config/autoload
- Tạo file local.php theo mẫu ở file local.php.dist
- Tạo file development.local.php theo mẫu ở file development.local.php.dist

###3. Chuyển sang chế độ development
$ composer development-enable

##Sửa lỗi
###Error : method zend\view\helper\headtitle::__tostring() must not throw an exception, caught zend\i18n\exception\extensionnotloadedexception
Instal intl extension: php5.6-intl
###composer : composer install; composer update; composer development-enable; composer dump-autoload
