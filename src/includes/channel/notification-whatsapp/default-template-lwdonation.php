<?php

$template_pending_for_user = 'Pesanan : *[{{status_text}}]*

Hi *{{name}}*
Terimakasih telah melakukan pemesanan
Berikut ini adalah detail pesanan anda:
ID Pesanan : *#{{order_id}}*

*Detail Pesanan*
-------------------------------------------------------
Plugin LWCommerce 
🏷️ 2 x Rp 150.000 = Rp 300.000
Plugin LWDonation
🏷️ 1 x Rp 480.000 = Rp 480.000
-------------------------------------------------------
Pengiriman via JNE REG : 
👉 Rp 15.000
Diskon PreSale LWDonation : 
👉 -Rp 100.000
-------------------------------------------------------
Total : *Rp 695.000*

Segera lakukan pembayaran
agar pesanan anda dapat segera kami proses.

*Pembayaran*
{{payment}}

Salam Hangat
*LWCommerce*

_Tolong abaikan pesan ini jika anda tidak pernah melakukan pemesanan_ 😊';

$template_completed_for_user = 'Pesanan : *[{{status_text}}]*

Terimakasih *{{name}}*
telah membeli produk kami
jika terdapat kendala, silahkan chat kami
di nomor whatsapp ini 😊

Salam Hangat
*LWCommerce*';

$template_cancelled_for_user = "Pesanan : *[{{status_text}}]*

Mohon maaf, pesanan anda kami batalkan
kami akan segera menghubungi anda.

Salam Hangat
*LWCommerce*";