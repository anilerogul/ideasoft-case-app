# IdeaSoft Örnek Çalışma

Lütfen bilgisayarınızda Docker, Git ve Composer kurulu olması gerektiğini unutmayın.

---
### MacOs & Ubuntu
```
./vendor/bin/sail up -d
```

### Windows
```
bash ./vendor/bin/sail up -d
```

Aşağıdaki komut ile veritabanında olması gereken tablo ve verileri oluşturabilirsiniz.

```
./vendor/bin/sail artisan migrate:fresh --seed
```

## Yeni bir disocunt eklemek için:
- Aşağıdaki örnek json body ile `localhost/api/discounts` endpointine `POST` isteği atılmalıdır.
```
{
    "name": "BUY_6_GET_1", // Kurala uygun isim verebilirsiniz 
    "condition_type": 2, // 1=Sipariş toplamı, 2=Kategori, 3=Ürün
    "condition_rule": 5, // 1=Equal, 2=Less than, 3=Less Than or Equal, 4=Greater Than, 5=Greater Than or Equal
    "condition_value": 4, // İndirim uygulanacak category_id veya product_id. Eğer sipariş toplamına indirim uygulanacak ise NULL olmalıdır.
    "type": 3, // 1=Yüzdelik indirim, 2=Sabit miktar, 3=Ücretsiz ürün
    "apply_type": 1, // 1=Sipariş toplamına uygulanacak indirim tipi, 2=Spesifik ürün indirimi
    "buy": 6, // Minimum alınması gereken ürün adedi veya sipariş toplamı
    "get": 1 // Verilecek ücretsiz ürün adedi veya yüzdelik indirim miktarı veya sabit miktar
} 
```
Ayrıca ilgili inceleyebilirsiniz: `2022_10_10_180225_create_discounts_table`
