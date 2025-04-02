B1: Mở powershell
# Run as administrator...
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://php.new/install/windows/8.4'))
B2: Mở powershell 
composer global require laravel/installer
B3: Mở project laravel
npm install
npm run build
composer install
B4: tạo file .env
copy file .env t gửi
