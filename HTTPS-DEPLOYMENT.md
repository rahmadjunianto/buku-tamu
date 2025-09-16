# HTTPS Configuration Guide

## Problem
Mixed Content error occurs when a page is loaded over HTTPS but makes requests to HTTP endpoints:
```
Mixed Content: The page at 'https://buku-tamu.simaru.my.id/admin/whatsapp' was loaded over HTTPS, but requested an insecure XMLHttpRequest endpoint 'http://buku-tamu.simaru.my.id/admin/whatsapp/test-message'. This request has been blocked; the content must be served over HTTPS.
```

## Solution Implementation

### 1. Force HTTPS in AppServiceProvider
File: `app/Providers/AppServiceProvider.php`
- Added URL::forceScheme('https') for production and proxy environments
- Detects X-Forwarded-Proto header for proxy setups

### 2. HTTPS Middleware
File: `app/Http/Middleware/ForceHttps.php`
- Redirects HTTP to HTTPS in production
- Adds security headers (HSTS, CSP)
- Registered in global middleware stack

### 3. Trust Proxies Configuration
File: `app/Http/Middleware/TrustProxies.php`
- Set `$proxies = '*'` to trust all proxies
- Properly handles X-Forwarded-Proto headers

### 4. JavaScript HTTPS Helper
File: `public/js/https-helper.js`
- Automatically converts HTTP URLs to HTTPS in AJAX requests
- Overrides jQuery, fetch, and XMLHttpRequest
- Added to both AdminLTE and guest layouts

### 5. Environment Configuration
File: `.env.production`
```
APP_URL=https://buku-tamu.simaru.my.id
APP_ENV=production
APP_DEBUG=false
FORCE_HTTPS=true
```

## Deployment Steps

### 1. Update Environment
```bash
# Copy production environment
cp .env.production .env

# Update APP_URL to your domain
APP_URL=https://your-domain.com
```

### 2. Clear Cache
```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

### 3. Web Server Configuration

#### Nginx
```nginx
server {
    listen 80;
    server_name your-domain.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name your-domain.com;

    # SSL Configuration
    ssl_certificate /path/to/ssl.crt;
    ssl_certificate_key /path/to/ssl.key;

    # Security Headers
    add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;
    add_header X-Frame-Options DENY always;
    add_header X-Content-Type-Options nosniff always;

    # Proxy headers for Laravel
    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    proxy_set_header X-Forwarded-Proto $scheme;
    proxy_set_header Host $host;

    # Laravel configuration
    root /path/to/laravel/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

#### Apache
```apache
<VirtualHost *:80>
    ServerName your-domain.com
    Redirect permanent / https://your-domain.com/
</VirtualHost>

<VirtualHost *:443>
    ServerName your-domain.com
    DocumentRoot /path/to/laravel/public

    SSLEngine on
    SSLCertificateFile /path/to/ssl.crt
    SSLCertificateKeyFile /path/to/ssl.key

    # Security Headers
    Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains"
    Header always set X-Frame-Options DENY
    Header always set X-Content-Type-Options nosniff

    # Proxy headers
    SetEnvIf X-Forwarded-Proto "https" HTTPS=on

    <Directory /path/to/laravel/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

## Testing

### 1. Check HTTPS Redirect
```bash
curl -I http://your-domain.com
# Should return 301 redirect to https://
```

### 2. Verify Security Headers
```bash
curl -I https://your-domain.com
# Should include Strict-Transport-Security header
```

### 3. Test AJAX Requests
- Open browser dev tools
- Navigate to admin panel
- Check Network tab for all requests using HTTPS

## Troubleshooting

### Mixed Content Still Occurs
1. Clear all caches: `php artisan optimize:clear`
2. Check APP_URL in .env
3. Verify proxy headers in web server config
4. Ensure HTTPS helper script is loaded

### SSL Certificate Issues
1. Verify certificate installation
2. Check certificate chain
3. Test with SSL Labs: https://www.ssllabs.com/ssltest/

### Performance Issues
1. Enable GZIP compression
2. Configure proper caching headers
3. Use CDN for static assets

## Security Best Practices

1. **HSTS**: Implemented via middleware
2. **CSP**: Added upgrade-insecure-requests directive
3. **Certificate**: Use strong SSL/TLS configuration
4. **Updates**: Keep Laravel and dependencies updated
5. **Monitoring**: Monitor for mixed content warnings

## Files Modified

1. `app/Providers/AppServiceProvider.php` - Force HTTPS URLs
2. `app/Http/Middleware/ForceHttps.php` - HTTPS middleware
3. `app/Http/Middleware/TrustProxies.php` - Proxy configuration
4. `app/Http/Kernel.php` - Middleware registration
5. `public/js/https-helper.js` - JavaScript HTTPS helper
6. `config/adminlte.php` - Added HTTPS helper plugin
7. `resources/views/guest/layout.blade.php` - Added HTTPS helper script
8. `resources/views/admin/whatsapp/index.blade.php` - Updated AJAX calls
9. `.env.production` - Production environment template
