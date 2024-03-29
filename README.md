# Sistem Inventory

Sistem Inventory dibuat menggunakan Laravel 9 dan Bootstrap 4

## ⚙ Prerequisites
- PHP >= 8.1.10
- XAMPP Control Panel v3.3.0
- npm >= 8.19.2
- Composer >= 2.4.1

## 🛠 Installation
- Create db name db_sisteminventory
- Use cmd/terminal/gitbash
- Copy and Paste .env.example then rename to .env
- add ```FILESYSTEM_DISK=public```  to .env

```bash
# install composer package
composer install

php artisan key:generate

php artisan storage:link

# insert table database
php artisan migrate

# insert dummy data
php artisan db:seed --class=DatabaseSeeder

# or just do this instead
php artisan migrate:fresh --seed
```

## 🚀 Usage
- use cmd/terminal/gitbash
- locate the project folder
```bash
cd ../../inventory-deka

php artisan serve
```

## Contributing

Pull requests are welcome. For major changes, please open an issue first
to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License

[MIT](https://choosealicense.com/licenses/mit/)
