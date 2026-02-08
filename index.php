<?php
include 'db.php';
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>چت‌روم</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
<style>
:root {
    --bg-color: #e5ddd5;
    --chat-bg: rgba(255,255,255,0.15);
    --header-bg: rgba(0,0,0,0.35);
    --input-bg: rgba(0,0,0,0.35);
    --text-color: #222;
    --username-color: #555;
    --toggle-bg: #0065e1;
    --toggle-color: #fff;
}
[data-theme="dark"] {
    --bg-color: #0f2027;
    --chat-bg: rgba(0,0,0,0.35);
    --header-bg: rgba(0,0,0,0.35);
    --input-bg: rgba(0,0,0,0.35);
    --text-color: #fff;
    --username-color: #000000;
    --toggle-bg: #ffb600;
    --toggle-color: #222;
}

* { margin:0; padding:0; box-sizing:border-box; }
body { font-family:'Inter', Tahoma, sans-serif; background: var(--bg-color); color: var(--text-color); min-height:100vh; display:flex; justify-content:center; align-items:center; padding:10px; }

.chat-app {
    width: 100%;
    max-width: 420px;
    min-width: 280px;
    height: 90vh;
    min-height: 400px;
    background: var(--chat-bg);
    backdrop-filter: blur(18px);
    border-radius: 20px;
    display:flex;
    flex-direction:column;
    overflow:hidden;
}

.chat-header { padding: 15px; background: var(--header-bg); color:#fff; display:flex; justify-content:space-between; align-items:center; flex-wrap: wrap; gap:5px; }
.chat-header .user { font-weight:600; }
.chat-header a { color:#ff9b9b; text-decoration:none; font-size:13px; }

#themeToggle {
    cursor:pointer;
    border:none;
    padding:5px 12px;
    border-radius:5px;
    font-size:12px;
    background: var(--toggle-bg);
    color: var(--toggle-color);
    transition: 0.3s;
}

.chat-messages { flex:1; padding:10px; overflow-y:auto; display:flex; flex-direction:column; gap:10px; }

.message { max-width:80%; padding:10px 14px; border-radius:16px; animation:fadeIn .25s ease; line-height:1.4; font-size:14px; word-wrap: break-word; }
.message.me { align-self:flex-start; background: linear-gradient(135deg,#00c6ff,#0072ff); color:#fff; border-bottom-left-radius:4px; }
.message.other { align-self:flex-end; background: rgba(255,255,255,0.9); color:#222; border-bottom-right-radius:4px; }
.message .username { font-size:11px; opacity:.7; margin-bottom:4px; color: var(--username-color); }

.chat-input { padding:10px; display:flex; gap:10px; background: var(--input-bg); flex-wrap:wrap; }
.chat-input input { flex:1 1 60%; min-width: 60px; max-width:100%; border:none; outline:none; border-radius:30px; padding:10px 14px; font-size:14px; }
.chat-input button { flex: 0 0 40px; min-width:40px; height:40px; border-radius:50%; border:none; background:linear-gradient(135deg,#00c6ff,#0072ff); color:white; font-size:16px; cursor:pointer; }

@keyframes fadeIn { from{opacity:0; transform:translateY(6px);} to{opacity:1; transform:translateY(0);} }
.chat-messages::-webkit-scrollbar{ width:6px; } 
.chat-messages::-webkit-scrollbar-thumb{ background: rgba(255,255,255,0.3); border-radius:10px; }

@media (max-width: 480px){
    .chat-header, .chat-input { padding:8px; }
    .message { font-size:3.5vw; padding:8px 10px; }
    #themeToggle { font-size:10px; padding:4px 8px; }
    .chat-input input { font-size:3.5vw; }
    .chat-input button { font-size:5vw; height:10vw; width:10vw; }
}

@media (min-width:768px){
    .chat-input input { font-size:16px; }
    .chat-input button { font-size:18px; height:42px; width:42px; }
    .message { font-size:14px; padding:10px 14px; }
}
</style>
</head>
<body>

<div class="chat-app">
    <div class="chat-header">
        <div>👤 <?= $_SESSION['username'] ?></div>
        <div style="display:flex; gap:5px; align-items:center;">
            <button id="themeToggle">🌞 روشن</button>
            <a href="logout.php">خروج</a>
        </div>
    </div>

    <div class="chat-messages" id="chatBox"></div>

    <form class="chat-input" id="chatForm">
        <input id="messageInput" placeholder="پیام بنویس..." autocomplete="off">
        <button>➤</button>
    </form>
</div>

<script>
const chatBox = document.getElementById("chatBox");
const form = document.getElementById("chatForm");
const input = document.getElementById("messageInput");
const myUser = "<?= $_SESSION['username'] ?>";

const themeToggle = document.getElementById("themeToggle");

// بارگذاری تم اولیه
let savedTheme = localStorage.getItem("theme") || "light";
document.documentElement.setAttribute("data-theme", savedTheme);
themeToggle.textContent = savedTheme==="light"?"🌞 روشن":"🌙 تاریک";

// تغییر تم با یک دکمه toggle
themeToggle.addEventListener("click", ()=>{
    const currentTheme = document.documentElement.getAttribute("data-theme");
    const newTheme = currentTheme==="light"?"dark":"light";
    document.documentElement.setAttribute("data-theme", newTheme);
    localStorage.setItem("theme", newTheme);
    themeToggle.textContent = newTheme==="light"?"🌞 روشن":"🌙 تاریک";
});

let loadedMessageIds = new Set();

// لود پیام‌ها
function loadMessages() {
    fetch("fetch_messages.php")
        .then(res=>res.json())
        .then(data=>{
            const atBottom = chatBox.scrollHeight - chatBox.scrollTop <= chatBox.clientHeight + 20;
            data.forEach(m=>{
    if(!loadedMessageIds.has(m.id)){
        const div = document.createElement("div");
        div.className = "message "+(m.username===myUser?"me":"other");

        const time = new Date(m.created_at.replace(' ', 'T'))
            .toLocaleTimeString('fa-IR', { hour:'2-digit', minute:'2-digit' });

        div.innerHTML = `
            <div class="username">${m.username}</div>
            <div>${m.message}</div>
            <div style="font-size:10px;opacity:.6;margin-top:4px;">
                ${time}
            </div>
        `;

        chatBox.appendChild(div);
        loadedMessageIds.add(m.id);
    }
});

            if(atBottom) chatBox.scrollTop = chatBox.scrollHeight;
        });
}

// ارسال پیام
form.addEventListener("submit", e=>{
    e.preventDefault();
    const text = input.value.trim();
    if(!text) return;

    fetch("send.php",{
        method:"POST",
        headers:{"Content-Type":"application/x-www-form-urlencoded"},
        body:"message="+encodeURIComponent(text)
    }).then(()=>{
        input.value="";
        loadMessages();
        chatBox.scrollTop = chatBox.scrollHeight;
    });
});

loadMessages();
setInterval(loadMessages,1000);
</script>

</body>
</html>
