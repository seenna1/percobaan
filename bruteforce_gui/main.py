import tkinter as tk
from tkinter import ttk, messagebox
import itertools
import string
import time
import threading
import os

def brute_force_generator(password, max_length=4):
    chars = string.ascii_lowercase
    for length in range(1, max_length + 1):
        total = len(chars) ** length
        for i, guess in enumerate(itertools.product(chars, repeat=length), start=1):
            yield i, ''.join(guess), total

def wordlist_generator(password, filepath):
    if not os.path.exists(filepath):
        return
    with open(filepath, 'r') as f:
        lines = f.readlines()
        for i, line in enumerate(lines, start=1):
            guess = line.strip()
            yield i, guess, len(lines)

class BruteForceApp:
    def __init__(self, root):
        self.root = root
        self.root.title("Brute Force Password Simulator")
        self.root.geometry("450x320")
        self.root.configure(bg="#1e1e1e")

        # Entry password
        tk.Label(root, text="Target Password (max 4 huruf kecil)", fg="white", bg="#1e1e1e").pack(pady=5)
        self.password_entry = tk.Entry(root, font=("Consolas", 14), justify="center")
        self.password_entry.pack(pady=5)

        # Pilihan metode
        self.method_var = tk.StringVar(value="brute")
        ttk.Combobox(root, textvariable=self.method_var, values=["brute", "wordlist"], state="readonly").pack(pady=5)

        # Toggle mode lambat/cepat
        self.visual_var = tk.BooleanVar(value=False)
        tk.Checkbutton(root, text="Mode visual (lambat)", variable=self.visual_var, bg="#1e1e1e", fg="white", selectcolor="#1e1e1e").pack(pady=5)

        # Tombol start
        self.start_button = tk.Button(root, text="Mulai Simulasi", command=self.start_simulation, bg="#2563eb", fg="white")
        self.start_button.pack(pady=10)

        # Progress dan hasil
        self.status_label = tk.Label(root, text="", fg="white", bg="#1e1e1e", font=("Consolas", 12))
        self.status_label.pack(pady=10)

        self.progress = ttk.Progressbar(root, length=300, mode="determinate")
        self.progress.pack(pady=5)

        self.result_label = tk.Label(root, text="", fg="lightgreen", bg="#1e1e1e", font=("Consolas", 12))
        self.result_label.pack(pady=10)

    def start_simulation(self):
        password = self.password_entry.get().strip()
        method = self.method_var.get()

        if not password.isalpha() or len(password) > 4 or not password.islower():
            messagebox.showerror("Error", "Password hanya boleh huruf kecil, maksimal 4 karakter.")
            return

        self.status_label.config(text="Memulai...")
        self.result_label.config(text="")
        self.progress["value"] = 0

        # Jalankan simulasi di thread terpisah
        threading.Thread(target=self.run_simulation, args=(password, method), daemon=True).start()

    def run_simulation(self, password, method):
        start_time = time.time()
        found = False

        if method == "brute":
            generator = brute_force_generator(password)
        else:
            generator = wordlist_generator(password, "wordlists/common_passwords.txt")

        try:
            for attempt, guess, total in generator:
                self.status_label.config(text=f"Mencoba: {guess}")
                self.progress["value"] = (attempt / total) * 100
                self.root.update()

                if guess == password:
                    found = True
                    break

                if self.visual_var.get():
                    time.sleep(0.02)  # hanya jika mode visual diaktifkan
        except:
            found = False

        duration = round(time.time() - start_time, 2)

        if found:
            self.result_label.config(
                text=f"✅ Password ditemukan: {password}\nPercobaan: {attempt} | {duration}s"
            )
        else:
            self.result_label.config(
                text="❌ Password tidak ditemukan."
            )
