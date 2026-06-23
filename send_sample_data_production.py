import tkinter as tk
from tkinter import messagebox
from tkinter import ttk
import random
import datetime
import json
import urllib.request
import urllib.error
import ctypes

# Windows 고해상도(DPI) 환경에서 폰트 및 GUI 요소 흐려짐 방지 처리
try:
    ctypes.windll.shcore.SetProcessDpiAwareness(1)
except Exception:
    try:
        ctypes.windll.user32.SetProcessDPIAware()
    except Exception:
        pass

# Cafe24 실서버 API 엔드포인트 URL (HTTPS 적용)
API_URL = "https://cotax.kr/api/working_lists"

# 글로벌 제어 변수
is_simulating = False
simulated_count = 0

def generate_random_log():
    """
    pbds_error_reporter_failures_sample.log 와 완벽히 호환되는 
    실시간 공정 불량 로그 원본 문자열을 난수로 자동 생성합니다.
    """
    now = datetime.datetime.now()
    log_timestamp_str = now.strftime("%Y-%m-%d %H:%M:%S") + f",{random.randint(100, 999)}"
    
    # 임의의 본딩 불량 영역(area_id) 개수 설정 (1~5개)
    num_areas = random.randint(1, 5)
    error_bonding_area = []
    
    # 35개 영역 중 중복 없이 선택
    selected_areas = random.sample(range(1, 36), num_areas)
    
    for area_id in selected_areas:
        num_errors = random.randint(1, 2)
        errors = []
        for _ in range(num_errors):
            errors.append({
                "bonding_error_type": "INSUFFICIENT_BONDING",
                "x": random.randint(1, 99),
                "y": random.randint(1, 59)
            })
        
        error_bonding_area.append({
            "area_id": area_id,
            "errors": errors
        })
    
    # Python Dictionary 포맷 데이터 조립 (has_error: 1 고정, pcb_type: nx4 고정)
    dict_data = {
        "has_error": 1,
        "datetime": now.strftime("%Y-%m-%d %H:%M:%S.%f")[:-3],
        "pcb_type": "nx4",
        "error_bonding_area": error_bonding_area
    }
    
    # 로그 원본 규격 형식으로 조립
    json_str = json.dumps(dict_data, ensure_ascii=False)
    py_dict_str = json_str.replace('"', "'")
    
    log_line = f"{log_timestamp_str} [INFO] 데이터 전송 성공: {py_dict_str}"
    return py_dict_str, log_line

def send_data(worker_name, log_line):
    """
    urllib를 이용해 API로 POST 전송 후 성공 여부 리턴
    """
    global simulated_count
    payload = {
        "worker_name": worker_name,
        "text": log_line
    }
    
    headers = {
        "Content-Type": "application/json",
        "Accept": "application/json"
    }
    
    data = json.dumps(payload).encode('utf-8')
    req = urllib.request.Request(API_URL, data=data, headers=headers, method='POST')
    
    try:
        with urllib.request.urlopen(req, timeout=3) as response:
            status_code = response.status
            res_body = response.read().decode('utf-8')
            res_data = json.loads(res_body)
            
            if status_code == 201:
                simulated_count += 1
                lbl_counter.config(text=f"누적 송신 수량: {simulated_count} 건")
                res_no = res_data.get('data', {}).get('no', 'N/A')
                log_message(f"OK - {res_no} ({worker_name}) 전송 성공 (DB_ID: #{res_data.get('data', {}).get('id')})")
                return True
    except urllib.error.HTTPError as e:
        log_message(f"ERROR - HTTP {e.code} 응답")
    except urllib.error.URLError:
        log_message("ERROR - API 서버 연결 실패 (https://cotax.kr)")
        if is_simulating:
            toggle_simulation()
    except Exception as e:
        log_message(f"ERROR - {e}")
    return False

def send_single_simulated_data():
    selected_worker = combo_worker.get()
    if selected_worker == "자동 선택 (랜덤)":
        workers = ["김태균"]
        worker_name = random.choice(workers)
    else:
        worker_name = selected_worker
        
    _, raw_log = generate_random_log()
    send_data(worker_name, raw_log)

# --- GUI 동작 함수 ---

def toggle_simulation():
    global is_simulating
    if is_simulating:
        is_simulating = False
        btn_toggle.config(text="▶️ 시뮬레이터 가동 (1초)", bg="#E5E7EB", fg="black")
        lbl_status.config(text="대기 중", fg="#4B5563")
        log_message("SYSTEM - 실시간 자동 송신 중지")
    else:
        is_simulating = True
        btn_toggle.config(text="⏹️ 시뮬레이터 정지", bg="#DC2626", fg="white")
        lbl_status.config(text="1초 주기 전송 중...", fg="#DC2626")
        log_message("SYSTEM - 실시간 자동 송신 시작")
        run_simulation_loop()

def run_simulation_loop():
    if not is_simulating:
        return
    send_single_simulated_data()
    root.after(1000, run_simulation_loop)

def trigger_single_transmission():
    send_single_simulated_data()

def log_message(msg):
    txt_log.config(state=tk.NORMAL)
    timestamp = datetime.datetime.now().strftime("[%Y-%m-%d %H:%M:%S] ")
    txt_log.insert(tk.END, timestamp + msg + "\n")
    txt_log.see(tk.END)
    txt_log.config(state=tk.DISABLED)

# --- GUI 윈도우 레이아웃 빌드 (일반 산업용 프로그램 스타일) ---

root = tk.Tk()
root.title("AR Glass - Process Logs Transmission Tool (v1.0 - Production)")
root.geometry("520x420")
root.resizable(False, False)
root.configure(bg="#F3F4F6") # 산업용 그레이 기본 배경

# 1. 상단 타이틀 배너 (단정하고 묵직한 다크 네이비 테마)
frame_header = tk.Frame(root, bg="#1E293B", pady=8, bd=1, relief=tk.SOLID)
frame_header.pack(fill=tk.X)

lbl_title = tk.Label(frame_header, text="AR GLASS DATA MONITOR & SENDER (LIVE)", font=("바탕체", 12, "bold"), fg="#FFFFFF", bg="#1E293B")
lbl_title.pack()

# 2. 계기판 및 상태 영역 (선명한 단색 경계 보더)
frame_dashboard = tk.LabelFrame(root, text=" 시스템 상태 모니터 ", font=("바탕체", 9, "bold"), fg="#1E293B", bg="#F3F4F6", bd=1, relief=tk.SOLID, padx=15, pady=8)
frame_dashboard.pack(fill=tk.X, padx=15, pady=10)

lbl_status_title = tk.Label(frame_dashboard, text="동작 상태:", font=("바탕체", 9), fg="#4B5563", bg="#F3F4F6")
lbl_status_title.grid(row=0, column=0, sticky=tk.W)

lbl_status = tk.Label(frame_dashboard, text="대기 중", font=("바탕체", 9, "bold"), fg="#4B5563", bg="#F3F4F6")
lbl_status.grid(row=0, column=1, sticky=tk.W, padx=(5, 0))

lbl_counter = tk.Label(frame_dashboard, text="누적 송신 수량: 0 건", font=("바탕체", 9, "bold"), fg="#1E293B", bg="#F3F4F6")
lbl_counter.grid(row=0, column=2, sticky=tk.E, padx=(160, 0))

# 작업자 선택 드롭다운 메뉴 추가 (바탕체 적용)
lbl_worker_select = tk.Label(frame_dashboard, text="작업자 선택:", font=("바탕체", 9), fg="#4B5563", bg="#F3F4F6")
lbl_worker_select.grid(row=1, column=0, sticky=tk.W, pady=(8, 0))

combo_worker = ttk.Combobox(frame_dashboard, values=["자동 선택 (랜덤)", "김태균"], font=("바탕체", 9), state="readonly", width=15)
combo_worker.current(0)
combo_worker.grid(row=1, column=1, columnspan=2, sticky=tk.W, padx=(5, 0), pady=(8, 0))

# 3. 제어 버튼 영역 (표준 규격의 차분한 단색 버튼)
frame_controls = tk.Frame(root, bg="#F3F4F6")
frame_controls.pack(fill=tk.X, padx=15, pady=(0, 5))

btn_toggle = tk.Button(frame_controls, text="▶️ 시뮬레이터 가동 (1초)", font=("바탕체", 9, "bold"), bg="#E5E7EB", fg="black", activebackground="#D1D5DB", activeforeground="black", bd=1, relief=tk.SOLID, pady=6, cursor="hand2", command=toggle_simulation)
btn_toggle.pack(side=tk.LEFT, fill=tk.X, expand=True, padx=(0, 5))

btn_single = tk.Button(frame_controls, text="⚡ 1회 즉시 전송", font=("바탕체", 9, "bold"), bg="#E5E7EB", fg="black", activebackground="#D1D5DB", activeforeground="black", bd=1, relief=tk.SOLID, pady=6, cursor="hand2", command=trigger_single_transmission)
btn_single.pack(side=tk.LEFT, fill=tk.X, expand=True, padx=(5, 0))

# 4. 실시간 로그 피드백 텍스트 창 (전형적인 기계 콘솔 스타일)
frame_log = tk.LabelFrame(root, text=" 송신 데이터 실시간 출력 피드 ", font=("바탕체", 9, "bold"), fg="#1E293B", bg="#F3F4F6", bd=1, relief=tk.SOLID, padx=10, pady=5)
frame_log.pack(fill=tk.BOTH, expand=True, padx=15, pady=(0, 15))

scrollbar = tk.Scrollbar(frame_log)
scrollbar.pack(side=tk.RIGHT, fill=tk.Y)

txt_log = tk.Text(frame_log, yscrollcommand=scrollbar.set, font=("바탕체", 9), bg="#FFFFFF", fg="#1E293B", bd=1, relief=tk.SOLID, state=tk.DISABLED)
txt_log.pack(fill=tk.BOTH, expand=True)
scrollbar.config(command=txt_log.yview)

# 콘솔 초기 가이드
log_message("INFO - 시스템 시뮬레이터 초기화 완료 (실서버 모드).")
log_message("INFO - 운영 서버 주소: https://cotax.kr")

# 메인 루프 가동
root.mainloop()
