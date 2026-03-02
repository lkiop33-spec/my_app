# AR 애플리케이션 연동 API 명세서 (WorkList 중심)

본 문서는 WSSP(저숙련자 작업지원 플랫폼) 시스템과 현장 작업자가 사용하는 **AR(증강현실) 애플리케이션/단말기 간의 데이터 통신 규격**을 정의합니다. 현재는 작업 지시 및 수행 이력을 관리하는 `WorkList` 통신을 중점으로 작성되었습니다.

---

## 🔒 1. 공통 사항 (Common)
* **Base URL:** `http://{서버_IP_또는_도메인}/api`
* **Content-Type:** `application/json`
* **인증 (Authentication):** Laravel Sanctum 기반 API Token (Bearer Token) 사용. AR 앱은 로그인 시 발급받은 토큰을 모든 요청의 헤더에 포함해야 합니다.
  * `Authorization: Bearer {발급받은_API_토큰}`

---

## 📡 2. API Endpoints

### 2.1. 할당된 작업 목록 조회 (Fetch Pending Work Lists)
AR 앱 실행 시, 현재 로그인한 작업자(통신 중인 기기)에게 할당된 오늘의 작업 지시 목록을 가져옵니다.

* **URL:** `/work_lists`
* **Method:** `GET`
* **Query Parameters (Optional):**
  * `member_id`: 특정 작업자의 작업을 조회할 때 (기본값: 현재 토큰의 사용자)
  * `date`: 특정 날짜의 작업 조회 (예: `2026-03-02`)
* **Response (성공 - 200 OK):**
```json
{
  "success": true,
  "message": "작업 목록을 성공적으로 불러왔습니다.",
  "data": [
    {
      "id": 1,
      "memberIDX": 12,
      "member_name": "Nguyen Van A",
      "pcbIDX": 5,
      "pcb_name": "INF-ECU-MainBoard",
      "partList": "R-10K-0603, IC-MCU-32",
      "status": "pending",
      "wdate": "2026-03-02 09:00:00"
    },
    {
      "id": 2,
      "memberIDX": 12,
      "pcbIDX": 6,
      "pcb_name": "INF-BCM-SubBoard",
      "partList": "CON-12P-DIP",
      "status": "in_progress",
      "wdate": "2026-03-02 10:30:00"
    }
  ]
}
```

---

### 2.2. 신규 작업 로그 전송 (Create Work Log / Complete Task)
AR 앱에서 작업자가 특정 PCB의 부품 조립을 완료한 뒤, 앱이 자동으로 또는 사용자의 조작에 의해 작업 수행 이력을 서버에 저장합니다.

* **URL:** `/work_lists`
* **Method:** `POST`
* **Request Body:**
```json
{
  "pcbIDX": 5,
  "partList": "R-10K-0603, IC-MCU-32",
  "completion_time_seconds": 185, 
  "error_count": 0,
  "memo": "정상 조립 완료"
}
// memberIDX는 헤더의 토큰을 통해 서버가 자동으로 식별 및 주입합니댜.
```
* **Response (성공 - 201 Created):**
```json
{
  "success": true,
  "message": "작업 기록이 성공적으로 저장되었습니다.",
  "data": {
    "id": 54,
    "pcbIDX": 5,
    "memberIDX": 12,
    "partList": "R-10K-0603, IC-MCU-32",
    "wdate": "2026-03-02 19:30:45"
  }
}
```
* **Response (실패 - 422 Unprocessable Entity):**
```json
{
  "success": false,
  "message": "입력 데이터가 유효하지 않습니다.",
  "errors": {
    "pcbIDX": ["유효하지 않은 기판 ID입니다."]
  }
}
```

---

### 2.3. 특정 작업 상세 가이드 조회 (Get Work Details & AR Coordinates)
AR 앱이 특정 작업을 수행하기 위해, 대상 기판(`pcbIDX`)에 조립해야 할 부품들의 세부 스펙(`PartTable`) 및 AR 화면 렌더링용 바운딩 박스/좌표(`ProcessTable`, `PcbImageTable`) 정보가 엮인 상세 정보를 요청합니다. (WorkList와 조인된 종합 데이터)

* **URL:** `/work_lists/{id}/ar-guide`
* **Method:** `GET`
* **Response (성공 - 200 OK):**
```json
{
  "success": true,
  "data": {
    "work_id": 1,
    "target_pcb": {
      "id": 5,
      "name": "INF-ECU-MainBoard",
      "sizeX": 150,
      "sizeY": 100
    },
    // 화면 위에 AR 모델 및 테두리를 그리기 위한 좌표 가이드 라인
    "guide_coordinates": [
      {
        "process_step": 1,
        "part_name": "R-10K-0603",
        "instruction": "1번 위치에 10K 저항 부착",
        "x": 50,
        "y": 120,
        "w": 10,
        "h": 5
      },
      {
        "process_step": 2,
        "part_name": "IC-MCU-32",
        "instruction": "칩셋의 방향(쩜) 주의하여 결합",
        "x": 70,
        "y": 80,
        "w": 30,
        "h": 30
      }
    ],
    // 관련된 다국어 매뉴얼 URL (사용자 언어 설정에 맞춰 필터링 가능)
    "manuals": [
      {
        "name": "ECU 조립 표준서",
        "url": "http://{서버_IP}/storage/doc/ecu_man_ko.pdf"
      }
    ]
  }
}
```

---

## 🛠️ 3. 오류 코드 (Error Handling)
| HTTP Status        | Error Code           | 설명                         | 해결 방식                      |
| :----------------- | :------------------- | :--------------------------- | :----------------------------- |
| `401 Unauthorized` | `AUTH_TOKEN_EXPIRED` | API 토큰 만료 또는 없음      | 앱에서 재로그인 유도           |
| `403 Forbidden`    | `ACCESS_DENIED`      | 해당 작업에 대한 권한 없음   | 본인에게 할당된 작업인지 확인  |
| `404 Not Found`    | `WORK_NOT_FOUND`     | 요청한 작업 문서가 DB에 없음 | ID 값 확인                     |
| `500 Server Error` | `INTERNAL_ERROR`     | 서버 측 로직 예외 발생       | 서버 관리자에게 로그 확인 요청 |
