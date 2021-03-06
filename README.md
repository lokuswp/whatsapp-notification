## 🪝 LokusWP 🤝 VendorName

Repository ini merupakan contoh integrasi notifikasi whatsapp untuk LokusWP.

Anda dapat membuat `addon` untuk integrasi notifikasi whatsapp dengan melakukan fork
pada repository ini, caranya

1. Fork repository ini di akun anda
2. Ganti nama sesuai dengan nama brand anda `lokuswp-vendorname`
3. Pastikan penamaan sesuai dengan standar yang ada
4. Setelah itu, lakukan perubahan kode di repository yang sudah di fork tadi
5. Mulai dari Namespacing, Penamaan, Constant, Logika Pengiriman dan Juga Endpoint API
6. Anda juga bisa menambah fitur baru sesuai kebutuhan di repostiory anda.
7. Hubungi kami melalui [Discord](https://discord.gg/mmufJWENN8) untuk menambahkan addon anda
   ke `Marketplace Addon LokusWP`

Setelah itu Ganti tulisan vendorname dengan nama brand anda\
`name` : Vendor Name\
`namespace` : VendorName\
`slug` : vendorname\
`constant` : VENDORNAME\
`file`: lokuswp-vendorname\
`token` : 'apikey' atau 'instance_key' ini adalah key untuk authentikasi, anda bisa
menyesuaikannya sesuai dengan penamaan di whatapp gateway anda.

🚩 Anda dapat menambah fitur baru sesuai kebutuhan di repostiory anda.

### Terimakasih

Semoga bisa membantu, jika ada pertanyaan atau menemukan bug, silahkan
kirimkan isu di repository ini. atau anda bisa ikut berkontribusi dan menambahkan fitur baru di repository ini dengan
melakukan pull request, agar fitur tersebut bisa terdistribusi dan digunakan
oleh vendor lainnya.

Logika pengiriman berada di file\
`src/includes/channel/class-notification-whatsapp:229 / method send()`

<hr>

### Fitur Integrasi

#### Dukungan Notifikasi LWCommerce

- [X] Notifikasi ketika pesanan masuk (pending)
- [X] Notifikasi ketika pesanan diproses (processing)
- [X] Notifikasi ketika pesanan dikirim (shipped)
- [X] Notifikasi ketika pesanan selesai (completed)

#### Dukungan Notifikasi LWDonation

- [X] Notifikasi ketika donasi masuk (pending)
- [X] Notifikasi ketika donasi selesai (completed)

