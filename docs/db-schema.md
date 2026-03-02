# 데이터베이스 설계 문서 (Database Schema)

이 문서는 제공된 `infac_DB_ver02_addTable 03 v01.csv` 파일을 분석하여 변환한 데이터베이스 명세(Schema)입니다.

## 1. 테이블 명세 (Table Specifications)

### 시스템 핵심 데이터
#### 1. `work_lists` (현재작업정보 - 검출현황)
| 컬럼명      | 타입         | 제약조건           | 설명                 |
| :---------- | :----------- | :----------------- | :------------------- |
| `idx`       | bigInteger   | PK, Auto Increment | 고유 ID              |
| `wdate`     | datetime     | Not Null           | 등록일               |
| `partList`  | varchar(200) | Not Null           | 파트 목록            |
| `pcbIDX`    | integer      |                    | PCB ID (FK)          |
| `memberIDX` | integer      |                    | 작업자(회원) ID (FK) |

#### 2. `pcb_tables` (Pcb기판 정보)
| 컬럼명       | 타입         | 제약조건           | 설명           |
| :----------- | :----------- | :----------------- | :------------- |
| `idx`        | bigInteger   | PK, Auto Increment | 고유 ID        |
| `wdate`      | datetime     | Not Null           | 등록일         |
| `PCB_Number` | varchar(20)  | Unique, Not Null   | 부품 번호      |
| `Name_Type`  | varchar(100) | Not Null           | 이름과 유형    |
| `Image_File` | varchar(100) | Not Null           | 이미지 파일    |
| `Image_Side` | varchar(100) | Not Null           | 보드 윗면/앞면 |

#### 3. `part_tables` (부품정보)
| 컬럼명           | 타입         | 제약조건           | 설명                       |
| :--------------- | :----------- | :----------------- | :------------------------- |
| `idx`            | bigInteger   | PK, Auto Increment | 고유 ID                    |
| `wdate`          | datetime     | Not Null           | 등록일                     |
| `Part_Number`    | varchar(20)  | Unique, Not Null   | 부품 번호                  |
| `Name`           | varchar(10)  | Not Null           | 부품 명                    |
| `PCB_Number`     | integer      | Not Null           | 보드 번호 (FK: pcb_tables) |
| `Process_Class`  | varchar(100) | Nullable           | 수삽공정                   |
| `Process_Name`   | varchar(100) | Nullable           | 수삽                       |
| `Process_Detail` | varchar(100) | Unique             | 작업번호                   |
| `Side`           | varchar(100) | Nullable           | 작업 면(윗면/앞면)         |
| `Image_File`     | varchar(100) | Nullable           | 장착된 대표 이미지         |
| `Quantity`       | varchar(100) | Nullable           | 수량                       |
| `Location_1`     | varchar(100) | Nullable           | 장착 위치 1                |
| `Location_2`     | varchar(100) | Nullable           | 장착 위치 2                |
| `Location_3`     | varchar(100) | Nullable           | 장착 위치 3                |
| `Location_4`     | varchar(100) | Nullable           | 장착 위치 4                |

#### 4. `process_tables` (공정정보)
| 컬럼명     | 타입         | 제약조건           | 설명              |
| :--------- | :----------- | :----------------- | :---------------- |
| `idx`      | bigInteger   | PK, Auto Increment | 고유 ID           |
| `wdate`    | datetime     | Not Null           | 등록일            |
| `Code`     | varchar(100) | Not Null           | 공정 코드 (A_01)  |
| `Name`     | varchar(10)  | Unique, Not Null   | 레이저마킹        |
| `Class`    | varchar(100) | Nullable           | 분류 (Automation) |
| `Sequence` | varchar(100) | Nullable           | 순서              |

#### 5. `pcb_image_tables` (PCB 이미지 정보)
| 컬럼명       | 타입         | 제약조건           | 설명                       |
| :----------- | :----------- | :----------------- | :------------------------- |
| `idx`        | bigInteger   | PK, Auto Increment | 고유 ID                    |
| `wdate`      | datetime     | Not Null           | 등록일                     |
| `PCB_Number` | integer      | Not Null           | 보드 번호 (FK: pcb_tables) |
| `Image`      | varchar(100) | Not Null           | 이미지명                   |
| `BoundBox`   | varchar(100) | Nullable           | Bounding Box               |
| `Other`      | varchar(100) | Nullable           | 기타                       |

---

### 사용자 및 권한 관리 (MEMBER DATA)
#### 6. `members` (회원정보)
| 컬럼명        | 타입         | 제약조건           | 설명                   |
| :------------ | :----------- | :----------------- | :--------------------- |
| `idx`         | bigInteger   | PK, Auto Increment | 고유 ID                |
| `wdate`       | datetime     | Not Null           | 등록일                 |
| `name`        | varchar(10)  | Not Null           | 이름                   |
| `location`    | varchar(100) | Nullable           | 근무지 (FK: locations) |
| `part`        | varchar(100) | Nullable           | 부서 (FK: parts)       |
| `account_id`  | varchar(20)  | Unique, Not Null   | 아이디                 |
| `password`    | varchar(255) | Not Null           | 패스워드(암호화)       |
| `last_access` | datetime     | Not Null           | 최근 접속              |
| `email`       | varchar(100) | Not Null           | 이메일                 |
| `level`       | varchar(100) | Nullable           | 권한 (FK: levels)      |
| `phone`       | varchar(100) | Nullable           | 전화번호               |
| `interphone`  | varchar(100) | Nullable           | 구내 번호              |
| `photo`       | varchar(100) | Nullable           | 사진                   |
| `join_date`   | datetime     | Not Null           | 가입일                 |

#### 7. `locations` (근무지 정보)
| 컬럼명    | 타입         | 제약조건           | 설명     |
| :-------- | :----------- | :----------------- | :------- |
| `idx`     | bigInteger   | PK, Auto Increment | 고유 ID  |
| `wdate`   | datetime     | Not Null           | 등록일   |
| `name`    | varchar(10)  | Unique, Not Null   | 근무지명 |
| `address` | varchar(100) | Nullable           | 주소     |
| `phone`   | varchar(100) | Nullable           | 전화번호 |

#### 8. `parts` (부서 정보)
| 컬럼명  | 타입        | 제약조건           | 설명      |
| :------ | :---------- | :----------------- | :-------- |
| `idx`   | bigInteger  | PK, Auto Increment | 고유 ID   |
| `wdate` | datetime    | Not Null           | 등록일    |
| `name`  | varchar(10) | Unique, Not Null   | 부서이름  |
| `level` | integer     | Not Null           | 그룹 레벨 |

#### 9. `levels` (권한 정보)
| 컬럼명  | 타입        | 제약조건           | 설명          |
| :------ | :---------- | :----------------- | :------------ |
| `idx`   | bigInteger  | PK, Auto Increment | 고유 ID       |
| `wdate` | datetime    | Not Null           | 등록일        |
| `name`  | varchar(10) | Unique, Not Null   | 권한/그룹이름 |
| `level` | integer     | Not Null           | 그룹 레벨     |

---

### 문서 관리 (DOCUMENT)
#### 10. `doc_lists`
| 컬럼명      | 타입        | 제약조건           | 설명                 |
| :---------- | :---------- | :----------------- | :------------------- |
| `idx`       | bigInteger  | PK, Auto Increment | 고유 ID              |
| `wdate`     | datetime    | Not Null           | 등록일               |
| `type`      | integer     | Not Null           | 문서타입 (FK: types) |
| `name`      | varchar(10) | Unique, Not Null   | 문서이름             |
| `filename`  | varchar(20) | Not Null           | 파일이름             |
| `path`      | varchar(20) | Not Null           | 서버 경로            |
| `language`  | integer     | Nullable           | 언어 (FK: languages) |
| `reference` | varchar(20) | Nullable           | 관련분야             |

#### 11. `types` (문서타입)
| 컬럼명  | 타입        | 제약조건           | 설명                 |
| :------ | :---------- | :----------------- | :------------------- |
| `idx`   | bigInteger  | PK, Auto Increment | 고유 ID              |
| `wdate` | datetime    | Not Null           | 등록일               |
| `mtype` | varchar(10) | Unique, Not Null   | 타입명 (doc, pdf 등) |

#### 12. `languages` (언어)
| 컬럼명      | 타입        | 제약조건           | 설명             |
| :---------- | :---------- | :----------------- | :--------------- |
| `idx`       | bigInteger  | PK, Auto Increment | 고유 ID          |
| `wdate`     | datetime    | Not Null           | 등록일           |
| `mlanguage` | varchar(10) | Unique, Not Null   | 언어명 (english) |

---

### 기타 관리
#### 13. `forbiddens` (금지어 목록)
| 컬럼명  | 타입        | 제약조건           | 설명    |
| :------ | :---------- | :----------------- | :------ |
| `idx`   | bigInteger  | PK, Auto Increment | 고유 ID |
| `wdate` | datetime    | Not Null           | 등록일  |
| `text`  | varchar(10) | Unique, Not Null   | 금지어  |

#### 14. `devices` (단말기/앱 관리)
| 컬럼명     | 타입        | 제약조건           | 설명                             |
| :--------- | :---------- | :----------------- | :------------------------------- |
| `idx`      | bigInteger  | PK, Auto Increment | 고유 ID                          |
| `wdate`    | datetime    | Not Null           | 등록일                           |
| `name`     | varchar(20) | Unique, Not Null   | 단말기명                         |
| `password` | varchar(20) | Unique, Not Null   | 비밀번호                         |
| `location` | integer     | Not Null           | 단말기 사용 위치 (FK: locations) |
| `version`  | varchar(20) | Not Null           | 설치 앱 버전                     |

> **참고사항 (추후 반영 예정):**
> *   `connector_tables`
> *   `bonding_structure_tables`
> *   `routing_tables`
