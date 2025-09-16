1. login jika sudah login tampilkan device

curl \
 --request GET 'https://gowa.simaru.my.id/app/login' \
 --user "admin:admin"

 curl \
 --request GET 'https://gowa.simaru.my.id/app/devices' \
 --user "admin:admin"

2. logout

curl \
 --request GET 'https://gowa.simaru.my.id/app/logout' \
 --user "admin:admin"

 3. kirim pesan

 curl \
 --request POST 'https://gowa.simaru.my.id/send/message' \
 --user "username:password" \
 --header "Content-Type: application/json" \
 --data '{"phone":"6285853335400@s.whatsapp.net","message":"selamat malam","is_forwarded":false}'