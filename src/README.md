# Product Service

Bu servis, ürün yönetimi için geliştirilmiş bir mikroservistir. Laravel framework'ü kullanılarak geliştirilmiştir.

## Gereksinimler

- Docker
- Docker Compose

## Kurulum

1. Projeyi klonlayın
2. `.env.example` dosyasını `.env` olarak kopyalayın
3. Docker container'larını başlatın:

```bash
docker-compose up -d
```

## Servisler

Proje aşağıdaki servislerden oluşmaktadır:

1. **Webserver (Nginx)**
   - Port: 8080 (varsayılan, .env dosyasından değiştirilebilir)
   - Nginx web sunucusu olarak çalışır

2. **PHP-FPM**
   - PHP 8.3 versiyonu
   - Laravel uygulamasını çalıştırır

3. **PostgreSQL**
   - Port: 5432 (varsayılan, .env dosyasından değiştirilebilir)
   - Veritabanı sunucusu
   - Veriler `./data/postgresql_data` dizininde persist edilir

4. **Supervisor**
   - Queue worker'ları ve diğer arka plan işlemlerini yönetir

## API Endpointleri

### Ürün İşlemleri (v1)

#### 1. Ürün Oluşturma
- **Endpoint:** `POST /api/v1/products`
- **Açıklama:** Yeni bir ürün oluşturur
- **İstek Gövdesi:**
  ```json
  {
    "name": "Ürün Adı",
    "description": "Ürün Açıklaması",
    "price": 99.99,
    "stock": 100
  }
  ```

#### 2. Ürün Arama
- **Endpoint:** `GET /api/v1/products/search`
- **Açıklama:** Ürünleri arar ve filtreler
- **Query Parametreleri:**
  - `q`: Arama terimi
  - `min_price`: Minimum fiyat
  - `max_price`: Maksimum fiyat
  - `sort`: Sıralama kriteri (price_asc, price_desc, name_asc, name_desc)
  - `page`: Sayfa numarası
  - `per_page`: Sayfa başına ürün sayısı

## Veritabanı Yapılandırması

PostgreSQL veritabanı aşağıdaki bilgilerle yapılandırılmıştır:

- Database: `${POSTGRES_DATABASE}`
- Kullanıcı: `${POSTGRES_USER}`
- Şifre: `${POSTGRES_PASSWORD}`
- Port: `${POSTGRES_PORT}`

## Geliştirme

1. Container'ları başlatın:
```bash
docker-compose up -d
```

2. PHP container'ına bağlanın:
```bash
docker exec -it phpserver_product-service bash
```

3. Composer bağımlılıklarını yükleyin:
```bash
composer install
```

4. Migration'ları çalıştırın:
```bash
php artisan migrate --seed
```

## Notlar

- Tüm container'lar `shared_network` adlı bir Docker network'ünde çalışır
- Veritabanı verileri `./data/postgresql_data` dizininde saklanır