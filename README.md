# 💬 PHP Chat Room

A modern real-time chat room built with **PHP + SQLite + AJAX**  
Designed with a glassmorphism UI and dark/light theme support.

---

## ✨ Features

- 🔐 Session-based login system
- 💬 Real-time chat using AJAX (no page refresh)
- 😀 Emoji support
- 🌓 Dark / Light mode toggle
- ⏱ Message timestamps
- 📱 Fully responsive (mobile & desktop)
- 💾 SQLite database (auto-created on first run)

---

## 🧠 Performance & Hosting

This chat room is designed to be **lightweight and optimized**.

- 🚀 Runs smoothly even on **low-end hosting** (as low as **512MB RAM**)
- 💾 Uses **SQLite**, no heavy database server required
- 🧹 Automatically keeps only the **last 100 messages**
- 🗑 Older messages are deleted automatically to reduce disk usage
- ⚡ Optimized AJAX polling for fast and efficient message updates

Perfect for small VPS, shared hosting, or minimal server environments.

---

## 🛠 Technologies Used

- PHP (PDO)
- SQLite
- JavaScript (Fetch API)
- HTML5 / CSS3
- Google Fonts (Inter)

---

## 🚀 Installation

Follow these steps to run the project on your host:

1. **Clone or download the repository**
```bash
git clone https://github.com/mmahdiTor/chatRoom.git
```

2. **Upload the files to your host**  
Upload all project files to your hosting panel  
(cPanel / DirectAdmin / etc)

3. **Run the project**  
Open your domain in the browser  
The database will be created automatically on first run

4. **Login**  
Default users are defined inside `login.php`

---

## 📸 Screenshots

### Chat Room

<table>
  <thead>
    <tr>
      <th width="50%">Light Mode</th>
      <th width="50%">Dark Mode</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td align="center">
        <img src="./screenshots/Screenshot 2.png" width="100%" alt="Chat Light Mode">
      </td>
      <td align="center">
        <img src="./screenshots/Screenshot 1.png" width="100%" alt="Chat Dark Mode">
      </td>
    </tr>
  </tbody>
</table>

<br>

### Login Page

<table>
  <tbody>
    <tr>
      <td align="center">
        <img src="./screenshots/Screenshot 3.png" width="70%" alt="Login Page">
      </td>
    </tr>
  </tbody>
</table>

---

## 👤 Author

Developed by MahdiTor

---

## 📄 License

This project is licensed under the **MIT License**  
Feel free to use, modify, and distribute it.

---

⭐ If you like this project, don’t forget to give it a star on GitHub!
