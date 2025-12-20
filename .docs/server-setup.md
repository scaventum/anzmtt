# Server setup

## Install dependencies

```
# Update system
sudo apt update && sudo apt upgrade -y

# Install PHP 8.3 and required extensions
sudo apt install software-properties-common -y
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
sudo apt install php8.3 php8.3-cli php8.3-mbstring php8.3-xml php8.3-mysql php8.3-bcmath php8.3-curl unzip git composer nginx -y

# Create app directory
sudo mkdir -p /var/www/anzmtt-uat
sudo chown -R ubuntu:ubuntu /var/www/anzmtt-uat
```

## Create nginx file

Create `/etc/nginx/sites-available/anzmtt-uat`

```
server {
    listen 80;
    server_name your-domain.com;  # Replace with actual domain or Lightsail IP

    root /var/www/anzmtt-uat/public;

    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

## Enable site and restart services

sudo ln -s /etc/nginx/sites-available/anzmtt-uat /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
sudo systemctl enable php8.3-fpm
