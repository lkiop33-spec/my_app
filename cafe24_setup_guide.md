# Cafe24 VPS 기반 라라벨 12 멀티 프로젝트 세팅 및 배포 가이드

본 문서는 현재 프로젝트의 서버 사양을 기반으로, Cafe24 가상서버(VPS) 환경에서 새로운 라라벨 12 프로젝트를 추가로 생성하고 배포하기 위한 가이드라인을 제공합니다.

---

## 1. 현재 서버 및 개발 스펙 정보

### 서버 환경 (Cafe24 SSD 가상서버 일반형)
*   **호스팅 ID:** `cotaxdt`
*   **대표 도메인:** `cotaxdt.cafe24.com`
*   **서버 타입:** SSD 가상서버 일반형 (VPS) - 루트(root) 권한 접속 및 웹서버 설정 직접 수정 가능
*   **도메인 연결 현황:** 약정 연결 도메인 총 6개 (현재 1개 사용 중, 5개 추가 연결 가능)
*   **SSH 접속 방식:** 패스워드 인증(Password Authentication) 방식 사용 (SSH 키 등록되어 있지 않음)

### 개발 환경 스펙
*   **PHP 버전:** PHP 8.2 이상 (`^8.2`)
*   **라라벨 버전:** Laravel 12.0 (`^12.0`)
*   **데이터베이스:** MySQL (`DB_CONNECTION=mysql`)
*   **빌드 도구:** Vite 7.0 (`^7.0.7`) + Tailwind CSS + AlpineJS

---

## 2. 신규 프로젝트 복사 시 챙겨야 할 설정 파일 목록

다른 프로젝트에서 동일한 스펙을 시작하려면, 아래 설정 파일들을 새 프로젝트의 기준으로 삼아 동기화해야 합니다.
1.  **`composer.json`**: PHP 및 라라벨 버전(`^12.0`) 규격 설정
2.  **`package.json`** 및 **`vite.config.js`**: 프론트엔드 패키지 사양 및 빌드 스크립트 구성
3.  **`.env.example`**: 환경 변수 구조 설정 (DB 연결 템플릿 정보 제공)

---

## 3. Cafe24 가상서버 멀티 프로젝트 추가 절차

신규 라라벨 프로젝트를 서버에 추가로 띄우고 서브도메인을 연결하는 단계별 프로세스입니다.

### [1단계] Cafe24 도메인 연결 설정
1. **Cafe24 호스팅 관리 콘솔** 로그인 (ID: `cotaxdt`)
2. **[호스팅관리] -> [도메인 연결관리]** 메뉴로 이동합니다.
3. 사용할 새 도메인(또는 서브도메인, 예: `new.yourdomain.com`)을 입력하여 서버에 연결합니다.
4. 네임서버 및 DNS(A 레코드) 설정이 가상서버 IP(`cotaxdt.cafe24.com`의 IP)를 가리키도록 설정합니다.

### [2단계] 서버 SSH 접속 및 프로젝트 생성
*   **실서버 실제 프로젝트 경로**: `/usr/share/nginx/www/cotax` (Nginx 웹루트 경로)

### [2단계] 서버 SSH 접속 및 프로젝트 경로 이동
1. 터미널 또는 SSH 클라이언트(예: PuTTY, Termius 등)를 사용해 서버에 `root` 계정으로 접속합니다.
2. 실서버 프로젝트 디렉토리로 이동합니다.
   ```bash
   cd /usr/share/nginx/www/cotax
   ```
3. 컴포저를 사용하여 새로운 라라벨 12 프로젝트를 생성합니다.
   ```bash
   composer create-project laravel/laravel:^12.0 new-project
   ```

### [3단계] 신규 데이터베이스(DB) 생성 및 환경 설정
1. MySQL/MariaDB 루트 계정으로 로그인합니다.
   ```bash
   mysql -u root -p
   ```
2. 새 프로젝트에서 사용할 데이터베이스를 생성합니다.
   ```sql
   CREATE DATABASE new_project_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```
3. 신규 프로젝트 폴더로 이동하여 `.env` 파일을 작성하고, 방금 생성한 DB 정보를 매핑합니다.
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=new_project_db
   DB_USERNAME=[DB_계정명]
   DB_PASSWORD=[DB_패스워드]
   ```
4. 앱 키 생성 및 마이그레이션을 실행합니다.
   ```bash
   php artisan key:generate
   php artisan migrate --force
   ```

### [4단계] 웹서버 가상 호스트(VirtualHost) 설정
연결한 도메인의 요청이 신규 프로젝트의 `public` 폴더로 바로 매핑되도록 가상 호스트 설정을 지정합니다.

#### **방법 A. Nginx를 사용하는 경우**
`/etc/nginx/sites-available/` 경로에 신규 서버 블록 설정을 생성하거나 기존 설정 파일의 하단에 아래 구성을 추가합니다.
```nginx
server {
    listen 80;
    server_name new.yourdomain.com; # 새로 연결한 도메인
    root /var/www/new-project/public; # 새 프로젝트의 public 폴더 경로

    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock; # 구동 중인 PHP FPM 소켓
    }
}
```
설정을 저장한 뒤 구문을 확인하고 Nginx를 재시작합니다.
```bash
sudo nginx -t
sudo systemctl restart nginx
```

#### **방법 B. Apache를 사용하는 경우**
Apache 설정 파일(예: `/etc/httpd/conf/httpd.conf` 또는 `/etc/apache2/sites-available/000-default.conf`)에 가상 호스트 설정을 추가합니다.
```apache
<VirtualHost *:80>
    ServerName new.yourdomain.com # 새로 연결한 도메인
    DocumentRoot /var/www/new-project/public # 새 프로젝트의 public 폴더 경로

    <Directory /var/www/new-project/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```
설정을 저장한 뒤 Apache를 재시작합니다.
```bash
sudo systemctl restart apache2 # CentOS 환경인 경우 restart httpd
```

### [5단계] 디렉토리 소유권 및 권한 조정
웹 브라우저에서 스토리지 쓰기 권한 부족 오류(`Permission Denied`)가 발생하지 않도록 웹서버 소유 그룹에 권한을 양도합니다.
```bash
cd /var/www/new-project
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```
*(※ 만약 웹서버 실행 사용자가 `www-data`가 아닌 다른 사용자(예: `nginx`, `apache` 등)일 경우 해당 명칭에 맞추어 `chown` 명령을 조율해야 합니다.)*
