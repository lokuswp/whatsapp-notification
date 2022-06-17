<?php

$template_pending_for_user = '📦 Pesanan : *{{status_text}}*

Hi *{{name}}*
Terimakasih telah melakukan pemesanan
Berikut ini adalah detail pesanan anda:
ID Pesanan : *#{{order_id}}*

*Detail Pesanan*
{{summary}}

Segera lakukan pembayaran
agar pesanan anda dapat segera kami proses.

*Pembayaran*
{{payment}}

Salam Hangat
*LWCommerce*

_Tolong abaikan pesan ini jika anda tidak pernah melakukan pemesanan_ 😊';

$template_processing_for_user = "📦 Pesanan : *{{status_text}}*

Sedang diproses
Harap menunggu, kami akan segera menghubungi anda.
Jika pesanan sudah dikirim atau dibatalkan.

Salam Hangat
*LWCommerce*";

$template_shipped_for_user = "📦 Pesanan : *{{status_text}}*

Sedang dalam proses pengiriman.
Silahkan ditunggu
{{shipping}}

Salam Hangat
*LWCommerce*";

$template_completed_for_user = '📦 Pesanan : *{{status_text}}*

Terimakasih *{{name}}*
telah membeli produk kami
jika terdapat kendala, silahkan chat kami
di nomor whatsapp ini 😊

Salam Hangat
*LWCommerce*';

$template_cancelled_for_user = "📦 Pesanan : *{{status_text}}*

Mohon maaf, pesanan anda kami batalkan
kami akan segera menghubungi anda.

Salam Hangat
*LWCommerce*";