# owners-association

### Setting Up Cron Job for Laravel (Production Guide)

---

### 🛠️ Step 1: Open Crontab Editor

Connect to your production server via SSH, then open the crontab editor:

```bash
crontab -e
```

---

### 🧩 Step 2: Add Laravel Scheduler Cron Entry

Paste the following line into the crontab to run Laravel’s scheduler every minute:

```bash
* * * * * cd /path/to/your/project && php artisan schedule:run >> /dev/null 2>&1
```

📌 **Note:**
Replace `/path/to/your/project` with the **full path** to your Laravel project directory.

---

### 💾 Step 3: Save and Exit

Save the file and exit the editor.
The cron daemon will now automatically run Laravel's scheduled tasks.

---

### ✅ Verify Cron is Working

**📝 Check Laravel Logs:**

```bash
tail -f storage/logs/laravel.log
```

**🧪 Manually Trigger Scheduler:**

```bash
php artisan schedule:run
```

---

### 💡 Pro Tip

Ensure your server timezone matches Laravel’s timezone to avoid scheduling confusion.

---

### 🔒 Security Note

Avoid using root for crontab unless necessary. Use the appropriate deployment user instead.
